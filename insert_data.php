<?php
require("db_conn.php");

/*$insertData = array( 
      "name" => "Md.Abu Raihan", 
      "age" => "24", 
      "dept" => "Computer Science & Engineering",
      "passout_year" => "2018"
   );
	
   $collection->insertOne($insertData);*/


   $insertManyResult = $collection->insertMany([
    [
        "name" => "Sayan Rakshit", 
      	"age" => "24", 
      	"dept" => "EE",
      	"passout_year" => "2018"
    ],
    [
        "name" => "Biswa", 
      	"age" => "24", 
      	"dept" => "CE",
      	"passout_year" => "2018"
    ],
]);

   echo "Document inserted successfully";
?>