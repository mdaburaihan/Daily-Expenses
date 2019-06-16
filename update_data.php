<?php
require("db_conn.php");

// now update the document
$updatedData = array('$set'=>array("age"=>"25"));

$collection->updateOne(array("age"=>"24"),$updatedData);
echo "Data updated successfully";

// now display the updated document
$cursor = $collection->find();
?>