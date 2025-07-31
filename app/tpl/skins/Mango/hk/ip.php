 <div id="main">
    <div id="links"></div>
    <div id="header">
      <div id="logo">
        <div id="logo_text">
          <!-- class="logo_colour", allows you to change the color of the logo text -->
          <h1>ASE</h1>
        </div>
      </div>
    </div>
    <div id="site_content">
      <div id="sidebar_container">
        <!-- insert your sidebar items here -->
        <div class="sidebar">
          <div class="sidebar_top"></div>
          <div class="sidebar_item">
           <br />
		   [ <a href='dash'>Return to Dashboard</a> ] [ <a href='logout.php'>Log out</a> ]<br /> <br />
            <p>
                        <?php if($_SESSION['user']['rank'] >= 7)
			{ ?>
			Player Management <br /> <img src='../app/tpl/skins/<?php echo $_CONFIG['template']['style']; ?>/hk/images/line.png'> <br />
			&raquo; <a href='sub'>Last 50 VIP purchases</a> <br />
			&raquo; <a href='vip'>Give a user Regular VIP</a> <br />
			&raquo; <a href='svip'>Give a user Super VIP</a> <br />
			&raquo; <a href='edit'>Edit a users account</a> <br />
			<br />
			Administration <br /> <img src='../app/tpl/skins/<?php echo $_CONFIG['template']['style']; ?>/hk/images/line.png'> <br />
			&raquo; <a href='news'>Post news article</a><br />
			<br />
                        <?php } if($_SESSION['user']['rank'] >= 5) { ?>
			Moderation <br /> <img src='../app/tpl/skins/<?php echo $_CONFIG['template']['style']; ?>/hk/images/line.png'> <br />
			&raquo; <a href='banlist'>Ban List</a> <br />
			&raquo; <a href='ip'>IP lookup</a> <br />
			<br />
			
			<?php } ?>
			<br />
			Statistics<br />
			<img src='../app/tpl/skins/<?php echo $_CONFIG['template']['style']; ?>/hk/images/line.png'> <br />
					Server Status: 
			{status} <br />
			{online} user(s) online <br />
	
			</p>
          </div>
          <div class="sidebar_base"></div>
        </div>
      </div>
      <div id="content_container">

        <div id="content">
          <!-- insert the page content here -->
          <br />          

          <table width="100%">
<tr><td><b>Username</b></td><td><b>E-Mail</b></td><td><b>IP</b></td></tr>
<?php
        if(isset($_POST['get_ip']))
        {
                if(!$users->validCsrf())
                {
                        echo 'Invalid CSRF token';
                }
                else
                {
                $stmt = $engine->prepare("SELECT ip_last FROM users WHERE username = ?");
                $stmt->execute([$_POST['username']]);
                $derp = $stmt->fetch();
                $engine->free_result($stmt);
                $stmt = $engine->prepare("SELECT * FROM users WHERE ip_last = ?");
                $stmt->execute([$derp['ip_last']]);
                $accounts = $stmt->fetchAll();

                echo "There are " . count($accounts) . " account(s) on this IP. <br /><br />";
                foreach($accounts as $ferp) {
                echo "<tr><td>" . htmlspecialchars($ferp['username'], ENT_QUOTES) . "</td><td>" . htmlspecialchars($ferp['mail'], ENT_QUOTES) . "</td><td>" . htmlspecialchars($ferp['ip_last'], ENT_QUOTES) . "</td></tr>"; }
                $engine->free_result($stmt);
                }
        } ?>
	
        <form method='post'>
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>"/>
        Username <br /> <input type="text" name="username" /> <br /> <br />
        <input type="submit" value="  Lookup IP  " name="get_ip"/>
        </form>
</table>

        </div>

      </div>
    </div>
  </div>
   <center>Powered by ZapASE by Jontycat - Design by Predict</center>
   <center>Implemented into RevCMS by Kryptos</center><br />