<?php
    ob_start();
    session_start();
    if(isset($_SESSION["id"])) {
        $pageName = "My Balance";
        $setNav = ""; // To Add Navbar To The Page
        include "init.php";
        // Saler Name
        $username = $_SESSION["username"];
        $sup_id = $_SESSION["id"];
        // fetch item from db
        $stmt = $con->prepare("SELECT * FROM my_balance");
        $stmt->execute();
        $items = $stmt->fetchAll();

?>
<div class="container">
    <h2>Latest Operations</h2>
    <!-- Sales Table -->
    <table class="table table-striped bill">
        <th>No</th>
        <th>Item</th>
        <th>Quantity</th>
        <th>Price</th>
        <th>Dicount</th>
        <th>Total</th>
    </table>
</div>
<?php
    include $temp . "footer.php";

    } else {
        header("Location: login.php");
        exit;
    }
    ob_end_flush();
?>