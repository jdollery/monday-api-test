<?php

/*-----------------------------------------------------------------------------------*/
/* EXAMPLE API CALLS */
/*-----------------------------------------------------------------------------------*/

// { boards (limit:10) { name id description items { name column_values { title id type text } } } }'; // get everything

// { boards { name id board_folder_id } }'; // get all boards

// { boards (ids: XXXXXXXXXX) { groups { id title } } }'; //get groups in board (using board id)

// { boards (ids: XXXXXXXXXX) { groups (ids: XXXXXXXXXX) { items { id name status } } } }'; //get items in group (using board and group ids)

// { boards (ids: XXXXXXXXXX) { groups (ids: XXXXXXXXXX) { items { id name column_values { id title } } } } }'; //get all entries of group and each columns id and title (using board and group ids) 


/*-----------------------------------------------------------------------------------*/
/* GET API JSON FUNCTION */
/*-----------------------------------------------------------------------------------*/

require_once(realpath(dirname(__FILE__) . "/_config.php"));

$token = $key1;
$apiUrl = 'https://api.monday.com/v2';
$headers = ['Content-Type: application/json', 'Authorization: ' . $token];

$query = '{ boards (ids: 2087111809) { groups (ids: topics) { items { id name column_values { id title } } } } }';

$data = @file_get_contents($apiUrl, false, stream_context_create([
 'http' => [
  'method' => 'POST',
  'header' => $headers,
  'content' => json_encode(['query' => $query]),
 ]
]));

//get response from call

$response  = json_decode($data, true);

echo json_encode($response); 