<?php 

require_once(realpath(dirname(__FILE__) . "/_config.php"));

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  $name = $_POST['name'];
  $email = $_POST['email'];

}

$token = $key;
$apiUrl = 'https://api.monday.com/v2';
$headers = ['Content-Type: application/json', 'Authorization: ' . $token];

$query = 'mutation ($myItemName: String!, $columnVals: JSON!) { 
  create_item (board_id:1843020011, group_id:new_group, item_name:$myItemName, column_values:$columnVals) { id } 
}';

$vars = [
  'myItemName' => $name, 
  'columnVals' => json_encode([
    'status' => ['label' => 'New'],
    // 'email'  => $email,
])];

$data = @file_get_contents($apiUrl, false, stream_context_create([
 'http' => [
  'method' => 'POST',
  'header' => $headers,
  'content' => json_encode(['query' => $query, 'variables' => $vars]),
 ]
]));

$responseContent = json_decode($data, true);

echo json_encode($responseContent);

?>