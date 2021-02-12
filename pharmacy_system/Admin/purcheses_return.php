<?php
    ob_start();
    session_start();
    if(isset($_SESSION["id"])) {
        $pageName = "Purcheses Return Bill";
        $setNav = ""; // To Add Navbar To The Page
        include "init.php";
        // Saler Name
        $username = $_SESSION["username"];
        $user_id = $_SESSION["id"];
        // fetch item from db
        $stmt = $con->prepare("SELECT * FROM items");
        $stmt->execute();
        $items = $stmt->fetchAll();

        // get the data
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $bill_no = $_POST["bill-no"];
            $sup_id = $_POST["sups"];
            $item = $_POST["items"];
            $quantity = $_POST["quantity"];
            $price = $_POST["price"];
            $dis = $_POST["discount"];
            $total = $_POST["total"];
            
            // If Submit Data Change Bill No
            $st3 = $con->prepare("UPDATE auto_bill_number SET bill_no = bill_no + 1 WHERE bill_type = 3");
            $st3->execute();

            // Mines qunatity of items of bill quantity
            $stmt2 = $con->prepare('UPDATE items SET count = count - ? WHERE item_id = ?');
            $stmt2->execute(array($quantity, $item));
            $res = $stmt2->rowCount();
            if($res) {
                echo '
                    <div class="alert alert-success">Update Item Count Success</div>
                ';
            } else {
                echo '
                    <div class="alert alert-danger">Update Item Count Falied</div>
                ';
            }

            // Add Total To My Balance

            $stmt3 = $con->prepare("UPDATE my_balance SET pure_balance = pure_balance + ?");
            $stmt3->execute(array($total));
            $res2 = $stmt3->rowCount();
            if($res2) {
                echo '
                    <div class="alert alert-success">Insert To Balance Success</div>
                ';
            } else {
                echo '
                    <div class="alert alert-danger">Insert To Balance Falied</div>
                ';
            }

            // Add bill to DB
            $stmt = $con->prepare("INSERT INTO purchases_bill (`bill_no`, `bill_date`, `quantity`, `pur_price`, `discount`, `net`, `bill_type`, `item_id`, `sup_id`) VALUES (?,now(), ?, ?, ?, ?, 3, ?, ?)");
            $stmt->execute(array(
                $bill_no,
                $quantity,
                $price,
                $dis,
                $total,
                $item,
                $sup_id
            ));
            $result = $stmt->rowCount();
            if($result) {
                echo '
                    <div class="alert alert-success">Insert To Purcheses Bill Return Success</div>
                ';
                header("refresh:2; url=index.php?page-title=items-status");
            } else {
                echo '
                    <div class="alert alert-danger">Insert To Purcheses Bill Return Failed</div>
                ';
                header("refresh:2; url=sales_bill.php");
            }
            // add Bill to Sales & Return Movement
            $stmt4 = $con->prepare("INSERT INTO `sale_return_move`(`date`, `bill_type`, `sup_id`, `client_name`, `total_money`) VALUES (now(), 3, ?, ?, ?)");
            $stmt4->execute(array(
                $sup_id,
                "NULL",
                $total
            ));
            $res3 = $stmt4->rowCount();
            if($res3) {
                echo '
                    <div class="alert alert-success">Insert To Bill Movement Success</div>
                ';
                header("refresh:9; url=index.php?page-title=items-status");
            } else {
                echo '
                    <div class="alert alert-danger">Insert To Bill Movement Failed</div>
                ';
                header("refresh:9; url=sales_bill.php");
            }
        }

?>
<div class="container">
    <h2 class="text-center">Purcheses Return Bill</h2>

    <!-- Bill Form Inputs -->

    <form action="<?php echo $_SERVER["PHP_SELF"] ;?>" method="POST">
        <!-- Bill Define Info -->
        <div class="num">Bill NO : 
            <input type="text" name="bill-no" value="
                <?php 
                    /* Deal With Bill Number */
                    $st = $con->prepare("SELECT * FROM auto_bill_number");
                    $st->execute();
                    $rows = $st->fetchAll();
                    foreach($rows as $row) {
                        if($row["bill_type"] == "3") {
                            if($row["year"] != date("Y")) {
                                $st2 = $con->prepare("UPDATE auto_bill_number SET `year`=? WHERE bill_type = 3");
                                $st2->execute(array(date("Y")));
                                $st3 = $con->prepare("UPDATE auto_bill_number SET bill_no = 0 WHERE bill_type = 3");
                                $st3->execute();
                                $row["bill_no"] = 0;
                            }
                            if($row["bill_no"] == 0) {
                                $row["bill_no"] = 1;
                                echo trim($row["bill_no"]);
                            } else {
                                $row["bill_no"] += 1;
                                echo preg_replace('/\s+/', ' ', $row["bill_no"]);
                            }
                        }
                    }
                ?>
            " readonly>
        </div>
        <div>Date : <?php echo date("Y-m-d") ?></div>
        <input type="text"  name="phone" style="display:none;" value="add_some_phone_number"/>
        <label for="">Suppliers:</label>
        <select name="sups" id="sups">
            <?php
                $fetch = $con->prepare("SELECT * FROM suppliers");
                $fetch->execute();
                $sups = $fetch->fetchAll();
                foreach($sups as $sup) {
                    echo '
                        <option value='. $sup["sup_id"] .'>'. $sup["sup_name"] .'</option>
                    ';
                }
            ?>
        </select>
        <label for="items">Items</label>
        <select name="items" id="items">
            <?php
                foreach($items as $item) {
                    echo '
                        <option value="'. $item["item_id"] .'">'. $item["item_name"] .'</option>
                    ';
                }
            ?>
        </select>
        <label for="quantity">Quantity</label>
        <input type="text" name="quantity" id="quantity" placeholder="Quantity">
        <label for="price">price</label>
        <input type="text" name="price" id="price" placeholder="Price">
        <label for="discount">Discount</label>
        <input type="text" name="discount" id="discount" placeholder="Discount">
        <label for="total">Total</label>
        <input type="text" name="total" id="total" readonly>
        <button class="main-btn add">Add</button>
    </form>
    
    <!-- Sales Table -->
    <!-- <table class="table table-striped bill">
        <th>No</th>
        <th>Item</th>
        <th>Quantity</th>
        <th>Price</th>
        <th>Dicount</th>
        <th>Total</th>
    </table> -->
    <!-- Total Bill Cost -->
    <!-- <form action="">
        <label for="billCost">Total Bill Cost is:</label>
        <input type="text" name="billCost" id="billCost" disabled>
    </form> -->
</div>
<?php
    include $temp . "footer.php";

    } else {
        header("Location: login.php");
        exit;
    }
    ob_end_flush();
?>