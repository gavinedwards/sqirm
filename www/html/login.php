<?php
  include "../inc/dbinfo.inc"; 
  session_start();
?>
<html>
  <head>
    <style>
      <?php include "class.css"; ?>
      <?php include "server.php"; ?>
    </style>
  </head>
<body>
<div class="content"><h1>Login Page</h1></div>
<form method="post" action="login.php">
<div class="container">
<label>Username</label> <input type="text" name="username"> <br />
<label>Password</label> <input type="password" name="password"> <br />
<button type="submit" class="btn" name="login_user">Login</button> <br />
</div>
<p>
<a href="register.php">Sign up</a>
</p>
</form>
	</div>
</body>
</html>
