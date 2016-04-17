<?php
include_once 'db/pdo_manager.php';

switch ($_GET['void']){

	case ('get_categories'):
            //echo 'get_categories';
            //$bdManager = pdo_manager::getDB();
            $bdManager = new pdo_manager();
           
            $categories = $bdManager->getCategories();
            header('Content-Type: text/xml; charset=utf-8');
            echo ($categories);
        break;
	
	case ('get_tests_by_category'):
		
            $category = $_GET['category'];
            //$bdManager = pdo_manager::getDB();
            $bdManager = new pdo_manager();
            $tests = $bdManager->getTestsByCategory($category);
            header('Content-Type: text/xml; charset=utf-8');
            echo ($tests);
	break;
	
	default:
		echo 'Who are you?)';
}