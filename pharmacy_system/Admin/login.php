<?php
session_start();
$pageName = "Login";
// $setNav = "";
include "init.php";


    // CHECK IF USER COME FROM POST REQUEST
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $hashed = sha1($password);

        $stmt = $con->prepare("SELECT `user_id`, `username`, `email`, `password` FROM users WHERE `email`= ? AND `password`= ? AND group_id=1");
        $stmt->execute(array($email, $hashed));
        $result = $stmt->fetch();
        if($result) {
            $_SESSION["id"] = $result["user_id"];
            $_SESSION["username"] = $result["username"];
            header("Location: index.php");
        } else {
            echo "Bye";
        }
        // // Transfer The Pass Into Hashing Pass
        // $hashedPass = sha1($password);
        // // Sql Statement With PDO CLass & Prepare Method With (->) Object Assign
        // $stmt = $con->prepare('SELECT Userid,  username, `password` FROM users WHERE username = ? AND `password` = ? AND Groupid = 1 LIMIT 1');
        // // Excute Query By (excute) Method Thats Accepted Array Of Data Comes From DB
        // $stmt->execute(array($username, $hashedPass));
        // // Fetching The Data
        // $rows = $stmt->fetch();
        // // Count The Rows Thats Returns From DB
        // $conut = $stmt->rowCount();
        // echo $conut;
        // // Check If ount Of Rows Greater Than 0  
        // if($conut > 0) {

        //     // Assign To Session Array The Username
        //     $_SESSION['Username'] = $username; // Assign The Username To Username In Session
        //     $_SESSION['ID'] = $rows['Userid']; // Assign The ID To SESSION ID To Make Actions To The Member Through It
        //     header('Location: dashboard.php'); // Redirect To Dashboard Page 
        //     exit(); // Exit Script
        // } else {
        //     echo '<div class="container">';
        //     echo '<div class="alert alert-danger">Sorry This User Is Not Exsist , Plz Try Again</div>';
        //     echo '</div>';
        // }
        
    }


?>

<!-- Login Form -->
<div class="container">
    <h1 class="text-center">Login To DashBoard</h1>
    <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST" class="login-form">
        <div class="input-group">
            <span class="input-group-addon"><i class="fas fa-user"></i></span>
            <input id="email" type="text" class="form-control" name="email" placeholder="Email">
        </div>
        <div class="input-group">
            <span class="input-group-addon"><i class="fas fa-lock"></i></span>
            <input id="password" type="password" class="form-control" name="password" placeholder="Password">
        </div>
        <div class="btn-submit main-btn">
            <i class="fas fa-sign-in-alt"></i>
            <input type="submit" class="login-btn" name="submit" value="Login">
        </div>
        <a href="#" class="forget-password"> Forget Password</a>
    </form>
</div>


<?php
    include $temp . "footer.php";
?>