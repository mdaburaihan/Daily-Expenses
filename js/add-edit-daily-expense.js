$(document).ready(function(){
	console.log(expenseToday);
	console.log(allexpenses);
	
	var expensehtml = "";
	for(i in expenseToday){
		expensehtml += "<tr>";
		expensehtml += "<td>₹"+expenseToday[i].expense_amount+"</td>";
		expensehtml += "<td>"+expenseToday[i].expense_reason+"</td>";
		expensehtml += "<td>"+expenseToday[i].expense_remarks+"</td>";
		expensehtml += "<td>"+expenseToday[i].expense_time+"</td>";
		expensehtml += "<td><a href='javascript:void(0);' class='btn btn-warning btn-sm' id='editExpense' data='"+expenseToday[i].expense_time_stamp+"' role='button'>Edit</a> | <a href='javascript:void(0);' class='btn btn-danger btn-sm' id='viewExpenses' data='"+expenseToday[i].creation_date+"' role='button'>Delete</a></td>";
		expensehtml += "<tr>";
	}
	
	if(expensehtml == ''){
		$("#showExpenses").html('NO DATA TO DISPLAY');
	}else{
		$("#showExpenses").html(expensehtml);
	}
	
	
	//Edit Expense Details
	$('#editExpense').click(function(){
		var timestamp = $(this).attr("data");
		console.log(timestamp);
		
		$.ajax({  
			url:"add-edit-daily-expense.php",  
			method:"POST",  
			data: {timestamp:timestamp,mode:"edit"},  
			success:function(response){ 
			
			console.log(response);
				
			}
		});

	});
	
});

$('#expense_frm_submit').click(function(){
	
	var amount = $("#expense_amount").val();
	var reason = $("#expense_reason").val();
	
	if(amount == null || amount == ""){
		$("#amount_error").text('Please enter expense amount');
		$("#amount_error").show();
		return false;
	}
	
	if(reason == null || reason == ""){
		$("#reason_error").text('Please reason of expense');
		$("#reason_error").show();
		return false;
	}
	
	var expense_form_data = $('#expenseFrm').serializeArray();
	
	//console.log(expense_form_data);
	
   $.ajax({  
		url:"add-edit-daily-expense.php",  
		method:"POST",  
		data: {postedData:expense_form_data,mode:"add"},  
		success:function(response){  			 
			
			if(response == 1){
				$('#messagedisplay').html("Expenses added successfully.");
				$('#messageModal').modal({"backdrop"  : "static",
					"keyboard"  : true,
					"show"      : true                    
				});
				
				$('#expenseFrm')[0].reset();
				$('#addEditExpenseModal').modal('hide');

			}
				
		}  
   });
}); 




