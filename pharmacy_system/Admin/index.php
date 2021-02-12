<?php
ob_start();
session_start();
if (isset($_SESSION["id"])) {
    $pageName = "Home";
    $setNav = "";
    include "init.php";
    $username = $_SESSION["username"];

    $page_title = (isset($_GET["page-title"])) ? $_GET["page-title"] : "";

    /******************************  Suppliers Operations **************************/
    // Report of Supplier Status
    if ($page_title == "sup-status") {
        // Fetch All Suppliers
        $stmt = $con->prepare("SELECT * FROM suppliers");
        $stmt->execute();

?>
        <!-- Suppliers Table -->
        <div class="container">
            <h2 class="text-center">Report Of Suppliers Status</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Email</th>
                        <th scope="col">Supplier Type</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = $stmt->fetch()) {
                    ?>
                        <tr>
                            <td><?php echo $row["sup_id"]; ?></td>
                            <td><?php echo $row["sup_name"]; ?></td>
                            <td><?php echo $row["phone"]; ?></td>
                            <td><?php echo $row["email"]; ?></td>
                            <td><?php echo ($row["sup_type"] == 0) ? "Saler" : "Moderator"; ?></td>
                            <td>
                                <a class="btn btn-success" href="index.php?page-title=edit-sup&sup-id=<?php echo $row["sup_id"]; ?>">Edit</a>
                                <a class="btn btn-danger confirm" href="index.php?page-title=delete&sup-id=<?php echo $row["sup_id"]; ?>">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    <?php
    } // End Of Report
    elseif ($page_title == "edit-sup") { // Edit Supplier
        // Catch Supplier ID To Get His Info
        $sup_id = $_GET["sup-id"];
        // Fetch Supplier Data
        $stmt = $con->prepare("SELECT * FROM suppliers WHERE sup_id = ?");
        $stmt->execute(array($sup_id));
        while($row = $stmt->fetch()) {
    ?>

        <div class="container supplier">
            <h2 class="text-center">Edit Supplier</h2>
            <form method="POST" action="?page-title=update-sup">
                <input type="hidden" value="<?php echo $row["sup_id"]; ?>" name="sup_id">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Name</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholer="Name" name="name" value="<?php echo $row["sup_name"]; ?>">
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone ?></label>
                    <input type="text" class="form-control" id="phone" placeholer="Phone" name="phone" value="<?php echo $row["phone"]; ?>">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" placeholer="Email" name="email" value="<?php echo $row["email"]; ?>">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Supplier Type</label>
                    <select class="form-control" name="sup-type">
                        <option value="0" <?php echo ($row["sup_type"] == 0) ? "selected": "" ?>>Saler</option>
                        <option value="1" <?php echo ($row["sup_type"] == 1) ? "selected": "" ?>>Moderator</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Edit Supplier</button>
            </form>
        </div>

    <?php 
        }
    } // End of Edit 
    elseif($page_title == "update-sup") { // Update Sending Data
        // User Id For Updateing
        $sup_id = (isset($_POST["sup_id"])) ? $_POST["sup_id"] : 0;
        $name = $_POST["name"];
        $phone = $_POST["phone"];
        $email = $_POST["email"];
        $sup_type = $_POST["sup-type"];
        // Update Statement
        $stmt = $con->prepare("UPDATE suppliers SET sup_name= ?, phone= ?, email= ?, sup_type= ? WHERE sup_id= ?");
        $stmt->execute(array($name, $phone, $email, $sup_type, $sup_id));
        $result = $stmt->rowCount();
        // Check If Update Done
        if($result) {
            echo '<div class="container">';
            echo '<div class="alert alert-success">Update Done</div>';
            echo '</div>';
            header("refresh:2; url=index.php?page-title=sup-status");
            
        } else {
            echo '<div class="alert alert-danger">Update Failed</div>';
        }
    }
    elseif($page_title == "delete-sup") { // Deleting Supplier
        // User Id For Deleting
        $sup_id = (isset($_GET["sup-id"])) ? $_GET["sup-id"] : 0;
        // Delete Statement
        $stmt = $con->prepare("DELETE FROM suppliers WHERE sup_id=?");
        $stmt->execute(array($sup_id));
        $result = $stmt->rowCount();
        // Check if Delete Done
        if($result) {
            echo '<div class="alert alert-success">Delete Done</div>';
            header("refresh:2; url=index.php?page-title=sup-status");
            
        } else {
            echo '<div class="alert alert-danger">Delete Failed</div>';
        }
    }
    
    ?>
    <!------------------------------------------------------------->
    
    <!-- Items Operations -->
    <?php
        if($page_title == "items-status") {
            // Select All Items From DB
            $stmt = $con->prepare("SELECT
                                         items.*, suppliers.sup_name, categories.cat_name 
                                    FROM 
                                        items 
                                    INNER JOIN 
                                        suppliers 
                                    ON 
                                        suppliers.sup_id = items.sup_id 
                                    INNER JOIN 
                                        categories 
                                    ON 
                                        categories.cat_id = items.cat_id");
            $stmt->execute();
        
    ?>
    <!-- Items Table -->
    <div class="container">
        <h2 class="text-center">Report Of Items Status</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Price</th>
                    <th scope="col">Date Expeire</th>
                    <th scope="col">Count</th>
                    <th scope="col">isbn</th>
                    <th scope="col">medicine Bars</th>
                    <th scope="col">Category</th>
                    <th scope="col">Supplier</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = $stmt->fetch()) {
                ?>
                    <tr>
                        <td><?php echo $row["item_id"]; ?></td>
                        <td><?php echo $row["item_name"]; ?></td>
                        <td><?php echo $row["item_price"]; ?></td>
                        <td><?php echo $row["date_expire"]; ?></td>
                        <td><?php echo $row["count"]; ?></td>
                        <td><?php echo $row["isbin"]; ?></td>
                        <td><?php echo $row["medicine_bar"]; ?></td>
                        <td><?php echo $row["cat_name"]; ?></td>
                        <td><?php echo $row["sup_name"]; ?></td>
                        <td>
                            <a class="btn btn-success" href="index.php?page-title=edit-item&item-id=<?php echo $row["item_id"]; ?>">Edit</a>
                            <a class="btn btn-danger confirm" href="index.php?page-title=delete-item&item-id=<?php echo $row["item_id"]; ?>">Delete</a>
                        </td>
                    </tr>
                <?php } 
                        ?>
            </tbody>
        </table>
    </div>
    <?php
        } // End Of Reporting
        elseif($page_title == "edit-item") {
            // $pageName = "Edit Item";
            // Catch Item Id
            $item_id = (isset($_GET["item-id"]) && is_numeric($_GET["item-id"])) ? intval($_GET["item-id"]) : 0;
            echo $item_id;
            // Fetch Data Depend On Item Id
            $stmt = $con->prepare("SELECT * FROM items WHERE item_id = ?");
            $stmt->execute(array($item_id));
            while($item = $stmt->fetch())
            {?>
                <!-- Edit Item -->
                <div class="container items">
                    <h2 class="text-center">Add Item</h2>
                    <form method="POST" action="index.php?page-title=update-item">
                        <input type="hidden" name="item_id" value="<?php echo $item["item_id"]; ?>">
                        <div class="mb-3">
                            <label for="item_name" class="form-label">Item Name</label>
                            <input type="text" class="form-control" id="item_name" placeholder="Name" name="item_name" value="<?php echo $item["item_name"]; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Item Price</label>
                            <input type="text" class="form-control" id="price" placeholder="price" name="price" value="<?php echo $item["item_price"]; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="date" class="form-label">date Expire</label>
                            <input type="date" class="form-control" id="date" placeholder="date" name="date" value="<?php echo $item["date_expire"]; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="count" class="form-label">Count</label>
                            <input type="text" class="form-control" id="count" placeholder="count" name="count" value="<?php echo $item["count"]; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="isbn" class="form-label">isbn</label>
                            <input type="text" class="form-control" id="isbn" placeholder="isbn" name="isbn" value="<?php echo $item["isbin"]; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="medicine" class="form-label">Medicine Bars</label>
                            <input type="text" class="form-control" id="medicine" placeholder="medicine" name="medicine" value="<?php echo $item["medicine_bar"]; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="limit" class="form-label">Order Limit</label>
                            <input type="text" class="form-control" id="limit" placeholder="limit" name="limit" value="<?php echo $item["order_limit"]; ?>">
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
                                        echo "<option value='". $cat["cat_id"] ."'";
                                        if($cat["cat_id"] == $item["cat_id"]) {echo "selected";};
                                        echo ">";
                                        echo $cat['cat_name'];
                                        echo "</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Suppliers</label>
                            <select class="form-control" name="sup">
                                <?php
                                    // Fetch Categories
                                    $stmt = $con->prepare("SELECT * FROM suppliers");
                                    $stmt->execute();
                                    $sups = $stmt->fetchAll();
                                    foreach($sups as $sup) {
                                        echo "<option value='". $sup["sup_id"] ."'";
                                        if($sup["sup_id"] == $item["sup_id"]) {echo "selected";};
                                        echo ">";
                                        echo $sup['sup_name'];
                                        echo "</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Edit Item</button>
                    </form>
                </div>

            <?php }
        } elseif($page_title == "update-item") { // Update Item
            // Catch The Item Id
            $item_id = $_POST["item_id"];
            $item_name = $_POST["item_name"];
            $price = $_POST["price"];
            $date = $_POST["date"];
            $count = $_POST["count"];
            $isbn = $_POST["isbn"];
            $medicine = $_POST["medicine"];
            $limit = $_POST["limit"];
            $cat = $_POST["cat"];
            $sup = $_POST["sup"];
            // Make The Updates In The DB
            $stmt = $con->prepare("UPDATE `items` SET `item_name`=?,`item_price`=?,`date_expire`=?,`count`=?,`isbin`=?,`medicine_bar`=?,`sup_id`=?,`cat_id`=?,`order_limit`=? WHERE item_id = ?");
            $stmt->execute(array($item_name, $price, $date, $count, $isbn, $medicine, $sup, $cat, $limit, $item_id));
            $result = $stmt->rowCount();
            // Check If It' Done
            if($result) {
                echo '<div class="alert alert-success">Updates Done</div>';
                header("refresh:2; url=index.php?page-title=items-status");
            } else {
                echo '<div class="alert alert-danger">Updates Failed</div>';
                header("refresh:2; url=index.php?page-title=items-status");
            }
        } elseif($page_title == "delete-item"){
            // Item Id For Deleting
            $item_id = (isset($_GET["item-id"])) ? $_GET["item-id"] : 0;
            echo $item_id;
            // Delete Statement
            $stmt = $con->prepare("DELETE FROM items WHERE item_id=?");
            $stmt->execute(array($item_id));
            $result = $stmt->rowCount();
            // Check if Delete Done
            if($result) {
                echo '<div class="alert alert-success">Delete Done</div>';
                header("refresh:2; url=index.php?page-title=item-status");
                
            } else {
                echo '<div class="alert alert-danger">Delete Failed</div>';
            }
        }
        /************************* Categories Section *************************/
        elseif($page_title == 'cats-status') {
            // Fetch All categories
            $stmt = $con->prepare("SELECT * FROM categories");
            $stmt->execute();
    ?>
    <!-- Categories Table -->
    <div class="container">
        <h2 class="text-center">Report Of categories Status</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Cat Name</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = $stmt->fetch()) {
                ?>
                    <tr>
                        <td><?php echo $row["cat_id"]; ?></td>
                        <td><?php echo $row["cat_name"]; ?></td>
                        <td>
                            <a class="btn btn-success" href="index.php?page-title=edit-cat&cat_id=<?php echo $row["cat_id"]; ?>">Edit</a>
                            <a class="btn btn-danger confirm" href="index.php?page-title=delete-cat&cat_id=<?php echo $row["cat_id"]; ?>">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
<?php
    } elseif($page_title == "edit-cat") {
        // Catch Cat ID To Get His Info
        $cat_id = $_GET["cat_id"];
        // Fetch Supplier Data
        $stmt = $con->prepare("SELECT * FROM categories WHERE cat_id = ?");
        $stmt->execute(array($cat_id));
        while($cat = $stmt->fetch()) {
            
    ?>
<div class="container supplier">
    <h2 class="text-center">Edit Category</h2>
    <form method="POST" action="index.php?page-title=update-cat"> <!-- To Send Data To Same Page -->
        <input type="hidden" value="<?php echo $cat["cat_id"]?>" name="cat_id">
        <div class="mb-3">
            <label for="cat" class="form-label">Category Name</label>
            <input type="text" class="form-control" id="cat" placeholder="Category" name="cat_name" value="<?php echo $cat["cat_name"]  ?>">
        </div>
        <button type="submit" class="btn btn-primary">Edit Category</button>
    </form>
</div>

<?php
        }
    
    }elseif($page_title == "update-cat") {
        $cat_id = (isset($_POST["cat_id"])) ? $_POST["cat_id"] : 0;
        // echo $cat_id;
        $cat_name = $_POST["cat_name"];
        // Update Statement
        $stmt = $con->prepare("UPDATE categories SET cat_name= ? WHERE cat_id= ?");
        $stmt->execute(array($cat_name, $cat_id));
        $result = $stmt->rowCount();
        if($result) {
            echo '<div class="container">';
            echo '<div class="alert alert-success">Update Done</div>';
            echo '</div>';
            header("refresh:2; url=index.php?page-title=cats-status");
            
        } else {
            echo '<div class="container">';
            echo '<div class="alert alert-success">Update Failed</div>';
            echo '</div>';
            header("refresh:2; url=index.php?page-title=cats-status");
        }
    } elseif($page_title == "delete-cat") {
        // Item Id For Deleting
        $cat_id = (isset($_GET["cat_id"])) ? $_GET["cat_id"] : 0;
        echo $cat_id;
        // Delete Statement
        $stmt = $con->prepare("DELETE FROM categories WHERE cat_id=?");
        $stmt->execute(array($cat_id));
        $result = $stmt->rowCount();
        // Check if Delete Done
        if($result) {
            echo '<div class="alert alert-success">Delete Done</div>';
            header("refresh:2; url=index.php?page-title=cats-status");
            
        } else {
            echo '<div class="alert alert-danger">Delete Failed</div>';
            header("refresh:2; url=index.php?page-title=cats-status");
        }
    }
?>

<?php

    include $temp . "footer.php";
} else {
    header("Location: login.php");
    exit;
}
ob_end_flush();
?>