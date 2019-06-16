<?php

class DailyExpense{
	public function __construct(){
		//$this->db=new Database();
	}
	
	public function getAllDailyExpenses($conditionArr = array()){
		require("db_conn.php");
		$result = $collection->find($conditionArr);
		
		$allexpenseArr = array();
		foreach ($result as $each_result) {
			$expenseArr = json_decode($each_result["expense"],TRUE);
			
		  $eachexpenseArr = array(
			"expense" => $expenseArr,
			"doc" => $each_result["doc"],
			"creation_timestamp" => $each_result["creation_timestamp"],
			"creation_date" => $each_result["creation_date"],
		  );
		  array_push($allexpenseArr,$eachexpenseArr);
	   }
	   
	   return $allexpenseArr;
	}
	
	public function getAllExpensesToday(){
		require("db_conn.php");
		$result = $collection->find(['creation_date' => date('Y-m-d'),'trash_flag' => 0]);
		
		if(!empty($result)){
			foreach ($result as $each_result) {
				$expenseTodayArr = json_decode($each_result["expense"],TRUE);
			
			
				if($expenseTodayArr){
					return $expenseTodayArr;
				}else{
					return array();
				}	
			}
		} 
	}
	
	
}
?>