<?php
require("db_conn.php");
require("classes/dailyexpense.class.php");

$DailyExpense = new DailyExpense();

if($_POST){
	if($_POST['mode'] == "add"){
		/*echo "<pre>";
		print_r($_POST['postedData']);
		echo"</pre>";
		exit;*/
		ob_clean();
		$expense_amount = $_POST['postedData'][0]['value'];
		$expense_reason = $_POST['postedData'][1]['value'];
		$expense_remarks = $_POST['postedData'][2]['value'];
		
		date_default_timezone_set("Asia/Kolkata");
		
		$expenseToday = $DailyExpense->getAllExpensesToday();
		$expenseTodayArr = $expenseToday;
		
		if(!empty($expenseToday)){
			$expense_arr = array(
				"expense_amount" => $expense_amount,
				"expense_reason" => $expense_reason,
				"expense_remarks" => $expense_remarks,
				"expense_time" => date("h:i:sA"),
				"expense_time_stamp" => time()
			);
			
			array_push($expenseToday,$expense_arr);
			
			$updatedata = array('$set' => array("expense" => json_encode($expenseToday)));
			$collection->updateOne(array('expense' => json_encode($expenseTodayArr)),$updatedata);
			
			echo 1;
			
			exit;

		}else{
			$expense_arr = array(
				"expense_amount" => $expense_amount,
				"expense_reason" => $expense_reason,
				"expense_remarks" => $expense_remarks,
				"expense_time" => date("h:i:sa"),
				"expense_time_stamp" => time()
			);
			
			
			$insertdata = array(
				"expense"=>json_encode(array($expense_arr)),
				"doc" => date("d-m-Y h:i:sa"),
				"creation_timestamp" => time(),
				"creation_date" => date('Y-m-d'),
				"trash_flag" => 0
			);
			$collection->insertOne($insertdata);
			
			echo 1;
			
			exit;
		}
		
	}else if($_POST['mode'] == "edit"){
		ob_clean();
		
		$creation_timestamp = $_POST['timestamp'];
		
		$allexpenseDetails = $DailyExpense->getAllDailyExpenses(array('creation_date' => date('Y-m-d'),'trash_flag' => 0));
		
		if(!empty($allexpenseDetails)){
			$expeneArr = $allexpenseDetails['expense'];
		
			
			$data = array(
				"expense_data" => $allexpenseDetails,
				"code" => 1
			);
			
			echo json_encode($data);exit;
		}else{
			$data = array(
				"expense_data" => array(),
				"code" => 0
			);
			
			echo json_encode($data);exit;
		}
	}
	
	
	

}
require_once("config/config.php"); 
require_once("includes/header.php");



$allexpenses = $DailyExpense->getAllDailyExpenses(array('creation_date' => date('Y-m-d'),'trash_flag' => 0));
$expenseToday = $DailyExpense->getAllExpensesToday();
/*echo "<pre>";
print_r($expenseToday);
echo"</pre>";
exit;*/
?> 


<div class="container">
  <h2 align="center">Add Expenses</h2> 
  <!-- Trigger the modal with a button -->

  <div class="col-md-10 content" style="padding-top: 20px;">
	<div class="panel panel-primary">
		<div class="panel-heading panel-heading-display" id="expensesTodayHeading">
			Expense Details
		</div>
		<div class="panel-body table-responsive" style="padding: 30px;margin-bottom: 0px">
		<!--<div class="alert alert-success" style="display: none;"></div>-->
		<table id="expenseTodayList" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
			<thead style="background-color: #e9fa839e;">
				<tr> 
					<th>Amount</th>
					<th>Reason</th>
					<th>Remarks</th>
					<th>Time</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody id="showExpenses">   
				
		   </tbody>
		</table>
	</div>
  </div>
</div>
  <div class="col-md-2 content" style="padding-top: 20px;">
	<button type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#addEditExpenseModal">Add+</button>
  </div>
  <!-- Modal -->
  <div class="modal fade" id="addEditExpenseModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Enter Expenses Details</h4>
        </div>
        <div class="modal-body">
          <form action="" name="expense_form" id="expenseFrm">
			  <div class="form-group">
				<label for="amount">Amount</label>
				<input type="text" class="form-control" name="expense_amount" id="expense_amount" placeholder="Enter expense amount">
				<span id="amount_error" style="color:red;font-size:10px;display:none"></span>
			  </div>
			  <div class="form-group">
				<label for="reason">Reason</label>
				<input type="text" class="form-control" name="expense_reason" id="expense_reason" placeholder="Enter expense reason">
				<span id="reason_error" style="color:red;font-size:10px"></span>
			  </div>
			  <div class="form-group">
				<label for="remarks">Remarks (If Any)</label>
				<input type="text" class="form-control" name="expense_remarks" id="expense_remarks" placeholder="Enter remarks if anys">
			  </div>
			  <input type="button" class="btn btn-success" name="expense_frm_submit" id="expense_frm_submit" value="Save">
			</form> 
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  
</div>

<div class="modal fade" id="messageModal" role="dialog">
  <div class="modal-dialog modal-sm" style="top: 200px;left:5px">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #5088d7;color: white;">
       <h4 class="modal-title">
         Response Message
        </h4> 
      </div>
      <div class="modal-body" id="messagedisplay" style="font-size: 16px;padding: 20px">         
		
      </div>
      <div class="modal-footer" style="padding: 8px">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
/*$(document).ready(function(){
	var i=0;
	$(document).on('click', '#add', function(){  
        i++;  
        $('#addExpenseTable').append('<tr id="row'+i+'"><td><input type="text" class="form-control" placeholder="Enter amount" name="amount[]"></td><td><input type="text" class="form-control" placeholder="Enter details" name="for_what[]"></td><td><input type="text" class="form-control" placeholder="Enter remarks" name="remarks[]"></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');   
    });	
	
	$(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove();  
    });  
	  
	
});*/
var allexpenses = <?php echo json_encode($allexpenses);?>;
var expenseToday = <?php echo json_encode($expenseToday);?>;
$('#addEditExpenseModal').modal({"backdrop"  : "static",
					"keyboard"  : true,
					"show"      : false                    
				});

</script>
<script src="js/add-edit-daily-expense.js"></script> 

<?php

require_once("includes/footer.php");
?> 

