<?php
    ob_start();
    session_start();
    if(isset($_SESSION["id"])) {
        $pageName = "Items";
        $setNav = "";
        include "init.php";
        $username = $_SESSION["username"];

        // Catch Data Come From User
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            // Attach Data To Variables
            $item_name = $_POST["item_name"];
            $price = $_POST["price"];
            $date = $_POST["date"];
            $count = $_POST["count"];
            $isbn = $_POST["isbn"];
            $medicine = $_POST["medicine"];
            $limit = $_POST["limit"];
            $cat = $_POST["cat"];
            $sup = $_POST["sup"];

            // Here Must Be The Validation of The All Fields But Later

            // Deal With DB
            $stmt = $con->prepare("INSERT INTO items (`item_name`, `item_price`, `date_expire`, `count`, `isbin`, `medicine_bar`, `cat_id`, `sup_id`, `order_limit`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute(array($item_name, $price, $date, $count, $isbn, $medicine, $cat, $sup, $limit));
            $result = $stmt->rowCount();
            if($result) {
                echo '<div class="alert alert-success">Inserted Done</div>';
                header("refresh:2; url=index.php?page-title=items-status");
            } else {
                echo '<div class="alert alert-danger">Inserted Failed</div>';
                header("refresh:2; url=index.php?page-title=items-status");
            }
        }
?>
<div class="container items">
    <h2 class="text-center">Add Item</h2>
    <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <div class="mb-3">
            <label for="item_name" class="form-label">Item Name</label>
            <input type="text" class="form-control" id="item_name" placeholder="Name" name="item_name">
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Item Price</label>
            <input type="text" class="form-control" id="price" placeholder="price" name="price">
        </div>
        <div class="mb-3">
            <label for="date" class="form-label">date Expire</label>
            <input type="date" class="form-control" id="date" placeholder="date" name="date">
        </div>
        <div class="mb-3">
            <label for="count" class="form-label">Count</label>
            <input type="text" class="form-control" id="count" placeholder="count" name="count">
        </div>
        <div class="mb-3">
            <label for="isbn" class="form-label">isbn</label>
            <input type="text" class="form-control" id="isbn" placeholder="isbn" name="isbn">
        </div>
        <div class="mb-3">
            <label for="medicine" class="form-label">Medicine Bars</label>
            <input type="text" class="form-control" id="medicine" placeholder="medicine" name="medicine">
        </div>
        <div class="mb-3">
            <label for="limit" class="form-label">Order Limit</label>
            <input type="text" class="form-control" id="limit" placeholder="limit" name="limit">
        </div>
        <div class="mb-3">
            <label class="form-label">Categories</label>
            <select class="form-control" name="cat">

                <?php
                    // Fetch Categories
                    $stmt = $con->prepare("SELECT * FROM categories");
                    $stmt->execute();
                    $cats = $stmt->fetchAll();
                    foreach($cats as $cat) {
                        echo '<option value="'. $cat["cat_id"] .'">'. $cat["cat_name"] .'</option>';
                    }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Suppliers</label>
            <select class="form-control"name="sup">
                <?php
                    // Fetch Categories
                    $stmt = $con->prepare("SELECT * FROM suppliers");
                    $stmt->execute();
                    $sups = $stmt->fetchAll();
                    foreach($sups as $sup) {
                        echo '<option value="'. $sup["sup_id"] .'">'. $sup["sup_name"] .'</option>';
                    }
                ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Add Item</button>
    </form>
</div>
<?php
    include $temp . "footer.php";

    } else {
        header("Location: login.php");
        exit;
        
    }
    ob_end_flush();
?>