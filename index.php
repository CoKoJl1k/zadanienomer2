<?php
error_reporting(0);
	$cn = mysql_connect("localhost","root","");
	if ($cn)
	{
		mysql_select_db("testajax",$cn);
	}
	if (isset($_POST['buttonsave']))
	{
		$sql = "INSERT INTO tableajax(studentname,gender,phone)
				VALUES('{$_POST[studentname]}','{$_POST[gender]}','{$_POST[phone]}')";
		$result=mysql_query($sql);
		if ($result)
		{
			echo "Successfully insert";
		}
		exit();
	}	
	//code delete
	if (isset($_POST['deletes'])) 
	{
		$sql = mysql_query("DELETE  FROM tableajax WHERE id = '{$_POST['id']}'");
		if ($sql)
		{
			echo "Success";
		}
	}
	//end
	if (isset($_POST['showtable'])) 
	{
		$sql = "SELECT * FROM tableajax";
		$result = mysql_query($sql);
		while($row=mysql_fetch_object($result))
		{
			echo "<tr>	
						<td>$row->id</td>
						<td>$row->studentname</td>
						<td>$row->gender</td>
						<td>$row->phone</td>
						<td>
						   
						    <a idd='$row->id' class='delete' href='#?idd=$row->id'>Delete</a>
						</td>
				  </tr>";
		}
		exit();
	}

?>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>

<div id="testforajax">
	<tr>
		<input type="hidden" value="" id="id" />
		<td>StudentName</td>
		<td>:</td>
		<td><input type="text" id="studentname" name="studentname" value="<?php echo $rows->studentname; ?>">
	</tr>
	<tr>
		<td>gender</td>
		<td>:</td>
		<td><input type="text" id="gender" name="gender" value="<?php echo $rows->gender; ?>">
	</tr>
	<tr>
		<td>Phone</td>
		<td>:</td>
		<td><input type="text" id="phone" name="phone" value="<?php echo $rows->phone; ?>">
	</tr>
	<input type="button" value="Save" id="save">
	
</div>
<div>
		<table border="1">
			<thead>
				<th>ID</th>
				<th>StudentName</th>
				<th>Gender</th>
				<th>Phone</th>
				<th>Action</th>
			</thead>
			<tbody id="showdata">
				
			</tbody>
		</table>
</div>
<script type="text/javascript">

	$(function() {
		showdata();
		// delete record
		$('body').delegate('.delete','click',function(){

			var IdDelete = $(this).attr('idd');
			var test=window.confirm ("Do you want to delete this record")
			if (test)
			{
				$.ajax({
					url		: "index.php",
					type 	: "POST",
					async	:  false,
					data 	: {
								deletes : 1,
								id      : IdDelete
							  },
					success:function(){
						alert("Success Delete");
						showdata ();
					}		  
					
				});
			
			}

		});
		//end
		$('#save').click(function(){
			var namestudent = $('#studentname').val();
			var genderstudent = $('#gender').val();
			var phonestudent = $('#phone').val();
			$.ajax({

					url : "index.php",
					type : "POST",
					data : {
							buttonsave : 1,
							studentname: namestudent,
							gender     : genderstudent,
							phone      : phonestudent
							},
					success:function(result)
					{
						alert("success");
						showdata();
					}
			});
		});
	})	
	function showdata()
	{
		$.ajax({
				url    : "Index.php",
				type   : "POST",
				async  : false,
				data   : {
							showtable : 1
						 },
				success: function(re)
				{
					$('#showdata').html(re);
				}
		});
	}
</script>