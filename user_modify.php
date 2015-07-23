<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title>User Modify</title>
	<link rel="stylesheet" type="text/css" href="styles/usermodify.css">
</head>
<body>
	<?php 
		$id=$_GET['id'];
		error_reporting(E_ALL ^ E_DEPRECATED);
	
		define('DB_NAME','test');
		define('DB_USER','root');
		define('DB_PASSWORD','');
		define('DB_HOST','localhost');
		
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

		while($row=mysql_fetch_assoc($result))
		{	
			if($row['id']==$id)
        	{
        		$prename=$row['username'];
        		$prepassword=$row['password'];
        		$prerole=$row['role'];
        		break;
        	}
        }
        mysql_close();
	?>
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
	<div class="dTable">
        <div class="dRow">
            <div class="dData">
            	<p>Previous User Information:</p>
            	<table>
                    <tr>
                        <td><p>UserID:</p></td>
                        <td><p><?php echo $id;?></p></td>
                    </tr>
                    <tr>
                        <td><p>UserName:</p></td>
                        <td><p><?php echo $prename;?></p></td>
                    </tr>                 
                    <tr>
                        <td><p>Password:</p></td>
                        <td><p><?php echo $prepassword;?></p></td>
                    </tr>
                    <tr>
                        <td><p>Role:</p></td>
                        <td><p><?php echo $prerole;?></p></td>
                    </tr>
                </table>
            </div>
            <div class="dData">
                <p>Please Enter the New Information:</p>
                <form method="post" action="showuser.php">
                    <table>
                        <tr>
                            <td><p>UserID</p></td>
                            <td><input type="text" name="id" value="<?php echo $id;?>" readonly="true"></td>
                        </tr>
                        <tr>
                            <td><p>UserName:</p></td>
                            <td><input type="text" name="username" value="<?php echo $prename;?>"></td>
                        </tr>                 
                        <tr>
                            <td><p>Password:</p></td>
                            <td><input type="text" name="password" value="<?php echo $prepassword;?>"></td>
                        </tr>
                        <tr>
                            <td><p>Role:</p></td>
                            <td><input type="text" name="role" value="<?php echo $prerole;?>"></td>
                        </tr>
                        <tr>
                            <td><input type="submit" value="SetNow"></td>
                            <td><input type="reset" value="Reset"></td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>  
    </div>
    <p>Role: 1->Admin 2->Manager 3->Emplyee</p>
	
</body>
</html>