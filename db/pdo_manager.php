<?php
include_once 'db_settings.php';


/**
 * Description of pdo_manager
 *
 * @author user
 */
class pdo_manager {
    
    //private static $DBH = null;
    public $DBH = null;


    /* 
    * Получение экземпляра класса. 
    * (Singleton) 
    
    public static function getDB() {

        if (self::$DBH == null) {
              self::$DBH = new pdo_manager();
          }
          return self::$DBH;
    }
    */
     
   
   public function __construct() {
        $host = db_settings::HOST;
        $user = db_settings::USER;
        $pswd = db_settings::PSWD;
        $dbname = db_settings::DB_NAME;
        
        try {  
            # MySQL через PDO_MYSQL  
            //self::$DBH = new PDO("mysql:host=$host;dbname=$dbname", $user, $pswd);
            $this->DBH = new PDO("mysql:host=$host;dbname=$dbname", $user, $pswd);  
            // режим работы
            //self::$DBH->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->DBH->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            
       
        }  
        catch(PDOException $e) {
            echo 'some errore';
            echo $e->getMessage();  
        }
    }
    
    
    /*
     * Получить список категорий тестов в виде xml:
     */
    public function getCategories(){
        
        /*
        $query = "select * from categories";
	$result = mysql_query($query); 
	$resultToArray = db_manager::db_result_to_array($result);
        
        $xml = db_manager::makeCategoriesXmlString($resultToArray);
        return $xml;
         */
        
        
        # поскольку это обычный запрос без placeholder’ов,
        # можно сразу использовать метод query()  
        //$STH = self::$DBH->query('SELECT * from categories');
        $STH = $this->DBH->query('SELECT * from categories'); 

        # устанавливаем режим выборки
        $STH->setFetchMode(PDO::FETCH_ASSOC);  

        while($row = $STH->fetch()) {  
            echo $row['id'] . "<br />";  
            echo $row['title'] . "<br />";  
            echo $row['description'] . "<br />";  
        }
         
    }
    
    public function makeCategoriesXmlString($array){
        $xml = '<?xml version="1.0" encoding="utf-8" ?><categories>';
        
        foreach ($array as $key => $value){
            
            $id = $value['id'];
            $title = $value['title'];
            $description = $value['description'];
            
            $xml .= "<category id=\"$id\" title=\"$title\" description=\"$description\"/>";
        }
        $xml .= '</categories>';
        return $xml; 
    }
    
    
    
    

}