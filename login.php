<?php
  session_start();
  
  function login() {
    $url = 'https://praka-jakarta-2024-229415464489.asia-southeast2.run.app/api/dashboardUsers/login';
    $data = array('username' => $_POST["name"], 'password' => $_POST["password"]);
    $options = array(
        'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data)
        )
    );
    $context  = stream_context_create($options);

    $result = @file_get_contents($url, false, $context);
    if ($result === FALSE) {
      echo "<script type='text/javascript'>alert('Login failed!')</script>";
    } else {
      $data = json_decode($result);
      $_SESSION["username"]= $data->data->username;
      $_SESSION["name"]= $data->data->name;
      $_SESSION["userDob"]= $data->data->dob;
      $_SESSION["roleId"]= $data->data->roleId;
      $rtn = explode(" ", $http_response_header[4]);
      $_SESSION["Authorization"]= $rtn[2];
      // var_dump($http_response_header);
      // echo 'kunam'.$http_response_header[4];
      header('Location: dashboard.php');
    }
  }

  if(isset($_POST['submitLogin'])){
    login();
  }

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="css/master.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/eonasdan-bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">
  <title>Login | Praka-Jakarta</title>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>
  <div class="left-background"></div>
  <div class="login-box">
    <div class="login-panel">
      <h1>Praka Jakarta</h1>
      <h6>Welcome admin! Please login to your account.</h6>
      <form action="#" method="post">
        <input type="text" class="form-control" placeholder="Username" name="name" aria-label="Username">
        <input type="password" class="form-control" placeholder="Password" name="password" aria-label="Password">
        <div class="button-group">
          <button class="login" type="submit" name="submitLogin">login</button>
        </div>
      </form>
    </div>
    <h class="terms">Term of use. Privacy policy.</h>
  </div>
  <!-- Optional JavaScript -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.23.0/moment.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/eonasdan-bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
  <script src="js/master.js"></script>
</body>

</html>
