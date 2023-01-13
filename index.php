<?php

	$client = [
		'Browser and OS' => $_SERVER['HTTP_USER_AGENT'],
		'IP' => $_SERVER['REMOTE_ADDR']
	];

	//Message vars
	$msg = '';
	$msgClass = '';

	//Check for Submit
	if(filter_has_var(INPUT_POST, 'submit')){
		//Get form data into regular variables
		$name = htmlspecialchars($_POST['name']);
		$email = htmlspecialchars($_POST['email']);
		$message = htmlspecialchars($_POST['message']);
		$browserOs = $client['Browser and OS'];
		$ipAddress = $client['IP'];

		//Check Required Fields
		if(!empty($name) && !empty($email) && !empty($message)){
			//Passed
			//Validate Email
			if(filter_var($email, FILTER_VALIDATE_EMAIL) === false){
				//Failed
				$msg = 'Please use a valid email';
				$msgClass = 'alert-danger';
			} else {
				//Passed
				//Recipient Email
				$toEmail = 'randywalter236@gmail.com';
				//Subject
				$subject = 'Contact Request From '.$name;
				//Body of the email Layout
				$body = '<h2>Contact Request</h2>
					<h4>Name</h4><p>'.$name.'</p>
					<h4>Email</h4><p>'.$email.'</p>
					<h4>Message</h4><p>'.$message.'</p>
					<h4>Browser and OS</h4><p>'.$browserOs.'</p>
					<h4>IP Addree</h4><p>'.$ipAddress.'</p>
				';

				//Email Headers
				$headers = "MIME-Version: 1.0" ."\r\n";
				$headers .="Content-Type:text/html;charset=UTF-8" . "\r\n";

				//Additional Headers(Who is it from)
				$headers .= "From: " .$name. "<".$email.">". "\r\n";

				//Using the mail fuction to send data
				if(mail($toEmail, $subject, $body, $headers)){
					//Email sent
					$msg = 'Your Email has been sent';
					$msgClass = 'alert-success';
				} else{
					//Failed
					$msg = 'Your email was not sent';
					$msgClass = 'alert-danger';
				}

			}
			
		} else{
			//Failed
			$msg = 'Please fill in all fields';
			$msgClass = 'alert-danger';
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Contact Us</title>

	<link rel="stylesheet" type="text/css" href="bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<nav class="navbar navbar-default navBar">
		<div class="container">
			<div class="navbar-header">
				<a class="navbar-brand" href="index.php">My Website</a>
			</div>
		</div>
	</nav>
	<div class="container">
		<?php if($msg != ''): ?>
			<div class="alert <?php echo $msgClass; ?>"><?php echo $msg; ?></div> 
		<?php endif; ?>
		<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
			<div class="form-group">
				<label>Name</label>
				<input type="text" name="name" class="form-control" value="<?php echo isset($_POST['name']) ? $name : ''; ?>">
			</div>
			<div class="form-group">
				<label>Email</label>
				<input type="text" name="email" class="form-control" value="<?php echo isset($_POST['email']) ? $email : ''; ?>">
			</div>
			<div class="form-group">
				<label>Message</label>
				<textarea name="message" class="form-control"><?php echo isset($_POST['message']) ? $message : ''; ?></textarea>
			</div>
			<br>
			<button type="submit" name="submit" class="btn btn-primary">Submit</button>
		</form>
	</div>
</body>
</html>
