<html>
<?php include("timezone.php"); ?>
<head>
		<title>Library Management System</title>
		
		<style>
		
		
.container {
	width:100%;
	margin:auto;
}
		
.table {
    width: 100%;
    margin-bottom: 20px;
}	

.table-striped tbody > tr:nth-child(odd) > td,
.table-striped tbody > tr:nth-child(odd) > th {
    background-color: #f9f9f9;
}
		
		</style>
		
</head>


<body>
	<div class = "container">
		<div id = "header">
		<br/>
				
								<img src = "images/dmi.png" style = " margin-top:-17px; float:left; margin-left:115px; margin-bottom:-6px; width:100px; height:100px;">
				<img src = "images/dmi.png" style = " margin-top:-17px; float:right; margin-right:115px; width:100px; height:100px;" >
				<center><h5 style = "font-style:Calibri"></h5>&nbsp; &nbsp;&nbsp; St. Joseph University Tanzania &nbsp;	&nbsp; </center>
				<center><h5 style = "font-style:Calibri; margin-top:-14px;"></h5> &nbsp; &nbsp; Online Library Management System</center>
				<center><h5 style = "font-style:Calibri; margin-top:-14px;"></h5> St. Joseph College of engineering and technology </center>
				
			<p style = "margin-left:30px; margin-top:50px; font-size:14pt; font-weight:bold;">Returned Book Information&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
        <div align="right">
		<b style="color:blue;">Date Prepared:</b>
		<?php include('currentdate.php'); ?>
        </div>			
		<br/>
		<br/>
		<br/>
				<?php if (isset($_POST['print'])){
				
				$sort=$_POST['print_sort']; ?>
<?php
include ('include/dbcon.php');
							$return_query= mysql_query("select * from return_book 
							LEFT JOIN book ON return_book.book_id = book.book_id 
							LEFT JOIN user ON return_book.user_id = user.user_id 
							where date_returned between '$sort 00:00:01' and '$sort 23:59:59'") or die (mysql_error());
								$return_count = mysql_num_rows($return_query);
							
							$count_penalty = mysql_query("SELECT sum(book_penalty) FROM return_book where date_returned between '$sort 00:00:01' and '$sort 23:59:59' ")or die(mysql_error());
							$count_penalty_row = mysql_fetch_array($count_penalty);
?>
						<table class="table table-striped">			
                                <div class="pull-left">
                                    <div class="span"><div class="alert alert-info"><i class="icon-credit-card icon-large"></i>&nbsp;Total Amount of Penalty:&nbsp;<?php echo "Php ".$count_penalty_row['sum(book_penalty)'].".00"; ?></div></div>
                                </div>
						  <thead>
								<tr>
									<th>Barcode</th>
									<th>Borrower Name</th>
									<th>Title</th>
									<th>Author</th>
									<th>ISBN</th>
									<th>Date Borrowed</th>
									<th>Due Date</th>
									<th>Date Returned</th>
									<th>Penalty</th>
								</tr>
						  </thead>   
						  <tbody>
<?php
							while ($return_row= mysql_fetch_array ($return_query) ){
							$id=$return_row['return_book_id'];
?>
							<tr>
								<td><?php echo $return_row['book_barcode']; ?></td>
								<td style="text-transform: capitalize"><?php echo $return_row['firstname']." ".$return_row['lastname']; ?></td>
								<td style="text-transform: capitalize"><?php echo $return_row['book_title']; ?></td>
								<td style="text-transform: capitalize"><?php echo $return_row['author']; ?></td>
								<td><?php echo $return_row['isbn']; ?></td>
                                <?php include("timezone.php"); ?>
								<td><?php date_default_timezone_set('Africa/Nairobi'); echo date("M d, Y h:i:sa",strtotime($return_row['date_borrowed'])); ?></td>
								<?php
								 if ($return_row['book_penalty'] != 'No Penalty'){
                                     date_default_timezone_set('Africa/Nairobi'); echo "<td class='alert alert-info' style='width:100px;'>".date("M d, Y h:i:sa",strtotime($return_row['due_date']))."</td>";
								 }else {
                                     date_default_timezone_set('Africa/Nairobi'); echo "<td>".date("M d, Y h:i:sa",strtotime($return_row['due_date']))."</td>";
								 }
								
								?>
								<?php
								 if ($return_row['book_penalty'] != 'No Penalty'){
                                     date_default_timezone_set('Africa/Nairobi'); echo "<td class='alert alert-danger' style='width:100px;'>".date("M d, Y h:i:sa",strtotime($return_row['date_returned']))."</td>";
								 }else {
                                     date_default_timezone_set('Africa/Nairobi'); echo "<td>".date("M d, Y h:i:sa",strtotime($return_row['date_returned']))."</td>";
								 }
								
								?>
								<?php
								 if ($return_row['book_penalty'] != 'No Penalty'){
									 echo "<td class='alert alert-warning' style='width:100px;'>Php ".$return_row['book_penalty'].".00</td>";
								 }else {
									 echo "<td>".$return_row['book_penalty']."</td>";
								 }
								
								?>
							</tr>
				<?php }	} ?>
								<br />
						  </tbody> 
					  </table> 

<br />
<br />
							<?php
								include('include/dbcon.php');
								include('session.php');
								$user_query=mysql_query("select * from admin where admin_id='$id_session'")or die(mysql_error());
								$row=mysql_fetch_array($user_query); {
							?>        <h2><i class="glyphicon glyphicon-user"></i> <?php echo '<span style="color:blue; font-size:15px;">Prepared by:'."<br /><br /> ".$row['firstname']." ".$row['lastname']." ".'</span>';?></h2>
								<?php } ?>


			</div>
	
	
	
	

	</div>
</body>


</html>