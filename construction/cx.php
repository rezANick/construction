<?php

class Database{
    private static $dbHost="localhost";
    private static $dbName="construction";
    private static $dbUser="root";
    private static $db_Password="";

    private static $connection=null;

    public static function connect(){
        try{
            self::$connection=new PDO("mysql:host=".self::$dbHost.";dbname=".self::$dbName,self::$dbUser,self::$db_Password);
        }catch (PDOException $e){
            die($e->getMessage());
        }
        return self::$connection;
    }
    public static function disconnect(){
        self::$connection=null;
    }
}


?>