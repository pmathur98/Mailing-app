<?php 
	//message vars
	$msg = '';
	$msgclass = '';
	//check for submit
	if(filter_has_var(INPUT_POST, 'submit')){
		//Get form data
		$name = htmlspecialchars($_POST['name']);
		$email = htmlspecialchars($_POST['email']);
		$remail = htmlspecialchars($_POST['remail']);
		$message = htmlspecialchars($_POST['message']);

		// Check requierd firlds
		if (!empty($email) && !empty($name) && !empty($name) && !empty($message)) {
			//passed
			//check email
			if(filter_var($email, FILTER_VALIDATE_EMAIL)===false || filter_var($remail, FILTER_VALIDATE_EMAIL)===false ){
				//fail
				$msg = 'Email not valid';
				$msgclass = 'alert-danger';
			} else {
				//passed
				//recipient email
				$toemail = $remail;
				$subject = 'Contact Request from '.$name;
				$body = '<h2>Contact Request</h2>
					<h4>Name </h4><p>'.$name.'</p>
					<h4>Email </h4><p>'.$email.'</p>
					<h4>Message </h4><p>'.$message.'</p>
				';

				// email headers
				$headers = "MIME-Version: 1.0" ."\r\n";
				$headers .= "Content-Type:text/html;charset=UTF-8" ."\r\n";
				$headers .= "From: ".$name. "<".$email.">"."\r\n";
				if(mail($toemail, $subject, $body, $headers)){
					$msg = 'Your email has been sent';
					$msgclass = 'alert-success';
				}
				else{
					$msg = 'Your email was not send';
					$msgclass = 'alert-danger';
				}
			}
		} else {
			//failed
			$msg = 'Please fill in all fields';
			$msgclass = 'alert-danger';
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Mail it</title>
	<link rel="shortcut icon" href="img/143382.png" type="image/png">
	<link rel="stylesheet" href="https://bootswatch.com/cosmo/bootstrap.min.css">
</head>
<body>
	<nav class="navbar navbar-default">
		<div class="container">
			<div class="navbar-header">
				<a class="navbar-brand" href="index.php">Mail it</a>
			</div>
		</div>	
	</nav>
	<div class="container">
	<?php  if($msg != ''):?>
		<div class="alert <?php echo $msgclass;?>"><?php echo $msg; ?></div>
	<?php endif; ?>
		<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
			<div class="form-group">
				<label>Your Name</label>
				<input type="text" name="name" class="form-control" value="<?php echo isset($_POST['name']) ? $name : '' ?>">
			</div>
			<div class="form-group">
				<label>Your Email</label>
				<input type="text" name="email" class="form-control" value="<?php echo isset($_POST['email']) ? $email : '' ?>">
			</div>
			<div class="form-group">
				<label>Recipient Email</label>
				<input type="text" name="remail" class="form-control" value="<?php echo isset($_POST['remail']) ? $remail : '' ?>">
			</div>
			<div class="form-group">
				<label>Message</label>
				<textarea name="message" class="form-control"><?php echo isset($_POST['message']) ? $message : '' ?></textarea>
			</div>
			<br>
			<button type="submit" name="submit" class="btn btn-primary">Submit</button>
		</form>
	</div>
</body>
</html>