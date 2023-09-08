
<!DOCTYPE html>
<html lang="en">
    <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title> HR software</title>

        <!-- CSS -->
        <link href="<?php echo base_url('public/css/bootstrap.min.css'); ?>" type="text/css" rel="stylesheet" />
        <link href="<?php echo base_url('public/css/signin.css'); ?>" type="text/css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src='<?php echo base_url('public/js/bootstrap.min.js'); ?>' type='text/javascript'></script>
        <script src='<?php echo base_url('public/js/common.js'); ?>' type='text/javascript'></script>

    </head>

<body class="text-center">


<main class="form-signin w-100 m-auto ">
  <form action="<?php echo base_url('Login/AuthLogin'); ?>" method="post">
    <img class="mb-4" src="<?php echo base_url('public/images/crew_logo_final.png'); ?>" alt="" width="100" >
    <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

    <div class="form-floating">
      <input type="text" name="email"  class="form-control" id="floatingInput" placeholder="Email id">
      <label for="floatingInput">Username</label>
    </div>
    <div class="form-floating mb-3" style="display:flex;">
     <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password">
     <label for="floatingInput">Password</label>

        <i id="eye-btn"class="fa fa-eye eyebutton" style="font-size: 20px ; background-color: white;position: absolute;right:8px;margin-top: 18px; cursor:pointer;" onclick="eyebutton()"></i>
    </div>

    
    <button class="w-100 btn btn-lg btn-success" type="submit">Sign in</button>
    <p class="mt-5 mb-3 text-muted">&copy; 2022–2023</p>
   
  </form>
<!-- <?php
$session = session();
$session->setFlashdata('login_failed', 'Incorrect email or password. Please try again.');

?> -->
 
</main>
<!-- <script>
  const passwordField = document.getElementById("floatingPassword");
const togglePassword = document.getElementById("eye-btn");

togglePassword.addEventListener("click", function () {
  if (passwordField.type === "password") {
    passwordField.type = "text";
  } else {
    passwordField.type = "password";
  }
});
  </script> -->
</body>

</html>

