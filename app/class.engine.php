<?php

namespace Revolution;
if(!defined('IN_INDEX')) { die('Sorry, you cannot access this file.'); }
class engine
{
    private $initiated = false;
    private $connected = false;
    private $connection;

    public function Initiate()
    {
        global $_CONFIG;
        if(!$this->initiated)
        {
            $this->connect($_CONFIG['mysql']['connection_type']);
            $this->initiated = true;
        }
    }

    public function connect($type)
    {
        global $core, $_CONFIG;
        if(!$this->connected)
        {
            $options = [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC];
            if($type === 'pconnect')
            {
                $options[\PDO::ATTR_PERSISTENT] = true;
            }
            $dsn = sprintf('mysql:host=%s;dbname=%s;port=%s;charset=utf8mb4',
                           $_CONFIG['mysql']['hostname'],
                           $_CONFIG['mysql']['database'],
                           $_CONFIG['mysql']['port']);
            try {
                $this->connection = new \PDO($dsn, $_CONFIG['mysql']['username'], $_CONFIG['mysql']['password'], $options);
                $this->connected = true;
            } catch (\PDOException $e) {
                $core->systemError('MySQL Engine', 'Connection failed: '.$e->getMessage());
            }
        }
    }

    public function disconnect()
    {
        if($this->connected)
        {
            $this->connection = null;
            $this->connected = false;
        }
    }

    public function secure($var)
    {
        return substr($this->connection->quote(stripslashes(htmlspecialchars($var, ENT_QUOTES))),1,-1);
    }

    public function query($sql)
    {
        return $this->connection->query($sql);
    }

    public function num_rows($sql)
    {
        return $this->query($sql)->rowCount();
    }

    public function result($sql)
    {
        return $this->query($sql)->fetchColumn();
    }

    public function free_result($res)
    {
        if($res instanceof \PDOStatement){
            $res->closeCursor();
        }
    }

    public function fetch_array($sql)
    {
        return $this->query($sql)->fetchAll();
    }

    public function fetch_assoc($sql)
    {
        return $this->query($sql)->fetch();
    }

    public function insert_id()
    {
        return $this->connection->lastInsertId();
    }

    public function getConnection()
    {
        return $this->connection;
    }
}
?>
