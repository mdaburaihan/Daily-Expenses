<?php  
require 'vendor/autoload.php';  
// Creating Connection  
$conn = new MongoDB\Client("mongodb://localhost:27017");  
// connect to mongodb

//echo "Connection to database successfully"."<br>";
// select a database
$db = $conn->db_daily_expenses;
//echo "Database db_student selected"."<br>";
// select a collection
$collection = $db->t_expense_details;
//echo "Collection t_student_details selected";

?>