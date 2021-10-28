<?php 

// https://community.monday.com/t/basic-php-api-v2-example/709

$token = '[Personal API Token]';
$tempUrl = "https://api.monday.com/v2/";

$query = '  {
                users{
                    id 
                    email
                    name
                }
            }';
$headers = ['Content-Type: application/json', 'User-Agent: [MYTEAM] GraphQL Client', 'Authorization: ' . $token];
$data = @file_get_contents($tempUrl, false, stream_context_create([
    'http' => [
        'method' => 'POST',
        'header' => $headers,
        'content' => json_encode(['query' => $query]),
    ]
]));

$tempContents = json_decode($data, true);

?>

<!-- https://support.monday.com/hc/en-us/articles/360013465659-API-Quickstart-Tutorial-PHP -->

<?php
$token = 'YOUR_TOKEN_HERE';
$apiUrl = 'https://api.monday.com/v2';
$headers = ['Content-Type: application/json', 'Authorization: ' . $token];

$query = 'mutation{ create_item (board_id:YOUR_BOARD_ID, item_name:"WHAT IS UP MY FRIENDS!") { id } }';
$data = @file_get_contents($apiUrl, false, stream_context_create([
 'http' => [
 'method' => 'POST',
 'header' => $headers,
 'content' => json_encode(['query' => $query]),
 ]
]));
$responseContent = json_decode($data, true);

echo json_encode($responseContent);
?>