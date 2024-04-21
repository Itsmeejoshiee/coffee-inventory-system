    <?php
    $host = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "coffeeshop";
    /*
        guide:
        prepare()  - used to compile the string used for the mysql query
        bindParam() - holds and binds tha values to the sql query inside "prepare()"
    */

    try {
        $connection = new PDO("mysql:host=$host;dbname=$dbname", $dbusername, $dbpassword);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {                                                         // acquire form from html, check if = "post"
        if (isset($_POST['add'])) {
            $id = $_POST['id'];
            $ingredient = $_POST['ingredient'];
            $totalInventory = $_POST['totalInventory'];
            $expirationDate = date('Y-m-d', strtotime($_POST['expirationDate']));                       // convert date input from html to follow year month date format of mysql (use string to time function)
            $restockNumber = $_POST['restockNumber'];
            addRecord($connection, $id, $ingredient, $totalInventory, $expirationDate, $restockNumber); // function call
        } elseif (isset($_POST['modify'])) {
            $id = $_POST['id_to_update'];
            $ingredient = $_POST['new_ingredient'];
            $totalInventory = $_POST['new_totalInventory'];
            $expirationDate = date('Y-m-d', strtotime($_POST['expirationDate']));
            $restockNumber = $_POST['new_restockNumber'];
            modifyRecord($connection, $id, $ingredient, $totalInventory, $expirationDate, $restockNumber); // function call

        } elseif (isset($_POST['restock'])) {
            $id = $_POST['id'];
            $restockAmount = $_POST['restocked_totalInventory'];
            $restockNumber = $_POST['restockNumber'];
            restockRecord($connection, $id, $restockAmount, $restockNumber);                               // function call
            

        } elseif (isset($_POST['delete'])) {
            // Check if delete_id is set
            if (isset($_POST['delete_id'])) {

                // Delete record with delete_id
                $id_to_delete = $_POST['delete_id'];
                deleteRecord($connection, $id_to_delete);                                                   // function call
            } else {
                echo "Please provide an ID to delete.";
            }
        }
    }


    function restockRecord ($pdo, $id, $totalInventory, $restockNumber){
        try {
            $restockNumber += 1;                                                                                                                                                // increment stock record by 1
            $stmt = $pdo->prepare("UPDATE inventory SET totalInventory = totalInventory + :totalInventory, restockNumber = restockNumber + :restockNumber WHERE id = :id");     // apply addition in query
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':totalInventory', $totalInventory);
            $stmt->bindParam(':restockNumber', $restockNumber);
            $stmt->execute();
            echo "Record restocked successfully";
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        header("Location: front 1.php"); //after being called, the webpage will be set to return to index.php
        exit;                           //will exit this file so that it wont continue running
    }


    function addRecord($pdo, $id, $ingredient, $totalInventory, $expirationDate, $restockNumber) {
        try {
            // Check if the id or ingredient already exists
            $stmtIdCheck = $pdo->prepare("SELECT * FROM inventory WHERE id = :id");
            $stmtIdCheck->bindParam(':id', $id);
            $stmtIdCheck->execute();
            $stmtIngredientCheck = $pdo->prepare("SELECT * FROM inventory WHERE ingredient = :ingredient");
            $stmtIngredientCheck->bindParam(':ingredient', $ingredient);
            $stmtIngredientCheck->execute();

            if ($stmtIdCheck->rowCount() > 0) {
                echo "Error: ID already exists.";
            } elseif ($stmtIngredientCheck->rowCount() > 0) {
                echo "Error: Ingredient already exists.";
            } else {
                // Insert new record
                $stmtInsert = $pdo->prepare("INSERT INTO inventory (id, ingredient, totalInventory, expirationDate , restockNumber) VALUES (:id, :ingredient, :totalInventory, :expirationDate, :restockNumber)");
                $stmtInsert->bindParam(':id', $id);
                $stmtInsert->bindParam(':ingredient', $ingredient);
                $stmtInsert->bindParam(':totalInventory', $totalInventory);
                $stmtInsert->bindParam(':expirationDate', $expirationDate);
                $stmtInsert->bindParam(':restockNumber', $restockNumber);
                $stmtInsert->execute();
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        header("Location: front 1.php"); //after being called, the webpage will be set to return to index.php
        exit;                            //will exit this file so that it won't continue running
    }

    function modifyRecord($pdo, $id, $ingredient, $totalInventory, $expirationDate, $restockNumber) {
        try {
            $stmt = $pdo->prepare("UPDATE inventory SET ingredient = :ingredient, totalInventory = :totalInventory, expirationDate = :expirationDate, restockNumber = :restockNumber WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':ingredient', $ingredient);
            $stmt->bindParam(':totalInventory', $totalInventory);
            $stmt->bindParam(':expirationDate', $expirationDate);
            $stmt->bindParam(':restockNumber', $restockNumber);
            $stmt->execute();
            echo "Record modified successfully";
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        header("Location: front 1.php");; //after being called, the webpage will be set to return to index.php
        exit;                             //will exit this file so that it wont continue running
    }

    function deleteRecord($pdo, $id) {
        try {
            $stmt = $pdo->prepare("DELETE FROM inventory WHERE id=:id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            echo "Record deleted successfully";
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        header("Location: front 1.php");;  //after being called, the webpage will be set to return to index.php
        exit;                              //will exit this file so that it wont continue running
    }
    ?>
