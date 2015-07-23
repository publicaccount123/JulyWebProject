<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="styles/main.css">
</head>
<body>
	
<?php
	error_reporting(E_ALL ^ E_DEPRECATED);
	
	define('DB_NAME','test');
	define('DB_USER','root');
	define('DB_PASSWORD','');
	define('DB_HOST','localhost');
	
	$name=$_POST['username'];
    $pwd=$_POST['password'];
	
	$link=mysql_connect(DB_HOST,DB_USER,DB_PASSWORD);
	
	if(!$link){
		die('Could not connect:'.mysql_error());
	}
	
	$db_selected=mysql_select_db(DB_NAME,$link);
	if(!$db_selected){
		die('Can\'t use '.DB_NAME.':'.mysql_error());
	}
	
	
	$sqlselect="select * from user order by id";
	$result=mysql_query($sqlselect);	
	$login=FALSE;
	
	
	while($row=mysql_fetch_assoc($result))
	{	
		if(($row['username']==$name)&&($row['password']==$pwd))
        {
        	?>
	        	<div class="dTable">
	      			<div class="dRow">
			            <div class="dData col1">
			                <img src="images/logo.png">    
			            </div>           
			            <div class="dData col2"> 
			                <p>Welcome</p>
			            </div>
			            <div class="dData col3">                 
			                <p><?php echo $name;?></p>
			            </div>
			        </div>
				</div>
				<hr>
        	<?php
			
			$login= TRUE;
			if($row['role']=='1')
			{
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
						<th>Process</th>
					</tr>
				<?php
				while($row=mysql_fetch_assoc($result))
				{
					$id=$row['id'];
					?>
					<tr>
						<td><?php echo $row['id'];?></td>
						<td><?php echo $row['username'];?></td>
						<td><?php echo $row['password'];?></td>
						<td><?php echo $row['role'];?></td>
						<td><a href='user_modify.php?id=<?php echo $id;?>'>Edit</a></td>
					</tr>
					<?php              
				}
				echo "</table>";	
				echo "Role: 1->Admin 2->Manager 3->Emplyee";
			}
			else if($row['role']=='3')
			{
				?>
				<table>
					<tr>
						<td><a href="add_edit.html">Register a Candidate</a></td>
					</tr>
					<tr>
						<td><a href="searchp.html">Search a Particular Candidate</a></td>
					</tr>					
					<tr>
						<td><a href="searcht.html">Search Multiple Candidates(TimeSearching)</a></td>
					</tr>
					<tr>
						<td><a href="#">Search Multiple Candidates(TechnologySearching)</a></td>
					</tr>
				</table>				
				<?php				
			}
			else if($row['role']=='2')
			{
				?>
				<table>
					<tr>						
						<td><a href="searchp.html">Search a Particular Candidate</a></td>
					</tr>
					<tr>
						<td><a href="searcht.html">Search Multiple Candidates(TimeSearching)</a></td>
					</tr>
					<tr>
						<td><a href="#">Search Multiple Candidates(TechnologySearching)</a></td>
					</tr>
				</table>
				<?php	
			}
		}		
	}	
	if($login!=TRUE)
	{
		echo "failed";
		?>
		<form method="post" action="main.php">
			<table>
				<tr>
					<td>UserName:</td>
					<td><input type="text" name="username"></td>
				</tr>
     
				<tr>
					<td>Password:</td>
					<td><input type="password" name="password"></td>
				</tr>
				<tr>
					<td><input type="submit" value="Login"></td>
					<td><input type="reset" value="Reset"></td>
				</tr>
			</table>
		</form>
		<?php
	}
	mysql_close();
?>
</body>
</html>
