<?php

namespace Revolution;
if(!defined('IN_INDEX')) { die('Sorry, you cannot access this file.'); }
class users implements iUsers
{
	
	/*-------------------------------Authenticate-------------------------------------*/ 
	
	final public function isLogged()
	{
		if(isset($_SESSION['user']['id']))
		{
			return true;
		}
		
		return false;
	}
	
	/*-------------------------------Checking of submitted data-------------------------------------*/ 
	
	final public function validName($username) 	
	{
		if(strlen($username) <= 25 && ctype_alnum($username)) 		
	 	{ 			
	 		return true; 		
	 	} 		 		
	 	
	 	return false; 	
	} 	 	
		 
	final public function validEmail($email) 	
	{ 		
		return preg_match("/^[a-z0-9_\.-]+@([a-z0-9]+([\-]+[a-z0-9]+)*\.)+[a-z]{2,7}$/i", $email); 	
	} 	 	
	
	final public function validSecKey($seckey)
	{
		if(is_numeric($seckey) && strlen($seckey) == 4)
		{
			return true;
		}
		
		return false;
	}
	
	final public function nameTaken($username) 	
	{ 		
	 	global $engine; 		
	 	
		if($engine->num_rows("SELECT * FROM users WHERE username = '" . $username . "' LIMIT 1") > 0)
		{
			return true;
		} 	
		
		return false;
	} 
	
	final public function emailTaken($email)
	{
		global $engine;
		
		if($engine->num_rows("SELECT * FROM users WHERE mail = '" . $email . "' LIMIT 1") > 0)
		{
			return true;
		}
		
		return false;
	}
		
        final public function userValidation($username, $password)
        {
                global $engine, $core;
               $stmt = $engine->prepare("SELECT password FROM users WHERE username = ? LIMIT 1");
               $stmt->execute([$username]);
               $hash = $stmt->fetchColumn();
               if($hash && $core->verifyHash($password, $hash))
               {
                       return true;
               }

                return false;
        }
	
	/*-------------------------------Stuff related to bans-------------------------------------*/ 
	
	final public function isBanned($value)
	{
		global $engine;
		if($engine->num_rows("SELECT * FROM bans WHERE value = '" . $value . "' LIMIT 1") > 0)
		{
			return true;
		}
			
		return false;
	}
	
	final public function getReason($value)
	{
		global $engine;
		return $engine->result("SELECT reason FROM bans WHERE value = '" . $value . "' LIMIT 1");
	}
	
	final public function hasClones($ip)
	{
		global $engine;
		if($engine->num_rows("SELECT * FROM users WHERE ip_reg = '" . $_SERVER['REMOTE_ADDR'] . "'") == 1)
		{
			return true;
		}
		
		return false;
	}
	
	/*-------------------------------Login or Register user-------------------------------------*/ 
	
	final public function register()
	{
		global $core, $template, $_CONFIG;
		
		if(isset($_POST['register']))
		{
			unset($template->form->error);
			
			$template->form->setData();
				
			if($this->validName($template->form->reg_username))
			{
				if(!$this->nameTaken($template->form->reg_username))
				{
					if($this->validEmail($template->form->reg_email))
					{
						if(!$this->emailTaken($template->form->reg_email))
						{
							if(strlen($template->form->reg_password) > 6)
							{
								if($template->form->reg_password == $template->form->reg_rep_password)
								{
									if(isset($template->form->reg_seckey))
									{
										if($this->validSecKey($template->form->reg_seckey))
										{
											//Continue
										}
										else
										{
											$template->form->error = 'Secret key must only have 4 numbers';
											return;
										}
									}
									if($this->isBanned($_SERVER['REMOTE_ADDR']) == false)
									{
										if(!$this->hasClones($_SERVER['REMOTE_ADDR']))
										{
											if(!isset($template->form->reg_gender)) { $template->form->reg_gender = 'M'; }
											if(!isset($template->form->reg_figure)) { $template->form->reg_figure = $_CONFIG['hotel']['figure']; }
										
                                                                               $this->addUser($template->form->reg_username, $core->passwordHash($template->form->reg_password), $template->form->reg_email, $_CONFIG['hotel']['motto'], $_CONFIG['hotel']['credits'], $_CONFIG['hotel']['pixels'], 1, $template->form->reg_figure, $template->form->reg_gender, $core->hashed($template->form->reg_key));
							
											$this->turnOn($template->form->reg_username);
									
											header('Location: ' . $_CONFIG['hotel']['url'] . '/me');
											exit;
										}
										else
										{
											$template->form->error = 'Sorry, but you cannot register twice';
										}
									}
									else
									{
										$template->form->error = 'Sorry, it appears you are IP banned.<br />';
										$template->form->error .= 'Reason: ' . $this->getReason($_SERVER['REMOTE_ADDR']);
										return;
									}
								}
								else	
								{
									$template->form->error = 'Password does not match repeated password';
									return;
								}

							}
							else
							{
								$template->form->error = 'Password must have more than 6 characters';
								return;
							}
						}
						else
						{
							$template->form->error = 'Email: <b>' . $template->form->reg_email . '</b> is already registered';
							return;
						}
					}
					else
					{
						$template->form->error = 'Email is not valid';
						return;
					}
				}
				else
				{
					$template->form->error = 'Username is already registered';
					return;
				}
			}
			else
			{
				$template->form->error = 'Username is invalid';
				return;
			}
		}
	}	
	
