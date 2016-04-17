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
            // режим работы и кодировка:
            //self::$DBH->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->DBH->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->DBH->exec('SET NAMES utf8');            
       
        }  
        catch(PDOException $e) {
            echo 'oops, we need solve this problem <br />';
            echo $e->getMessage();  
        }
    }
    
    
    /*
     * Получить список категорий тестов в виде xml:
     */
    public function getCategories(){
        
        // Делаем запрос в БД:  
        $STH = $this->DBH->query('SELECT * from categories'); 

        // Устанавливаем режим выборки
        $STH->setFetchMode(PDO::FETCH_ASSOC);  

        // Формируем xml разметку из полученных данных:
        $xml = pdo_manager::makeCategoriesXmlString($STH);
        
        return $xml;
    }
    
    private function makeCategoriesXmlString($array){
        $xml = '<?xml version="1.0" encoding="utf-8" ?><categories>';
           
        while($value = $array->fetch()) {  
            
            $id = $value['id'];
            $title = $value['title'];
            $description = $value['description'];
            
            $xml .= "<category id=\"$id\" title=\"$title\" description=\"$description\"/>";
        }
        
        $xml .= '</categories>';
        return $xml; 
    }
    
    
    /*
     * Получаем все тесты определенной выбранной категории:
     */
    public function getTestsByCategory($category){
        
        // Делаем запрос на получение имени таблицы:
        $STH1 = $this->DBH->query("SELECT table_name FROM categories WHERE id='$category'"); 
        
        // Устанавливаем режим выборки и получаем имя таблицы выбранной категории в БД:
        $STH1->setFetchMode(PDO::FETCH_ASSOC);
        $row = $STH1->fetch();
        $table_name = $row['table_name'];
        
        // Делаем запрос на получение всех тестов из выбранной таблицы:
        $STH2 = $this->DBH->query("SELECT * FROM $table_name");
        
        // Устанавливаем режим выборки
        $STH2->setFetchMode(PDO::FETCH_ASSOC);
        
        // Формируем xml разметку из полученных данных:
        $xml = pdo_manager::makeTestsXmlString($STH2);
        
        return $xml;
    }
    
    private function makeTestsXmlString($array){
        
        $xml = '<?xml version="1.0" encoding="utf-8" ?><quizz>';
        
        while($value = $array->fetch()) {  
            
            $test_title = $value['test_title'];
            $file_name = $value['file_name'];
            //$author = $value['author'];
            $description = $value['description'];
            $downloads = $value['downloads'];
            
            
            
            $xml .= "<test test_title=\"$test_title\" file_name=\"$file_name\" description=\"$description\" downloads=\"$downloads\"/>";
        }
        $xml .= '</quizz>';
        return $xml; 
        
        
    }

}