<?php 

require_once(realpath(dirname(__FILE__) . "/_config.php"));

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  $name = $_POST['name'];
  $status = $_POST['status'];
  $treatment = $_POST['treatment'];
  // $date = date("Y-m-d H:i:s"); // e.g 2021-12-30 17:49:37
  $date = date("Y-m-d"); // e.g 2021-12-30 17:49:37
  // $email = $_POST['email'];

}

$token = $key1;
$apiUrl = 'https://api.monday.com/v2';
$headers = ['Content-Type: application/json', 'Authorization: ' . $token];

// $query = 'mutation ($itemName: String!, $columnVals: JSON!) { 
//   create_item (board_id:2087111809, group_id:topics, item_name:$itemName, column_values:$columnVals) { id } 
// }';

$query = 'mutation ($name: String!, $columns: JSON!) { 
  create_item (board_id:2087111809, group_id:topics, item_name:$name, column_values:$columns) { id } 
}';

$vars = [
  'name' => $name, 
  'columns'  =>  json_encode([
    // 'person'    =>  $name,
    'status'   =>  $status, //value 1 = green, 2 = red, 0 = orange - default values = https://view.monday.com/1073554546-ad9f20a427a16e67ded630108994c11b?r=use1
    'date4'    =>  $date,
    'text'    =>  $treatment,
    // 'email9'    =>  ['email' => $email, 'text' => $name],
  ])
];

$data = @file_get_contents($apiUrl, false, stream_context_create([
 'http' => [
  'method' => 'POST',
  'header' => $headers,
  'content' => json_encode(['query' => $query, 'variables' => $vars]),
 ]
]));

//get response from call

$response  = json_decode($data, true);

echo json_encode($response); 

?>