	final public function login()
	{
		global $template, $_CONFIG, $core;
		
		if(isset($_POST['login']))
		{
			$template->form->setData();
			unset($template->form->error);
			
			if($this->nameTaken($template->form->log_username))
			{
				if($this->isBanned($template->form->log_username) == false || $this->isBanned($_SERVER['REMOTE_ADDR']) == false)
				{
                                        if($this->userValidation($template->form->log_username, $template->form->log_password))
					{
						$this->turnOn($template->form->log_username);
						$this->updateUser($_SESSION['user']['id'], 'ip_last', $_SERVER['REMOTE_ADDR']);
						$template->form->unsetData();
						header('Location: ' . $_CONFIG['hotel']['url'] . '/me');
						exit;
					}
					else
					{
						$template->form->error = 'Details do not match';
						return;
					}
				}
				else
				{
					$template->form->error = 'Sorry, it appears this user is banned<br />';
					$template->form->error .= 'Reason: ' . $this->getReason($template->form->log_username);
					return;
				}
			}
			else
			{
				$template->form->error = 'Username does not exist';
				return;
			}
		}
	}
	
	final public function loginHK()
	{
		global $template, $_CONFIG, $core;
		
		if(isset($_POST['login']))
		{	
			$template->form->setData();
			unset($template->form->error);
			
			if(isset($template->form->username) && isset($template->form->password))
			{
				if($this->nameTaken($template->form->username)) 
				{	 
                                        if($this->userValidation($template->form->username, $template->form->password))
					{
						if(($this->getInfo($_SESSION['user']['id'], 'rank')) >= 4)
						{
							$_SESSION["in_hk"] = true;
							header("Location:".$_CONFIG['hotel']['url']."/ase/dash");
							exit;
						}
						else
						{
							$template->form->error = 'Incorrect access level.';
							return;
						}
					}
					else
					{
						$template->form->error = 'Incorrect password.';
						return;
					}		
				}
				else
				{
					$template->form->error = 'User does not exist.';
					return;
				}
			}
	
			$template->form->unsetData();
		}
	}	
	
	final public function help()
	{
		global $template, $_CONFIG;
		$template->form->setData();
		
		if(isset($template->form->help))
		{
			$to = $_CONFIG['hotel']['email'];
 			$subject = "Help from RevCMS user - " . $this->getInfo($_SESSION['user']['id'], 'username');
 			$body = $template->form->question;
 				
 			if (mail($to, $subject, $body))
 			{
 				$template->form->error = 'Message successfully sent! We will answer you shortly!';
 			} 
 			else 
 			{
  				 $template->form->error = 'Message delivery failed.';
 			}
		}
	}

	/*-------------------------------Account settings-------------------------------------*/ 
	
