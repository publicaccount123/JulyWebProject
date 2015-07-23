<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="styles/showuser.css">
</head>
<body>
	<div class="dTable">
        <div class="dRow">
            <div class="dData col1">
                <img src="images/logo.png">    
            </div>           
            <div class="dData col2">
            	<p>Hello</p>                 
            </div>
            <div class="dData col3">                 
                <p>Admin</p>
            </div>
        </div>
	</div>
    <hr>
    <?php
    	error_reporting(E_ALL ^ E_DEPRECATED);
	
		define('DB_NAME','test');
		define('DB_USER','root');
		define('DB_PASSWORD','');
		define('DB_HOST','localhost');
		
		$id=$_POST['id'];
		$name=$_POST['username'];
	    $pwd=$_POST['password'];
	    $role=$_POST['role'];
		
		$link=mysql_connect(DB_HOST,DB_USER,DB_PASSWORD);
		
		if(!$link){
			die('Could not connect:'.mysql_error());
		}
		
		$db_selected=mysql_select_db(DB_NAME,$link);
		if(!$db_selected){
			die('Can\'t use '.DB_NAME.':'.mysql_error());
		}
		
		$sqlupdate="update user set username='".$name."',password='".$pwd."',role='".$role."' where id=".$id;
		//$sqlselect="select * from user order by id";
		$result=mysql_query($sqlupdate);	
		$mark=mysql_affected_rows();

		if($mark>0){
			echo "<p>success update</p>";
		}

		$sqlselect="select * from user order by id";
		$result=mysql_query($sqlselect);	

		?>
			<h1>USERS INFORMATION</h1>
			<table width=100% border='1px'>
				<tr>
					<th>ID</th>
					<th>USERNAME</th>
					<th>PASSWORD</th>
					<th>ROLE</th>					
				</tr>

		<?php
		while($row=mysql_fetch_assoc($result))
		{
			?>
				<tr>
					<td><?php echo $row['id'];?></td>
					<td><?php echo $row['username'];?></td>
					<td><?php echo $row['password'];?></td>
					<td><?php echo $row['role'];?></td>
				</tr>
			<?php 
		}
		echo "</table>";	
		echo "Role: 1->Admin 2->Manager 3->Emplyee";
		mysql_close();
    ?>


</body>
</html>