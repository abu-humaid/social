<?php include_once "app/db.php"; ?>
<?php include_once "app/functions.php"; ?>

<?php  
	session_start();

	/**
	 * Relogin System
	 */
	if ( isset( $_COOKIE['user_login_id'] ) ) {
		
		$user_id = $_COOKIE['user_login_id'] ;
		$sql = "SELECT * FROM users WHERE id='$user_id'";
		$data = $connection -> query($sql);
		$login_user_data = $data -> fetch_assoc();

		/**
		 * Session manage
		 */
		$_SESSION['id'] = $login_user_data['id'];
		$_SESSION['name'] = $login_user_data['name'];
		$_SESSION['email'] = $login_user_data['email'];
		$_SESSION['cell'] = $login_user_data['cell'];
		$_SESSION['uname'] = $login_user_data['uname'];
		$_SESSION['photo'] = $login_user_data['photo'];

		/**
		 * redirect profile pag 
		 */
		header("location:profile.php");
		

	}


	/**
	 * Profile page access security 
	 */
	if ( isset($_SESSION['id']) AND isset($_SESSION['name']) AND isset($_SESSION['email']) ) {
		header("location:profile.php");
	}





?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Development Area</title>
	<!-- ALL CSS FILES  -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/css/style.css">
	<link rel="stylesheet" href="assets/css/responsive.css">
</head>
<body>
	
	<?php  

		if ( isset( $_POST['signin'] ) ) {
		 	// Value get 
		 	$ue 	= $_POST['ue'];
		 	$pass 	= $_POST['pass'];

		 	if ( empty($ue) || empty($pass) ) {
		 		$mess = '<p class="alert alert-danger"> All fields are required ! <button class="close" data-dismiss="alert">&times;</button> </p>';
		 	}else {
		 		$sql = "SELECT * FROM users WHERE email='$ue' OR uname='$ue'";
		 		$data = $connection -> query($sql);
		 		$login_user_data = $data -> fetch_assoc();
		 		$count =  $data -> num_rows;

		 		if ( $count == 1 ) {

		 			if ( password_verify( $pass , $login_user_data['password'] ) == true ) {


		 				/**
		 				 * Session manage
		 				 */
		 				$_SESSION['id'] = $login_user_data['id'];
		 				$_SESSION['name'] = $login_user_data['name'];
		 				$_SESSION['email'] = $login_user_data['email'];
		 				$_SESSION['cell'] = $login_user_data['cell'];
		 				$_SESSION['uname'] = $login_user_data['uname'];
		 				$_SESSION['photo'] = $login_user_data['photo'];

		 				/**
		 				 * Set Cookie for relogin 
		 				 */
		 				setcookie('user_login_id', $login_user_data['id'], time() + (60*60*24*365*10) );

		 				
		 				/**
		 				 * redirect profile pag 
		 				 */
		 				header("location:profile.php");

		 			}else{
		 				$mess = '<p class="alert alert-info"> Wrong password ! <button class="close" data-dismiss="alert">&times;</button> </p>';
		 			}

		 			
		 		}else {
		 			$mess = '<p class="alert alert-danger"> Wrong username or email ! <button class="close" data-dismiss="alert">&times;</button> </p>';
		 		}

		 	}
		}


	?>
	

	<div class="wrap shadow">
		<div class="card">
			<div class="card-body">
				<h2>Log In now</h2>
				
					<?php  

						if (isset($mess)) {
							echo $mess;
						}


						

					?>
				<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">

					

					<div class="form-group">
						<label for="">Username / Email</label>
						<input name="ue" class="form-control" type="text">
					</div>



					<div class="form-group">
						<label for="">Password</label>
						<input name="pass" class="form-control" type="password">
					</div>

			

					<div class="form-group">
						<input name="signin" class="btn btn-primary" type="submit" value="Sign In">
					</div>
				</form>



				<a href="register.php">Crete an account</a>
			</div>
		</div>
	</div>
	







	<!-- JS FILES  -->
	<script src="assets/js/jquery-3.4.1.min.js"></script>
	<script src="assets/js/popper.min.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/custom.js"></script>
</body>
</html>