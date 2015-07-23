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
	$birthday=$_POST['birthday'];

	$dir = 'D:\wamp\www\candidate\images';
	$link=mysql_connect(DB_HOST,DB_USER,DB_PASSWORD);
	
	if(!$link){
		die('Could not connect:'.mysql_error());
	}
	
	$db_selected=mysql_select_db(DB_NAME,$link);
	if(!$db_selected){
		die('Can\'t use '.DB_NAME.':'.mysql_error());
	}


	if($_FILES['uploadfile']['error'] != UPLOAD_ERR_OK)
	{
    	switch($_FILES['uploadfile']['error'])
    	{
        	case UPLOAD_ERR_INI_SIZE: 
            	die('The upload file exceeds the upload_max_filesize directive in php.ini');
        	break;
        	case UPLOAD_ERR_FORM_SIZE:
            	die('The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.');
	        break;
	        case UPLOAD_ERR_PARTIAL: 
	            die('The uploaded file was only partially uploaded.');
	        break;
	        case UPLOAD_ERR_NO_FILE: 
	            die('No file was uploaded.');
	        break;
	        case UPLOAD_ERR_NO_TMP_DIR:
	            die('The server is missing a temporary folder.');
	        break;
	        case UPLOAD_ERR_CANT_WRITE:
	            die('The server failed to write the uploaded file to disk.');
	        break;
	        case UPLOAD_ERR_EXTENSION: 
	            die('File upload stopped by extension.');
	        break;
	    }
	}
	list($width,$height,$type,$attr) = getimagesize($_FILES['uploadfile']['tmp_name']);

	switch($type)
	{
	    case IMAGETYPE_GIF:
	        $image = imagecreatefromgif($_FILES['uploadfile']['tmp_name']) or die('The file you upload was not supported filetype');
	        $ext = '.gif';
	    break;
	    case IMAGETYPE_JPEG:
	        $image = imagecreatefromjpeg($_FILES['uploadfile']['tmp_name']) or die('The file you upload was not supported filetype');
	        $ext = '.jpg';
	    break;    
	    case IMAGETYPE_PNG:
	        $image = imagecreatefrompng($_FILES['uploadfile']['tmp_name']) or die('The file you upload was not supported filetype');
	        $ext = '.png';
	    break;    
	    default    :
	        die('The file you uploaded was not a supported filetype.');
	}


	$sqlinsert="insert into candidate (firstname,lastname,birthday) values('$firstname','$lastname','$birthday')";
	$result=mysql_query($sqlinsert);

	$mark=mysql_affected_rows();

	
	$last_id = mysql_insert_id();
	
	$imagename = $last_id.$ext;
	$query = 'update candidate set image_filename="'.$imagename.'" where id='.$last_id;
	mysql_query($query);
	
	switch($type)
	{
	    case IMAGETYPE_GIF:
	        imagegif($image,$dir.'/'.$imagename);
	    break;
	    case IMAGETYPE_JPEG:
	        imagejpeg($image,$dir.'/'.$imagename);
	    break;
	    case IMAGETYPE_PNG:
	        imagepng($image,$dir.'/'.$imagename);
	    break;
	}
	
	imagedestroy($image);

	if($mark>0){
		echo "<p>success insert</p>";
	}

	$sqlselect="select * from candidate order by id desc";
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
		while($row=mysql_fetch_assoc($result))
		{
			?>
				<tr>
					<td><?php echo $row['id'];?></td>
					<td><?php echo $row['firstname'];?></td>
					<td><?php echo $row['lastname'];?></td>
					<td><?php echo $row['birthday'];?></td>
					<td><img src="candidate/images/<?php echo $imagename;?>" alt="upload image" /></td>
				</tr>
			<?php 
		}
		echo "</table>";	
		mysql_close();
	?>
</body>
</html>