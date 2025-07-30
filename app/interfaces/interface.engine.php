<?php

namespace Revolution;
if(!defined('IN_INDEX')) { die('Sorry, you cannot access this file.'); }
interface iEngine
{

	public function Initiate();
	
       public function connect($type);
       public function insert_id();
       public function getConnection();

	public function disconnect();
	
	public function secure($var);
	
        public function query($sql);

        public function prepare($sql);
	
	public function num_rows($sql);
	
	public function fetch_assoc($sql);
	
	public function result($sql);
	
	public function free_result($sql);
	
}
?>