	final public function updateAccount()
	{
		global $template, $_CONFIG, $core, $engine;
		
		if(isset($_POST['account']))
		{
		
			if(isset($_POST['acc_motto']) && strlen($_POST['acc_motto']) < 30 && $_POST['acc_motto'] != $this->getInfo($_SESSION['user']['id'], 'motto'))
			{
				$this->updateUser($_SESSION['user']['id'], 'motto', $engine->secure($_POST['acc_motto']));
				header('Location: '.$_CONFIG['hotel']['url'].'/account');
				exit;
			}
			else
			{
				$template->form->error = 'Motto is invalid.';
			}
			
			if(isset($_POST['acc_email']) && $_POST['acc_email'] != $this->getInfo($_SESSION['user']['id'], 'mail'))
			{
				if($this->validEmail($_POST['acc_email']))
				{
					$this->updateUser($_SESSION['user']['id'], 'mail', $engine->secure($_POST['acc_email']));
					header('Location: '.$_CONFIG['hotel']['url'].'/account');
					exit;
				}
				else
				{
					$template->form->error = 'Email is not valid';
					return;
				}
			}
			
                        if(!empty($_POST['acc_old_password']) && !empty($_POST['acc_new_password']))
                        {
                                if($this->userValidation($this->getInfo($_SESSION['user']['id'], 'username'), $_POST['acc_old_password']))
                                {
                                        if(strlen($_POST['acc_new_password']) >= 8)
                                        {
                                                $this->updateUser($_SESSION['user']['id'], 'password', $core->passwordHash($_POST['acc_new_password']));
                                                header('Location: '.$_CONFIG['hotel']['url'].'/me');
                                                exit;
                                        }
					else
					{
						$template->form->error = 'New password is too short';
						return;
					}
				}
				else
				{
					$template->form->error = 'Current password is wrong';
					return;
				}
			}
		}		
	}
		
		
	final public function turnOn($k)
	{	
		$j = $this->getID($k);
		$this->createSSO($j);
		$_SESSION['user']['id'] = $j;	
		$this->cacheUser($j);	
		unset($j);
	}
	
	/*-------------------------------Loggin forgotten-------------------------------------*/ 	
	
	final public function forgotten()
	{
		global $template, $_CONFIG, $core;
		
		if(isset($_POST['forgot']))
		{
		
			$template->form->setData();
			unset($template->form->error);
			
			if($this->nameTaken($template->form->for_username))
			{
				if(strlen($template->form->for_password) > 6)
				{
                                        if($this->getInfo($this->getID($template->form->for_username), 'seckey') == $core->hashed($template->form->for_key))
                                        {
                                                $this->updateUser($this->getID($template->form->for_username), 'password', $core->passwordHash($template->form->for_password));
						$template->form->error = 'Account recovered! Go <b><a href="index">here</a></b> to login!';
						return;
					}
					else
					{
						$template->form->error = 'Secret key is incorrect';
						return;
					}
				}
				else
				{
					$template->form->error = 'Password must have more than 6 characters.';
					return;
				}
			}
			else
			{
				$template->form->error = 'Username does not exist';
				return;
			}
		}
	}
	
	/*-------------------------------Create SSO auth_ticket-------------------------------------*/ 
	
	final public function createSSO($k) 	
	{ 	 	
		$sessionKey = 'RevCMS-'.rand(9,999).'/'.substr(sha1(time()).'/'.rand(9,9999999).'/'.rand(9,9999999).'/'.rand(9,9999999),0,33);
		
		$this->updateUser($k, 'auth_ticket', $sessionKey);
		
		unset($sessionKey);
	} 	 
		
	/*-------------------------------Adding/Updating/Deleting users-------------------------------------*/ 
	
       final public function addUser($username, $password, $email, $motto, $credits, $pixels, $rank, $figure, $gender, $seckey)
       {
                global $engine;
                $sessionKey = 'RevCMS-'.rand(9,999).'/'.substr(sha1(time()).'/'.rand(9,9999999).'/'.rand(9,9999999).'/'.rand(9,9999999),0,33);
               $stmt = $engine->prepare("INSERT INTO users (username, password, mail, motto, rank, look, gender, seckey, ip_last, ip_reg, account_created, last_online, auth_ticket) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)");
               $stmt->execute([$username, $password, $email, $motto, $rank, $figure, $gender, $seckey, $_SERVER['REMOTE_ADDR'], $_SERVER['REMOTE_ADDR'], time(), time(), $sessionKey]);
                $id = $engine->insert_id();
                $stmt = $engine->prepare("INSERT INTO users_currency (user_id, type, amount) VALUES(?,0,?),(?,5,?)");
                $stmt->execute([$id, $credits, $id, $pixels]);
                unset($sessionKey);

       }
		 
