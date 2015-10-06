<?php
include 'db/db_manager.php';

switch ($_GET['void']){

	case ('get_categories'):
            
            $bdManager = db_manager::getDB();
            $categories = $bdManager->getCategories();
            header('Content-Type: text/xml; charset=utf-8');
            echo ($categories);
        break;
	
	case ('get_tests_by_category'):
		
            $category = $_GET['category'];
            $bdManager = db_manager::getDB();
            $tests = $bdManager->getTestsByCategory($category);
            header('Content-Type: text/xml; charset=utf-8');
            echo ($tests);
	break;
	
	default:
		echo 'Who are you?)';
}

