<?php

include_once "../lib/php/functions.php";

$data = json_decode(file_get_contents("php://input"));

//print_p($data);

$output = [];

switch($data->type){
	case "products_all":
		$output['result'] = makeQuery(makeConn(),"SELECT * 
			FROM `products` 
			ORDER BY `date_create` DESC 
			LIMIT 20");
		break;

	case "product_search":
		$output['result'] = makeQuery(makeConn(),"SELECT * 
			FROM `products` 
			WHERE `name` LIKE '%$data->search%' OR
				  `price` LIKE '%$data->search%' OR
				  `category` LIKE '%$data->search%'
			ORDER BY `date_create` DESC 
			LIMIT 20");
		break;

	case "product_filter":
		$output['result'] = makeQuery(makeConn(),"SELECT * 
			FROM `products` 
			WHERE `$data->column` LIKE '$data->value'
			ORDER BY `date_create` DESC 
			LIMIT 20");
		break;

	case "product_sort":
		$output['result'] = makeQuery(makeConn(),"SELECT * 
			FROM `products` 
			ORDER BY `$data->column` $data->dir
			LIMIT 20");
		break;

	default: $output['error'] = "No Valid Type";
}

echo json_encode($output,JSON_NUMERIC_CHECK/JSON_UNESCAPED_UNICODE);