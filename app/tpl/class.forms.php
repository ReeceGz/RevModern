<?php

namespace Revolution;
if(!defined('IN_INDEX')) { die('Sorry, you cannot access this file.'); }
class forms implements iForms
{

	public $error;

	final public function setData()
	{
		global $engine;
		foreach($_POST as $key => $value)
		{
			if($value != null)
			{
				$this->$key = $engine->secure($value);
			}
			else
			{
				$this->error = 'Please fill in all fields';
				return;
			}
		}
	
	}
	
	final public function unsetData()
	{
		global $template;
		foreach($this as $key => $value)
		{
			unset($this->$key);	
		}	
	}
	
	final public function writeData($key)
	{
		global $template;
		echo $this->$key;
	}
	
	final public function outputError()
	{
		global $template;
		if(isset($this->error))
		{
			echo "<div id='message'> " . $this->error . " </div>";
		}
	}
	
	/* Manage different pages */
	
	final public function getPageNews()
	{
		global $template, $engine;
		
			if(!isset($_GET['id']) || !is_numeric($_GET['id']))
			{
				$_GET['id'] = 1;
			}
                                $stmt = $engine->prepare("SELECT title, id FROM cms_news WHERE id != :id ORDER BY id DESC");
                                $stmt->bindValue(':id', $_GET['id'], \PDO::PARAM_INT);
                                $stmt->execute();
                                while($news1 = $stmt->fetch())
                                {
                                        $template->setParams('newsList', '&laquo; <a href="index.php?url=news&id='.$news1["id"].'">' . $news1['title'] . '</a><br/>');
                                }
                                $engine->free_result($stmt);
				
				$news = $engine->fetch_assoc("SELECT title, longstory, author, published FROM cms_news WHERE id = '" . $engine->secure($_GET['id']) . "' LIMIT 1");
				$template->setParams('newsTitle', $news['title']);
				$template->setParams('newsContent', $news['longstory']);
				$template->setParams('newsAuthor', $news['author']);
				$template->setParams('newsDate', date("d-m-y", $news['published']));
			
				unset($result);
				unset($news1);
				unset($news);
	}
	
	final public function getPageHome()
	{
		global $template, $engine;
                $a = 1;
                $stmt = $engine->prepare("SELECT title, id, published, shortstory, image FROM cms_news ORDER BY id DESC LIMIT 5");
                $stmt->execute();

        while($news = $stmt->fetch())
        {
            $template->setParams('newsTitle-' . $a, $news['title']);
            $template->setParams('newsID-' . $a, $news['id']);
            $template->setParams('newsDate-' . $a, date("d-m-y", $news['published']));
            $template->setParams('newsCaption-' . $a, $news['shortstory']);
            $template->setParams('newsIMG-' . $a, $news['image']);
                $a++;
        }

        unset($news);
        $engine->free_result($stmt);
        }
	
}
