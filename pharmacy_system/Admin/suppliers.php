<?php
    session_start();
    if(isset($_SESSION["id"])) {
        $pageName = "Add Supplier";
        $setNav = "";
        include "init.php";
        $username = $_SESSION["username"];

        // Catch Data Come From User
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            // Attach Data To Variables
            $name = $_POST["name"];
            $phone = $_POST["phone"];
            $email = $_POST["email"];
            $sup_type = $_POST["sup-type"];

            // Here Must Be The Validation of The All Fields But Later

            // Deal With DB
            $stmt = $con->prepare("INSERT INTO suppliers (`sup_name`, `phone`, `email`, `sup_type`) VALUES (?, ?, ?, ?)");
            $stmt->execute(array($name, $phone, $email, $sup_type));
            $result = $stmt->rowCount();
            if($result) {
                echo '<div class="alert alert-success">Insert Done!</div>';
            } else {
                echo '<div class="alert alert-danger">Insert failed!</div>';
            }
        }
?>
<div class="container supplier">
    <h2 class="text-center">Add Supplier</h2>
    <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Supplier Name</label>
            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Name" name="name">
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" class="form-control" id="phone" placeholder="Phone" name="phone">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" placeholder="Email" name="email">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <select class="form-control"name="sup-type">
                <option value="0">Saler</option>
                <option value="1">Moderator</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Add Supplier</button>
    </form>
</div>
<?php
    include $temp . "footer.php";

    } else {
        header("Location: login.php");
        exit;
        
    }
?>