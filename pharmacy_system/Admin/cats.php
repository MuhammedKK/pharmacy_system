<?php
    session_start();
    if(isset($_SESSION["id"])) {
        $pageName = "Add Category";
        $setNav = ""; // To Add Navbar To The Page
        include "init.php";
        $username = $_SESSION["username"];

        // Catch Data Come From User
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            // Attach Data To Variables
            $cat = $_POST["cat"];
            // Here Must Be The Validation of The All Fields But Later

            // Deal With DB
            $stmt = $con->prepare("INSERT INTO categories (`cat_name`) VALUES (?)");
            $stmt->execute(array($cat));
            $result = $stmt->rowCount();
            if($result) {
                echo '<div class="container">';
                echo '<div class="alert alert-success">Insert Done</div>';
                echo '</div>';
            } else {
                echo '<div class="container">';
                echo '<div class="alert alert-success">Insert Failed</div>';
                echo '</div>';
            }
        }
?>
<div class="container supplier">
    <h2 class="text-center">Add Category</h2>
    <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>"> <!-- To Send Data To Same Page -->
        <div class="mb-3">
            <label for="cat" class="form-label">Category Name</label>
            <input type="text" class="form-control" id="cat" placeholder="Category" name="cat">
        </div>
        <button type="submit" class="btn btn-primary">Add Category</button>
    </form>
</div>


<?php
    include $temp . "footer.php";

    } else {
        header("Location: login.php");
        exit;
    }
?>