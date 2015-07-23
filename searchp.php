<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
<head>
	<title></title>
</head>
<body>

	<?php
		error_reporting(E_ALL ^ E_DEPRECATED);
		
		define('DB_NAME','test');
		define('DB_USER','root');
		define('DB_PASSWORD','');
		define('DB_HOST','localhost');
		
		$firstname=$_POST['firstname'];
	    $lastname=$_POST['lastname'];
	    
		
		$link=mysql_connect(DB_HOST,DB_USER,DB_PASSWORD);
		
		if(!$link){
			die('Could not connect:'.mysql_error());
		}
		
		$db_selected=mysql_select_db(DB_NAME,$link);
		if(!$db_selected){
			die('Can\'t use '.DB_NAME.':'.mysql_error());
		}
		$sqlselect="select * from candidate where firstname='".$firstname."' and lastname='".$lastname."'";
		$result=mysql_query($sqlselect);
		

		?>
		<h1>CANDIDATES INFORMATION</h1>
		<table width=100% border='1px'>
			<tr>
				<th>ID</th>
				<th>FIRST NAME</th>
				<th>LAST NAME</th>
				<th>BIRTHDAY</th>
				<th>PHOTO</th>					
			</tr>

		<?php
		if($row=mysql_fetch_assoc($result))
		{
			?>
				<tr>
					<td><?php echo $row['id'];?></td>
					<td><?php echo $row['firstname'];?></td>
					<td><?php echo $row['lastname'];?></td>
					<td><?php echo $row['birthday'];?></td>
					<td><img src="candidate/images/<?php echo $row['image_filename'];?>" alt="upload image" /></td>
				</tr>
			<?php 
		}
		echo "</table>";	
		mysql_close();
	?>

</body>
</html>