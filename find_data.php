<?php
require("db_conn.php");

$cursor = $collection->find();

//$record = $collection->find( [ 'name' =>'Md. Abu Raihan'] );

foreach ($cursor as $document) {
      echo $document["age"] . "\n";
   }

echo "<pre>";
Print_r($cursor);
echo "</pre>";
?>