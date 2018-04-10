<?php  session_start();
    include 'dblink.php';
?>



<!DOCTYPE html>
<html >
  <head>
    <title>Login</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
  </head>

  <body>

    <div class="login-page">
        <div class="form">
            <form class="send_pass" action="login.php">
            </form>
            <form class="login-form" method="post" action="login.php">
              <input type="text" placeholder="username" name="username"/>
              <input type="password" placeholder="password" name="password"/>
              <?php if(isset($_SESSION['error'])): ?>
              <p class="error"> *Enter correct login details </p>
              <?php endif; ?>
              <button>login</button>
              <p class="message">Forgot password? Contact SDSC</p>
            </form>
        </div>
    </div>
    <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

    <script src="js/index.js"></script>

    
    
     </body>
</html>
