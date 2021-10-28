<?php 

require_once(realpath(dirname(__FILE__) . "/_config.php"));

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  $name = $_POST['name'];
  $email = $_POST['email'];

}

$token = $key;
$apiUrl = 'https://api.monday.com/v2';
$headers = ['Content-Type: application/json', 'Authorization: ' . $token];

$query = '{boards(limit:1) { name id description items { name column_values { title id type } } } }';

$data = @file_get_contents($apiUrl, false, stream_context_create([
 'http' => [
  'method' => 'POST',
  'header' => $headers,
  'content' => json_encode(['query' => $query]),
 ]
]));

$tempContents = json_decode($data, true);

echo json_encode($tempContents);

?>