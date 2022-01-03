<?php 

require_once(realpath(dirname(__FILE__) . "/_config.php"));


/*-----------------------------------------------------------------------------------*/
/* CREATE ITEM */
/*-----------------------------------------------------------------------------------*/

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

$query = 'mutation ($name: String!, $columns: JSON!) { 
  create_item (board_id:2087111809, group_id:topics, item_name:$name, column_values:$columns) { id } 
}';

$vars = [
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
  'content' => json_encode(['query' => $query, 'variables' => $vars]),
 ]
]));

//get response from call

$response = json_decode($data, true);
$item_id = $response['data']['create_item']['id']; //get the id of the just created item

// echo json_encode($response); 
echo json_encode($item_id);


/*-----------------------------------------------------------------------------------*/
/* ADD FILES TO CREATED ITEM */
/*-----------------------------------------------------------------------------------*/

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  if (isset($_FILES["upload"]) && $_FILES["upload"]["error"] == 0) { 

    $file_name     = $_FILES["upload"]["name"];
    $file_type     = $_FILES["upload"]["type"];
    $file_size     = $_FILES["upload"]["size"];
    $file_value     = $_FILES["upload"]["value"];
    $file_tmp_name = $_FILES["upload"]["tmp_name"];
    $file_error    = $_FILES["upload"]["error"];

  }

}

// https://community.monday.com/t/accessing-and-upload-files-using-the-graphql-api/5997/7

$boundary = 'bsdkvbl23fdvf'; //need to work out boundary randomiser
$eol = '\r\n';

$token = $key1;
$apiUrl = 'https://api.monday.com/v2/file';
$headers = ['Content-Type: multipart/form-data; boundary=' . $boundary, 'Authorization: ' . $token];

$query = 'mutation ($file: File!) { 
  add_file_to_column (board_id:2087111809, group_id:topics, item_id:' . $item_id . ', column_id: files, file: $file ) { id }
}' . $eol;

$body = '–' . $boundary . $eol;
$body .= 'Content-Disposition: form-data; name="'. $query .'"' . $eol . $eol;
$body .= '–' . $boundary . $eol;
$body .= 'Content-Disposition: form-data; name="variables[file]"; filename="' . $file_name . '"' . $eol; //Undefined variable: file_name
$body .= 'Content-Type: ' . $file_type . $eol . $eol; //Undefined variable: file_type
$body .= file_get_contents($file_value); //Undefined variable: file_value
$body .= $eol . '–' . $boundary . '–';

$data = @file_get_contents($apiUrl, false, stream_context_create([ //file_get_contents(): Filename cannot be empty in
  'http' => [
   'method' => 'POST',
   'header' => $headers,
   'content' => json_encode(['body' => $body]),
  ]
]));

$response = json_decode($data, true);
echo json_encode($response);