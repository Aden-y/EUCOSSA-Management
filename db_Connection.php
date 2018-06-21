<?php

//PDO database connection file for the project
class Db_Connect{
//attributes to use for connection.. i have used full names for all to understand
    private $serverName;
    private $userName;
    private $userPass;
    private $dbName;
    private $charset;
//Doesn't require Constructor

//connection method which is protected meaning it will be visible to classes that connect to the method
    protected function connect(){

    	//name of the server....currently its my localhost
        $this->serverName="127.0.0.1";

        //username of the databbase
        $this->userName="root";

        //password of the database please write the password of your user on your local server coz we are not using  the same server
        $this->userPass="********";

        //the name of the database as it will be agreed on
        $this->dbName ="";

        //recommended character set for PDO connection and queries
        $this->charset="utf8mb4";

   
   //try catch exception incase of errors during connection

        try {
        		//dynamic source data.. used for PDO connections
                $dsn= "mysql:host".$this->serverName.";dbname".$this->dbName.";charset".$this->charset;

                //create a PDO connection
                $pdo_conn= new PDO($dsn, $this->userName, $this->userPass);

                //call to Attribute method whih has static PDO parameters for showing errors
                $pdo_conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);


				//return connection ... either true or false
                return $pdo_conn;
            
        } 
        //catch block
        catch (PDOException $e) {
        	//get connection error messages.
            echo "Connection Faile: ". $e->getMessage();
            
        }

    }

}

