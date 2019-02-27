<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';
 
// instantiate users object
include_once '../objects/users.php';
 
$database = new Database();
$db = $database->getConnection();
 
$users = new Users($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// make sure data is not empty
if(
    !empty($data->first_name) &&
    !empty($data->last_name) &&
    !empty($data->dob) &&
    !empty($data->course)&&
    !empty($data->address)&&
    !empty($data->phone_number)
){
 
    // set users property values
    $users->first_name = $data->first_name;
    $users->last_name = $data->last_name;
    $users->dob = $data->dob;
    $users->course = $data->course;
    $users->address = $data->address;
    $users->phone_number = $data->phone_number;
 
    // create the users
    if($users->create()){
 
        // set response code - 201 created
        http_response_code(200);
 
        // tell the user
        echo json_encode(array("message" => "User is added."));
    }
 
    // if unable to create the users, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
        echo json_encode(array("message" => "Unable to add user."));
    }
}
 
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
    echo json_encode(array("message" => "Unable to add user. Data is incomplete."));
}
?>