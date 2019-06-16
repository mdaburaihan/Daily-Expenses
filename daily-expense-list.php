<?php
require("db_conn.php");
require("classes/dailyexpense.class.php");
require_once("config/config.php"); 
require_once("includes/header.php");

$DailyExpense = new DailyExpense();

if($_POST){
	if($_POST['mode'] == "view"){
		ob_clean();
		
		$creation_date = $_POST['creation_date'];
		
		$allexpenseDetails = $DailyExpense->getAllDailyExpenses(array('creation_date' => $creation_date,'trash_flag' => 0));
		
		if(!empty($allexpenseDetails)){
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

$allexpenses = $DailyExpense->getAllDailyExpenses(array('trash_flag' => 0,'creation_date' => array('$ne' => date('Y-m-d'))));
$allexpensesToday = $DailyExpense->getAllDailyExpenses(array('trash_flag' => 0,"creation_date" => date('Y-m-d')));
?>
<div class="container">
  <h2 align="center">Expense List</h2> 
  <!-- Trigger the modal with a button -->

  <div class="col-md-12 content" style="padding-top: 20px;">
	<div class="panel panel-primary">
		<div class="panel-heading panel-heading-display" id="expensesTodayHeading">
			Expense Details of Today
		</div>
		<div class="panel-body table-responsive" style="padding: 30px;margin-bottom: 0px">
		<!--<div class="alert alert-success" style="display: none;"></div>-->
		<table id="expenseTodayList" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
			<thead style="background-color: #e9fa839e;">
				<tr> 
					<th>#</th>
					<th>Date</th>
					<th>Total Amount</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody id="showAllExpensesToday">   
				
		   </tbody>
		</table>
	</div>
  </div>
</div>
<div class="col-md-12 content" style="padding-top: 20px;">
	<div class="panel panel-primary">
		<div class="panel-heading panel-heading-display" id="expensesTodayHeading">
			Previous Expense Details
		</div>
		<div class="panel-body table-responsive" style="padding: 30px;margin-bottom: 0px">
		<!--<div class="alert alert-success" style="display: none;"></div>-->
		<table id="expenseTodayList" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
			<thead style="background-color: #e9fa839e;">
				<tr> 
					<th>#</th>
					<th>Date</th>
					<th>Total Amount</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody id="showAllExpenses">   
				
		   </tbody>
		</table>
	</div>
  </div>
</div>
</div>

<!-- Modal -->
<div id="viewExpenseModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="viewExpenseTitle"></h4>
      </div>
      <div class="modal-body" id="viewExpenseBody">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<script>
var allexpenses = <?php echo json_encode($allexpenses);?>;
var allexpensesToday = <?php echo json_encode($allexpensesToday);?>;
</script>
<script src="js/daily-expense-list.js"></script> 

<?php

require_once("includes/footer.php");
?> 