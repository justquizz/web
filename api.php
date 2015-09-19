<?php
include 'db/db_manager.php';

switch ($_GET['void']){

	case ('get_categories'):
            /*
            header('Content-Type: text/xml; charset=utf-8');
		echo '<?xml version="1.0" encoding="utf-8" ?>'."\n";
		echo '<categories>';
			echo '<category name="Демонстрационные тесты" id="1"/>';
			echo '<category name="Тесты иного рода" id="100" />';
		echo '</categories>';
              */ 
                $bdManager = db_manager::getDB();
                $categories = $bdManager->getCategories();
                header('Content-Type: text/xml; charset=utf-8');
                echo ($categories);
                
                
	break;
	
	case ('get_test_from_category'):
		echo 'hello, how are you?';
	break;
	
	default:
		echo 'Who are you?)';
}

