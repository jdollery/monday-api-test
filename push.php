<?php 

require_once(realpath(dirname(__FILE__) . "/_config.php"));

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  // $name = $_POST['name'];
  $name = strip_tags($_POST['name']);
  // $email = $_POST['email'];
  $email = strip_tags($_POST['email']);
  // $status = $_POST['status'];
  $status = strip_tags($_POST['status']);
  // $treatment = $_POST['treatment'];
  $treatment = strip_tags($_POST['treatment']);
  // $date = date("Y-m-d H:i:s"); // e.g 2021-12-30 17:49:37
  $date = date("Y-m-d"); // e.g 2021-12-30 Monday will convert this to Dec 30

}

$token = $key1;
$apiUrl = 'https://api.monday.com/v2';
$headers = ['Content-Type: application/json', 'Authorization: ' . $token];

// $query = 'mutation ($name: String!, $columns: JSON!) { 
//   create_item (board_id:2087111809, group_id:topics, item_name:$name, column_values:$columns) { id } 
// }';

$createQuery = 'mutation ($name: String!, $columns: JSON!) { 
  create_item (board_id:2087111809, group_id:topics, item_name:$name, column_values:$columns) { id } 
}';

$createVars = [
  'name' => $name, 
  'columns'   =>  json_encode([
    'email'  =>  ['email' => $email, 'text' => $name],
    'status'  =>  $status, //value 1 = green, 2 = red, 0 = orange - default values = https://view.monday.com/1073554546-ad9f20a427a16e67ded630108994c11b?r=use1
    'date4'   =>  $date,
    'text'    =>  $treatment,
  ])
];

$data = @file_get_contents($apiUrl, false, stream_context_create([
 'http' => [
  'method' => 'POST',
  'header' => $headers,
  'content' => json_encode(['query' => $createQuery, 'variables' => $createVars]),
 ]
]));

//get response from call

$response = json_decode($data, true);
$item_id = $response['data']['create_item']['id']; //get the id of the just created item

// echo json_encode($response); 
// echo json_encode($item_id);

/* ------ Adding Files ------ */


$eol = '\r\n';

// $header = array(
//   'User-Agent' => MONDAY_TEAM . ’ GraphQL Client’,
//   'Authorization' => get_field('mondaykey', 'user_' . get_current_user_id()),
//   'Content-Type' => 'multipart/form-data; boundary=' . $boundary
// );

$token = $key1;
$apiUrl = 'https://api.monday.com/v2';
$headers = ['Content-Type: multipart/form-data; boundary=' . $boundary, 'Authorization: ' . $token];

//We need to build the body from scratch because it is multipart with boundaries
//Take care of the extra empty lines (twice $eol) before the actual query and file, otherwise an error 500 is returned

$query = '–' . $boundary . $eol;
$query .= 'Content-Disposition: form-data; name="query"' . $eol . $eol;
$query .= 'mutation ($file: File!) {add_file_to_column (board_id:2087111809, group_id:topics, item_id: ' . $item_id . ', column_id: files, file: $file ) { id } }' . $eol;

$query .= '–' . $boundary . $eol;
$query .= 'Content-Disposition: form-data; name="variables[file]"; filename="' . $upload['name'] . '"' . $eol;
$query .= 'Content-Type: ' . $upload['type'] . $eol . $eol;
$query .= file_get_contents($upload['value']);
$query .= $eol . '–' . $boundary . '–';

$data = @file_get_contents($apiUrl, false, stream_context_create([
  'http' => [
   'method' => 'POST',
   'header' => $headers,
   'content' => json_encode(['query' => $query]),
  ]
]));

$response = json_decode($data, true);
echo json_encode($response);

// $response = wp_remote_post( MONDAY_URL . ‘file/’, [‘headers’ => $header, ‘body’ => $body] );