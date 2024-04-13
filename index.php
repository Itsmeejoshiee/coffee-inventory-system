<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php   
    require 'db_connection.php';

    /* 
    id: A unique identifier for each ingredient.
    ingredient: Name of the ingredient.
    totalInventory: Quantity of the ingredient currently in stock.
    spoilageNumber: The threshold quantity at which the ingredient is considered spoiled and needs to be discarded.
    restockNumber: The threshold quantity at which a notification is triggered to restock the ingredient.
    */
    function addRecord($pdo,$id, $ingredient, $totalInventory,$spoilageNumber,$restockNumber){
        try{
            $stmt = $pdo->prepare("INSERT INTO inventory (id, ingredient, totalInventory, spoilageNumber, restockNumber) VALUES (:id, :ingredient, :totalInventory, :spoilageNumber, :restockNumber)");
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':ingredient', $ingredient);
            $stmt->bindParam(':totalInventory', $totalInventory);
            $stmt->bindParam(':spoilageNumber', $spoilageNumber);
            $stmt->bindParam(':restockNumber', $restockNumber);
            $stmt->execute();
            echo "New record added successfully";
        }catch(PDOException $e){
            echo "Error: " . $e->getMessage();
        }
    }
    function editRecord($id, $ingredient, $totalInventory,$spoilageNumber,$restockNumber){}
        try{
            $stmt = $pdo->prepare("UPDATE INTO inventory (id, ingredient, totalInventory, spoilageNumber, restockNumber) VALUES (:id, :ingredient, :totalInventory, :spoilageNumber, :restockNumber)");
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':ingredient', $ingredient);
            $stmt->bindParam(':totalInventory', $totalInventory);
            $stmt->bindParam(':spoilageNumber', $spoilageNumber);
            $stmt->bindParam(':restockNumber', $restockNumber);
            $stmt->execute();
            echo "Record updated Successfully";
        }catch(PDOException $e){
            echo "Error: " . $e->getMessage();
        }
    function deleteRecord($id){}
        try{
            $stmt = $conn->prepare("DELETE FROM inventory WHERE id=:id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            echo "Record deleted successfully";
        }catch(PDOException $e){
            echo "Error: " . $e->getMessage();
        }

    ?>
</body>
</html>