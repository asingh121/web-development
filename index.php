<!DOCTYPE HTML>
<html>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>

body {
  margin: 0;
  font-family: Arial, Helvetica, sans-serif;
}

.topnav {
  overflow: hidden;
  background-color: #333;
}

.topnav a.title {
    padding: 20px;
    text-align: left;
    color: white;
    
}

.topnav a {
  float: left;
  display: block;
  text-align: center;
  text-decoration: none;
  font-size: 20px;
}

.topnav .search-container {
  float: right;
  margin: 8px;
}

.topnav input[type=text] {
  padding: 6px;
  margin-top: 8px;
  font-size: 17px;
  border: none;
}

.topnav .search-container button {
  float: right;
  padding: 6px 10px;
  margin-top: 8px;
  margin-right: 16px;
  background: #ddd;
  font-size: 17px;
  border: none;
  cursor: pointer;
}

.topnav .search-container button:hover {
  background: #ccc;
}

@media screen and (max-width: 600px) {
  .topnav .search-container {
    float: none;
  }
  .topnav a, .topnav input[type=text], .topnav .search-container button {
    float: none;
    display: block;
    text-align: left;
    width: 100%;
    margin: 0;
    padding: 14px;
  }
  .topnav input[type=text] {
    border: 1px solid #ccc;  
  }
  
  table_t {
  border-collapse: collapse;
  width: 100%;
}

td_t, th_t {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}
</style>
</head>  
<title>Student Data</title>
<body>
    
    <div class="topnav">
        <a class="title">Students Records</a>
        <div class="search-container">
            <form action="index.php" method="post">
                <input type="text" placeholder="Search.." name="search">
                <button type="submit"><i class="fa fa-search"></i></button>
            </form>
        </div>
    </div>
<?php
    if(!empty($_POST['search'])){
       
        // include database and object files
        include_once 'api/config/core.php';
        include_once 'api/config/database.php';
        include_once 'api/objects/users.php';
         
        // instantiate database and users object
        $database = new Database();
        $db = $database->getConnection();
         
        // initialize object
        $users = new Users($db);
         
        // get keywords
        $keywords= $_POST['search'];
        
        // query users
        $stmt = $users->search($keywords);
        $num = $stmt->rowCount();
         
        // check if more than 0 record found
        if($num>0){
         
            // users array
            $users_arr=array();
            $users_arr["users"]=array();
         
            // retrieve our table contents
            
            echo "<table style='margin:15px; border-collapse: collapse'>";
            echo "<tr >";
            echo "<td style='border:1px solid black; font-size:20; font-weight:bold; background-color:#d0d0d0; padding:8px'>First Name</td>";
            echo "<td style='border:1px solid black; font-size:20; font-weight:bold; background-color:#d0d0d0; padding:8px'>Last Name</td>";
            echo "<td style='border:1px solid black; font-size:20; font-weight:bold; background-color:#d0d0d0; padding:8px'>Date of Birth</td>";
            echo "<td style='border:1px solid black; font-size:20; font-weight:bold; background-color:#d0d0d0; padding:8px'>Course</td>";
            echo "<td style='border:1px solid black; font-size:20; font-weight:bold; background-color:#d0d0d0; padding:8px'>Address</td>";
            echo "<td style='border:1px solid black; font-size:20; font-weight:bold; background-color:#d0d0d0; padding:8px'>Phone Number</td>";
            echo "</tr>";
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                // extract row
                // this will make $row['name'] to
                // just $name only
                extract($row);
         
                $users_item=array(
        			"id" => $id,
                    "first_name" => $first_name,
                    "last_name" => $last_name,
                    "dob" => $dob,
                    "course" => $course,
                    "address" => html_entity_decode($address),
                    "phone_number" => $phone_number,
                    "created" => $created
                );
                
                    echo "<tr>";
                    echo "<td style='border:1px solid black; font-size:16; padding:8px; text-align: center'>" . $row['first_name'] . "</td>";
                    echo "<td style='border:1px solid black; font-size:16; padding:8px; text-align: center'>" . $row['last_name'] . "</td>";
                    echo "<td style='border:1px solid black; font-size:16; padding:8px; text-align: center'>" . $row['dob'] . "</td>";
                    echo "<td style='border:1px solid black; font-size:16; padding:8px; text-align: center'>" . $row['course'] . "</td>";
                    echo "<td style='border:1px solid black; font-size:16; padding:8px; text-align: center'>" . $row['address'] . "</td>";
                    echo "<td style='border:1px solid black; font-size:16; padding:8px; text-align: center'>" . $row['phone_number'] . "</td>";
                    echo "</tr>";
         
                array_push($users_arr["users"], $users_item);
            }
            
             echo "</table>";
        }
         
        else{
         
            // tell the user no users found
            echo "<h3>No User Found!!</h3>";
           
        }
    }      
?>
</body>
</html>