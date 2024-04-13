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
    function addRecord($pdo,$id, $ingredient, $stock){
        try{
            $stmt = $pdo->prepare("INSERT INTO inventory (name, quantity, price) VALUES (:name, :quantity, :price)");
            $stmt->bindParam(':name', $id);
            $stmt->bindParam(':quantity', $ingredient);
            $stmt->bindParam(':price', $stock);
            $stmt->execute();
            echo "New record added successfully";
        }catch(PDOException $e){
            echo "Error: " . $e->getMessage();
        }
    }
    function editRecord($id,$ingredient, $stock){}
        try{
            $stmt = $pdo->prepare("UPDATE INTO inventory (name, quantity, price) VALUES (:name, :quantity, :price)");
            $stmt->bindParam(':name', $id);
            $stmt->bindParam(':quantity', $ingredient);
            $stmt->bindParam(':price', $stock);
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


    addRecord($pdo,$id,$ingredient,$stock);
    ?>
</body>
</html>