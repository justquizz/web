<?php
include 'db_settings.php';
/**
 * Description of DBManager
 *
 * @author eugen
 * created 13.09.2015
 */
class db_manager {
    
    private static $db = null;
    private $connection = null;
    
    
    
    
    /* Получение экземпляра класса. Если он уже существует, 
    * то возвращается, если его не было, то создаётся и возвращается 
    * (паттерн Singleton) */
  public static function getDB() {
            
      if (self::$db == null) {
            self::$db = new db_manager();
        }
        return self::$db;
  }
    
    private function __construct() {
        $host = db_settings::HOST;
        $user = db_settings::USER;
        $pswd = db_settings::PSWD;
        $dbase = db_settings::BASE;
        
        $conn = mysql_connect($host, $user, $pswd);
        mysql_query("SET NAMES utf8");
        
        if (!$conn || !mysql_select_db($dbase, $conn)) {
            return false;
        }
        $this->connection = $conn;
    }
    
    
    /*
     * Заносим результаты выборки из БД в массив:
     */
    function db_result_to_array($result){
	$res_array = array();
	
	while($row = mysql_fetch_assoc($result)){
            $res_array[] = $row;
                
        }
	return $res_array;
    }
    
    
    /*
     * Получить список категорий тестов в виде xml:
     */
    public function getCategories(){
        $query = "select * from categories";
	$result = mysql_query($query); 
	$resultToArray = db_manager::db_result_to_array($result);
        
        $xml = db_manager::makeXmlString($resultToArray);
        return $xml;
    }
    
    public function makeCategoriesXmlString($array){
        $xml = '<?xml version="1.0" encoding="utf-8" ?><categories>';
        
        foreach ($array as $key => $value){
            
            $description = $value['description'];
            $title = $value['title'];
            
            $xml .= "<category title=\"$title\" description=\"$description\"/>";
        }
        $xml .= '</categories>';
        return $xml; 
    }
    
    
    
    /*
     * Получить список тестов нужной категории в виде xml:
     */
    public function getTestsByCategory($category){
        
        $query1 = "SELECT table_name FROM categories WHERE title='$category'";
        $result1 = mysql_query($query1);
        $row = mysql_fetch_row($result1);
        $table_name = $row[0];
       
        $query2 = "SELECT * FROM $table_name";
        $result2 = mysql_query($query2);
        $resultToArray = db_manager::db_result_to_array($result2);
        
        //print_r($resultToArray);
        
        $xml = db_manager::makeTestsXmlString($resultToArray);
        return $xml;
    }
    
    public function makeTestsXmlString($array){
        $xml = '<?xml version="1.0" encoding="utf-8" ?><quizz>';
        
        foreach ($array as $key => $value){
            
            $test_title = $value['test_title'];
            $file_name = $value['file_name'];
            $author = $value['author'];
            $description = $value['description'];
            $downloads = $value['downloads'];
            
            
            
            $xml .= "<test test_title=\"$test_title\" file_name=\"$file_name\" description=\"$description\" downloads=\"$downloads\"/>";
        }
        $xml .= '</quizz>';
        return $xml; 
    }
    

    
}
