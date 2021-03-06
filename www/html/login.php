<?php
//include config
require_once('includes/config.php');

//check if already logged in move to home page
if( $user->is_logged_in() ){ header('Location: welcome.php'); exit(); }

//process login form if submitted
if(isset($_POST['submit'])){

	if (!isset($_POST['username'])) $error[] = "Please fill out all fields";
	if (!isset($_POST['password'])) $error[] = "Please fill out all fields";

	$username = $_POST['username'];
	if ( $user->isValidUsername($username)){
		if (!isset($_POST['password'])){
			$error[] = 'A password must be entered';
		}
		$password = $_POST['password'];

		if($user->login($username,$password)){
			$_SESSION['username'] = $username;
			header('Location: index.php');
			exit;

		} else {
			$error[] = 'Wrong username or password or your account has not been activated.';
		}
	}else{
		$error[] = 'Usernames are required to be Alphanumeric, and between 3-16 characters long';
	}

}//end if submit

//define page title
$title = 'Login';

//include header template
require('layout/header.php'); 
?>
<section style="border:none; background:white;">	
  <article style="border:none;"> </article>
  <article style="border:none;">
    <div class="container">
      <div align=center style="border:none; padding:20px">
        <img src="img/logosm.png" width="150px" align="center" />
   		  	<form method="post" action="" autocomplete="off">
    	  			<h2>Please Login</h2>
    	  			<?php
    	  			//check for any errors
    	  			if(isset($error)){
    	  				foreach($error as $error){
    	  					echo '<p class="bg-danger">'.$error.'</p>';
    	  				}
    	  			}
    	  			if(isset($_GET['action'])){
    	  				//check the action
    	  				switch ($_GET['action']) {
    	  					case 'active':
    	  						echo "<h2 class='bg-success'>Your account is now active you may now log in.</h2>";
    	  						break;
    	  					case 'reset':
    	  						echo "<h2 class='bg-success'>Please check your inbox for a reset link.</h2>";
    	  						break;
    	  					case 'resetAccount':
    	  						echo "<h2 class='bg-success'>Password changed, you may now login.</h2>";
    	  						break;
    	  				}
    	  			}
    	  			?>
    	  			<input type="text" name="username" id="username" placeholder="User Name" tabindex="1" size="10">
    	  			<input type="password" name="password" id="password" placeholder="Password" tabindex="3" size="10">
				      <input type="submit" name="submit" value="Login" class="btn btn-primary btn-block btn-lg" tabindex="5">
    	  			<a href='reset.php'>Forgot your Password?</a>
    	  			<p><a href='./'>Register a new account</a></p>
   		  	</form>
      </div>
    </div>
  </article>
  <article style="border: none;">
    <div class="alert">
      <div>
        <h3>
        Disclaimer
        </h3>
        <p>
          <?php include('disclaimer.txt'); ?>
        </p>
      </div>
    </div>
  </article>
</section>
<?php 
          //include header template
          require('layout/footer.php'); 
?>
