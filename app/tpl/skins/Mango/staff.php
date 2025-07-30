<div id="header_bar"> 
<div id="container-me"> 
<div class="mid"> 
<div class="lefts"> 
Welcome back to {hotelName}, {username}!
</div>
<div class="right"> 
<img src="app/tpl/skins/Mango/images/creditIcon.png" style="vertical-align:middle;margin-right:5px;"/><span>{coins}</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span style=""><img src="app/tpl/skins/Mango/images/pixelIcon.png" style="vertical-align:middle;margin-right:5px;"/>{activitypoints}</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span style=""><img src="app/tpl/skins/Mango/images/icon_users.png" style="vertical-align:middle;margin-right:5px;"/>{online} Users Online!</span> 
</div> 
</div> 
</div> 
</div> 
<div id="content"> 
<a href="index"><img src="app/tpl/skins/Mango/images/logo.png" id="logo" border="0"/></a> 
<ul id="menu"> 
<li><a href="me">Me</a></li> 
<li><a href="account">My Account</a></li> 
<li><a href="news">News</a></li>
<li><a href="staff">Staff</a></li>  
{housekeeping}
<li><a href="logout">Logout</a></li> 
</ul> 
<div id="clear"></div> 
<hr/> 
<div id="featured_campaign"> 
<div id="user_info"> 
<div id="avatar-plate"> 
<img src="http://www.habbo.com/habbo-imaging/avatarimage?figure={figure}&action=wav&direction=2&head_direction=3&gesture=srp&size=l" id="user"/> 
</div> 
</div> 
<div id="enter_area"> 
<div class="enterButton"> 
<center><a href="api.php" onclick="mango.client.popup(); return false;">Enter {hotelName} for the fun to begin!</a></center> 
</div> 
</div> 
</div><br/> 

<div id="main_left"> 

<?php
	$GetRanks = mysql_query("SELECT id,name FROM ranks WHERE id > 3 ORDER BY id DESC");
	while($Ranks = mysql_fetch_assoc($GetRanks))
	{
		echo "<div class=\"content-box\" style=\"background-color:#fff\"><div class=\"content-box-deep-blue\"><h2 class=\"title\" style=\"padding:0;line-height:30px;\">{$Ranks['name']}s</h2></div><div class=\"content-box-content\"><p>";
		$GetUsers = mysql_query("SELECT username,motto,rank,last_online,online,look FROM users WHERE rank = {$Ranks['id']}");
		while($Users = mysql_fetch_assoc($GetUsers))
		{
			if($Users['online'] == 1){ $OnlineStatus = "<font color=\"darkgreen\"><blink><b>Online</b></blink></font>"; } else { $OnlineStatus = "<font color=\"darkred\"><marquee><b>Offline</b></marquee></font>"; }
			echo "<img style=\"position:absolute;\" src=\"http://www.habbo.com/habbo-imaging/avatarimage?figure={$Users['look']}&action=wav&direction=2&head_direction=3&gesture=srp&size=l\">"
				."<p style=\"margin-left:80px;margin-top:20px;\">Username: <strong>{$Users['username']}</strong><br>Motto: <strong>{$Users['motto']}</strong><br><small>Last Online: ". date("D, d F Y H:i (P)", $Users['last_online']) ."</small></p>"
				."<p style=\"float:right;margin-top:-30px;\">{$OnlineStatus}</p><br><br><br>";
		}
		echo "</p></div></div><br>";
	}
?>


</div>
<div id="main_right"> 

	<div class="content-box" style="width:300px;background-color:#fff;"> 
	  <div class="content-box-deep-blue" style="width:290px"> 
	    <h2 class="title" style="padding:0;line-height:30px;">Who are these people?</h2> 
	  </div> 
	  <div class="content-box-content"> 
	    <p>
			The {hotelName} staff are here to help out users and make sure you all have a good time! Do not ask for staff, because your chances will go down!
			<br><br>
			<center><img src="http://habbolove.lefora.com/composition/attachment/4e5f5854f56feec849fb3fb024021a21/48701/Badge-HabboStaff.gif?thumb=1"></center>
		</p>
	  </div>
	</div>
</div> 

<br/>&nbsp;<br/> 
<br/><br/> 
<div id="clear"></div></div> 
 <div id="footer"> 
 <div id="clear"></div>
<div class="left"> 
<ul> 
<strong>Sitemap</strong> 
<li><a href="me">Me</a></li> 
<li><a href="account">My Account</a></li> 
<li><a href="news">Articles</a></li> 
<li><a href="#">The {hotelName} Way</a></li> 
<li><a href="#">The {hotelName} Team</a></li> 
</ul> 
</div> 
<div class="left"> 
<ul> 
<li>&nbsp;</li> 
<li><a href="#">eXperts</a></li> 
<li><a href="#">Credits</a></li> 
<li><a href="#">{hotelName} VIP</a></li> 
<li><a href="#">{hotelName} Store</a></li> 
<li><a href="#">{hotelName} Club</a></li> 
</ul> 
</div> 
<div class="left"> 
<ul> 
<li>&nbsp;</li> 
<li><a href="#">Help</a></li> 
<li><a href="logout">Logout</a></li> 
</ul> 
</div>
