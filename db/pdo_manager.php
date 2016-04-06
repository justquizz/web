<?php
include_once 'db_settings.php';


/**
 * Description of pdo_manager
 *
 * @author user
 */
class pdo_manager {
    
    private static $DBH = null;
    
    
    /* 
    * Получение экземпляра класса. 
    * (Singleton) 
    */
    public static function getDB() {

        if (self::$DBH == null) {
              self::$DBH = new pdo_manager();
          }
          return self::$DBH;
    }
    
     
   
    private function __construct() {
        $host = db_settings::HOST;
        $user = db_settings::USER;
        $pswd = db_settings::PSWD;
        $dbname = db_settings::DB_NAME;
        
        try {  
            # MySQL через PDO_MYSQL  
            self::$DBH = new PDO("mysql:host=$host;dbname=$dbname", $user, $pswd);  
            // режим работы
            $DBH->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
            
            
       
        }  
        catch(PDOException $e) {  
              echo $e->getMessage();  
        }
    }

}