<?php
    ob_start();
    session_start();
    $noNavbar = '';
    $pageTitle = 'Admin | Login';

    if (isset($_SESSION['Username'])) {
      header('Location: dashboard.php'); //Redirect To Dashboard Page
    }

    include 'init.php';

    // Check If User Coming From HTTP Post Request

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

      $username = $_POST['user'];
      $password = $_POST['pass'];
      $hashedpass = sha1($password);

      // Check If User Is Exist In Database

      $stmt = $con->prepare("SELECT
                                  UserID,Username, Password 
                                FROM 
                                    users 
                                WHERE
                                    Username = ? 
                                AND 
                                    Password = ? 
                                AND 
                                    GroupID = 1
                                LIMIT 1");

      $stmt->execute(array($username, $hashedpass));
      $row = $stmt->fetch();
      $count = $stmt->rowCount();

      // If Count > 0 This Mean The Database Contain Record About This Username

      if ($count > 0) {
        $_SESSION['Username'] = $username; //Register Session name
        $_SESSION['ID'] = $row['UserID']; //Register Session ID
        header('Location: dashboard.php'); //Redirect To Dashboard Page
        exit();
      }

    }

 ?>

  <form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
    <h4 class="text-center">Admin Login</h4>
    <input class="form-control input-lg" type="text" name="user" placeholder="Username" autocomplete="off" />
    <input class="form-control input-lg" type="password" name="pass" placeholder="Password" autocomplete="new-password" />
    <input class="btn btn-lg btn-primary btn-block" type="submit" value="Login" />
  </form>

<?php 

include $tpl . "footer.php";
ob_end_flush();

?>