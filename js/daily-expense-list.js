var ExpenseList={
	
	ShowAllPreviousExpenses:function(){
		var expensehtml = "";
		var sl = 0;
		for(i in allexpenses){
			sl++;
			
			var total_amount = 0;
			var expense = allexpenses[i].expense;
			for(j in expense){
				total_amount += parseInt(expense[j].expense_amount);
			}
			expensehtml += "<tr>";
			expensehtml += "<td>"+sl+"</td>";
			expensehtml += "<td>"+allexpenses[i].creation_date+"</td>";
			expensehtml += "<td>₹"+total_amount+"</td>";
			expensehtml += "<td><a href='javascript:void(0);' class='btn btn-info btn-sm' id='viewExpensesDtls' data='"+allexpenses[i].creation_date+"' role='button'>View</a></td>";
			expensehtml += "<tr>";
		}
		
		if(expensehtml == ""){
			$("#showAllExpenses").html("NO RECORD FOUND");
		}else{
			$("#showAllExpenses").html(expensehtml);
		}
	},
	
	ShowExpensesToday:function(){
		var expenseTodayhtml = "";
		var sl = 0;
		for(i in allexpensesToday){
			sl++;
			
			var total_amount = 0;
			var expense = allexpensesToday[i].expense;
			for(j in expense){
				total_amount += parseInt(expense[j].expense_amount);
			}
			expenseTodayhtml += "<tr>";
			expenseTodayhtml += "<td>"+sl+"</td>";
			expenseTodayhtml += "<td>"+allexpensesToday[i].creation_date+"</td>";
			expenseTodayhtml += "<td>₹"+total_amount+"</td>";
			expenseTodayhtml += "<td><a href='add-edit-daily-expense.php' class='btn btn-warning btn-sm' role='button'>Modify</a> | <a href='javascript:void(0);' class='btn btn-info btn-sm' id='viewExpenses' data='"+allexpensesToday[i].creation_date+"' role='button'>View</a></td>";
			expenseTodayhtml += "<tr>";
		}
		
		if(expenseTodayhtml == ""){
			$("#showAllExpensesToday").html("NO RECORD FOUND");
		}else{
			$("#showAllExpensesToday").html(expenseTodayhtml);
		}
	},
	
	Ready:function(){
		ExpenseList.ShowAllPreviousExpenses();
		ExpenseList.ShowExpensesToday();
		
		//View Expense Details
		$('#viewExpenses,#viewExpensesDtls').click(function(){
			var creation_date = $(this).attr("data");

			$.ajax({  
				url:"daily-expense-list.php",  
				method:"POST",  
				data: {creation_date:creation_date,mode:"view"},  
				success:function(response){  			 
					
					var resp_data = JSON.parse(response);
					
					if(resp_data != "" || resp_data != undefined || resp_data != null){

						if(resp_data.code == 1){
							var expenseDtls = resp_data.expense_data;
							var expenseDtlsHtml = '';
							
							expenseDtlsHtml += '<table id="expenseTodayList" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">';
							expenseDtlsHtml += '<thead style="background-color: #e9fa839e;">';
							expenseDtlsHtml += '<tr>'; 
							expenseDtlsHtml +=  '<th>Amount</th>';
							expenseDtlsHtml +=  '<th>Reason</th>';
							expenseDtlsHtml +=  '<th>Remarks</th>';
							expenseDtlsHtml +=  '<th>Time</th>';
							expenseDtlsHtml +=  '</tr>';
							expenseDtlsHtml +=  '</thead>';
							expenseDtlsHtml +=  '<tbody>';
							
							for(k in expenseDtls){
								var expense = expenseDtls[k].expense;
								
								for(l in expense){
									expenseDtlsHtml +=  '<tr>';
									expenseDtlsHtml +=  '<td>'+expense[l].expense_amount+'</td>';
									expenseDtlsHtml +=  '<td>'+expense[l].expense_reason+'</td>';
									expenseDtlsHtml +=  '<td>'+expense[l].expense_remarks+'</td>';
									expenseDtlsHtml +=  '<td>'+expense[l].expense_time+'</td>';
									expenseDtlsHtml +=  '</tr>';
								}
							}
							
							expenseDtlsHtml +=  '</tbody>';
							expenseDtlsHtml +=  '</table>';
							
							$('#viewExpenseBody').html(expenseDtlsHtml);
							$('#viewExpenseModal').modal({"backdrop"  : "static",
								"keyboard"  : true,
								"show"      : true                    
							});
						}
					}
					
						
				}  
			});
		});
	}
	
};


$(document).ready(function(){
	ExpenseList.Ready();
});
 

