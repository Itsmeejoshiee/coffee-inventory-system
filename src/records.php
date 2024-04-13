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
    /* 
    id: A unique identifier for each ingredient.
    ingredient: Name of the ingredient.
    totalInventory: Quantity of the ingredient currently in stock.
    spoilageNumber: The threshold quantity at which the ingredient is considered spoiled and needs to be discarded.
    restockNumber: The threshold quantity at which a notification is triggered to restock the ingredient.
    */    


    if($_SERVER["REQUEST_METHOD"] == "POST") {
        if(isset($_POST['add'])) {
            echo"hello";
            $id = $_POST['id'];
            $ingredient = $_POST['ingredient'];
            $totalInventory = $_POST['totalInventory'];
            $spoilageNumber = $_POST['spoilageNumber'];
            $restockNumber = $_POST['restockNumber'];
            addRecord($connection, $id, $ingredient, $totalInventory, $spoilageNumber, $restockNumber);
        } elseif(isset($_POST['modify'])) {
            $id = $_POST['id'];
            $ingredient = $_POST['ingredient'];
            $totalInventory = $_POST['totalInventory'];
            $spoilageNumber = $_POST['spoilageNumber'];
            $restockNumber = $_POST['restockNumber'];
            modifyRecord($connection, $id, $ingredient, $totalInventory, $spoilageNumber, $restockNumber);
        } elseif(isset($_POST['delete'])) {
            $id = $_POST['id'];
            deleteRecord($connection, $id);
        }
    }

    function addRecord($pdo, $id, $ingredient, $totalInventory, $spoilageNumber, $restockNumber) {
        try{
            $stmt = $pdo->prepare("INSERT INTO inventory (id, ingredient, totalInventory, spoilageNumber, restockNumber) VALUES (:id, :ingredient, :totalInventory, :spoilageNumber, :restockNumber)");
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':ingredient', $ingredient);
            $stmt->bindParam(':totalInventory', $totalInventory);
            $stmt->bindParam(':spoilageNumber', $spoilageNumber);
            $stmt->bindParam(':restockNumber', $restockNumber);
            $stmt->execute();
            echo "New record added successfully";
        } catch( PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    
    }
    function modifyRecord($pdo,$id, $ingredient, $totalInventory,$spoilageNumber,$restockNumber) {
        try {
            $stmt = $pdo->prepare("INSERT INTO inventory (customer_id, ingredient_name, stocks, spoilage_number, restock_number) VALUES (:customer_id, :ingredient_name, :stocks, :spoilage_number, :restock_number)");
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':ingredient', $ingredient);
            $stmt->bindParam(':totalInventory', $totalInventory);
            $stmt->bindParam(':spoilageNumber', $spoilageNumber);
            $stmt->bindParam(':restockNumber', $restockNumber);
            $stmt->execute();
            echo "New record added successfully";
            
        }catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    function deleteRecord($pdo,$id) {
        try{
            $stmt = $pdo->prepare("DELETE FROM inventory WHERE id=:id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            echo "Record deleted successfully";
        }catch(PDOException $e){
            echo "Error: " . $e->getMessage();
        }
    }
?>



