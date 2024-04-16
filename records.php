<?php
$host = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "coffeeshop";

try {
    $connection = new PDO("mysql:host=$host;dbname=$dbname", $dbusername, $dbpassword);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add'])) {
        $id = $_POST['id'];
        $ingredient = $_POST['ingredient'];
        $totalInventory = $_POST['totalInventory'];
        $spoilageNumber = $_POST['spoilageNumber'];
        $restockNumber = $_POST['restockNumber'];
        addRecord($connection, $id, $ingredient, $totalInventory, $spoilageNumber, $restockNumber);
    } elseif (isset($_POST['modify'])) {
        $id = $_POST['id_to_update'];
        $ingredient = $_POST['new_ingredient'];
        $totalInventory = $_POST['new_totalInventory'];
        $spoilageNumber = $_POST['new_spoilageNumber'];
        $restockNumber = $_POST['new_restockNumber'];
        modifyRecord($connection, $id, $ingredient, $totalInventory, $spoilageNumber, $restockNumber);

    } elseif (isset($_POST['delete'])) {
        // Check if delete_id is set
        if (isset($_POST['delete_id'])) {

            // Delete record with delete_id
            $id_to_delete = $_POST['delete_id'];
            deleteRecord($connection, $id_to_delete);
        } else {
            echo "Please provide an ID to delete.";
        }
    }
}

function addRecord($pdo, $id, $ingredient, $totalInventory, $spoilageNumber, $restockNumber) {
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
            $stmtInsert = $pdo->prepare("INSERT INTO inventory (id, ingredient, totalInventory, spoilageNumber, restockNumber) VALUES (:id, :ingredient, :totalInventory, :spoilageNumber, :restockNumber)");
            $stmtInsert->bindParam(':id', $id);
            $stmtInsert->bindParam(':ingredient', $ingredient);
            $stmtInsert->bindParam(':totalInventory', $totalInventory);
            $stmtInsert->bindParam(':spoilageNumber', $spoilageNumber);
            $stmtInsert->bindParam(':restockNumber', $restockNumber);
            $stmtInsert->execute();
            echo "Record added successfully";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    header("Location: index.php"); //after being called, the webpage will be set to return to index.php
    exit; //will exit this file so that it won't continue running
}

function modifyRecord($pdo, $id, $ingredient, $totalInventory, $spoilageNumber, $restockNumber) {
    try {
        $stmt = $pdo->prepare("UPDATE inventory SET ingredient = :ingredient, totalInventory = :totalInventory, spoilageNumber = :spoilageNumber, restockNumber = :restockNumber WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':ingredient', $ingredient);
        $stmt->bindParam(':totalInventory', $totalInventory);
        $stmt->bindParam(':spoilageNumber', $spoilageNumber);
        $stmt->bindParam(':restockNumber', $restockNumber);
        $stmt->execute();
        echo "Record modified successfully";
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    header("Location: index.php"); //after being called, the webpage will be set to return to index.php
    exit;                           //will exit this file so that it wont continue running
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
    header("Location: index.php");  //after being called, the webpage will be set to return to index.php
    exit;                           //will exit this file so that it wont continue running
}
?>