	final public function deleteUser($k) 	
	{ 		
		global $engine; 		 		
               $stmt = $engine->prepare("DELETE FROM users WHERE id = ? LIMIT 1");
               $stmt->execute([$k]);
               $stmt = $engine->prepare("DELETE FROM users_currency WHERE user_id = ?");
               $stmt->execute([$k]);
               $stmt = $engine->prepare("DELETE FROM items WHERE userid = ? LIMIT 1");
               $stmt->execute([$k]);
               $stmt = $engine->prepare("DELETE FROM rooms WHERE ownerid = ? LIMIT 1");
               $stmt->execute([$k]);
       }
	  	
	final public function updateUser($k, $key, $value) 	
	{ 		
	 	global $engine; 		 		
               if($key == 'credits' || $key == 'activity_points')
               {
                       $type = ($key == 'credits') ? 0 : 5;
                       $stmt = $engine->prepare("SELECT 1 FROM users_currency WHERE user_id = ? AND type = ?");
                       $stmt->execute([$k, $type]);
                       if($stmt->rowCount() > 0)
                       {
                               $stmt = $engine->prepare("UPDATE users_currency SET amount = ? WHERE user_id = ? AND type = ?");
                               $stmt->execute([$value, $k, $type]);
                       }
                       else
                       {
                               $stmt = $engine->prepare("INSERT INTO users_currency (user_id, type, amount) VALUES(?,?,?)");
                               $stmt->execute([$k, $type, $value]);
                       }
               }
               else
               {
                       $stmt = $engine->prepare("UPDATE users SET {$key} = ? WHERE id = ? LIMIT 1");
                       $stmt->execute([$value, $k]);
               }
               $_SESSION['user'][$key] = $engine->secure($value);
       }
	
	/*-------------------------------Handling user information-------------------------------------*/ 	 
	
	final public function cacheUser($k)
	{
		global $engine; 		 	
               $userInfo = $engine->fetch_assoc("SELECT username, rank, motto, mail, look, auth_ticket, ip_last FROM users WHERE id = '" . $k . "' LIMIT 1");
               $userInfo['credits'] = $engine->result("SELECT amount FROM users_currency WHERE user_id = '".$k."' AND type = '0' LIMIT 1");
               $userInfo['activity_points'] = $engine->result("SELECT amount FROM users_currency WHERE user_id = '".$k."' AND type = '5' LIMIT 1");
		
		foreach($userInfo as $key => $value)
		{
			$this->setInfo($key, $value);
		}
	}	
	
	final public function setInfo($key, $value)
	{
		global $engine;
		$_SESSION['user'][$key] = $engine->secure($value);
	}

       final public function getInfo($k, $key)
       {
               global $engine;
               if(!isset($_SESSION['user'][$key]))
               {
                        if($key == 'credits' || $key == 'activity_points')
                        {
                                $type = ($key == 'credits') ? 0 : 5;
                                $value = $engine->result("SELECT amount FROM users_currency WHERE user_id = '" . $engine->secure($k) . "' AND type = '".$type."' LIMIT 1");
                        }
                        else
                        {
                                $value = $engine->result("SELECT $key FROM users WHERE id = '" . $engine->secure($k) . "' LIMIT 1");
                        }
                        if($value != null)
                        {
                                $this->setInfo($key, $value);
                        }
               }

               return $_SESSION['user'][$key];
       }
	
	
	
	/*-------------------------------Get user ID or Username-------------------------------------*/ 
	
	final public function getID($k) 	
	{ 		
		global $engine; 		
		return $engine->result("SELECT id FROM users WHERE username = '" . $engine->secure($k) . "' LIMIT 1"); 	
	} 		
	
	final public function getUsername($k)
	{
		global $engine;
		return $this->getInfo($_SESSION['user']['id'], 'username');
	}
	
}
?>
