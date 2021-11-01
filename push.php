<?php 

require_once(realpath(dirname(__FILE__) . "/_config.php"));

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  $name = $_POST['name'];
  // $email = $_POST['email'];

}

$token = $key2;
$apiUrl = 'https://api.monday.com/v2';
$headers = ['Content-Type: application/json', 'Authorization: ' . $token];

$query = 'mutation ($itemName: String!) { 
  create_item (board_id:1760305728, group_id:topics, item_name:$itemName) { id } 
}';

$vars = [
  'itemName' => $name, 
  // 'columnVals'  =>  json_encode([
  //   'status1'   =>  ['label' => 'New'],
  //   'email9'    =>  ['email' => $email, 'text' => $name],
  // ])
];

$data = @file_get_contents($apiUrl, false, stream_context_create([
 'http' => [
  'method' => 'POST',
  'header' => $headers,
  'content' => json_encode(['query' => $query, 'variables' => $vars]),
 ]
]));

$response = json_decode($data, true);

echo json_encode($response);

?>