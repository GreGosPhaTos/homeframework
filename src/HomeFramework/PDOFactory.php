<?php
    namespace lib;
    
    class PDOFactory
    {
        public static function getMysqlConnexion()
        {					
            $db = new \PDO('mysql:host='.DB_HOST.';dbname=news', DB_USER, DB_PASSWORD);
            $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            
            return $db;
        }
    }
