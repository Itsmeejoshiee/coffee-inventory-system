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
    function addRecord($pdo,$id, $ingredient, $totalInventory,$spoilageNumber,$restockNumber) {
        global $pdo;
        $customer_id = $_POST['customer_id'];
        $ingredient_name = $_POST['ingredient_name'];
        $stocks = $_POST['stocks'];
        $spoilage_number = $_POST['spoilage_number'];
        $restock_number = $_POST['restock_number'];
    
        try {
            $stmt = $pdo->prepare("INSERT INTO inventory (customer_id, ingredient_name, stocks, spoilage_number, restock_number) VALUES (:customer_id, :ingredient_name, :stocks, :spoilage_number, :restock_number)");
            $stmt->bindParam(':customer_id', $customer_id);
            $stmt->bindParam(':ingredient_name', $ingredient_name);
            $stmt->bindParam(':stocks', $stocks);
            $stmt->bindParam(':spoilage_number', $spoilage_number);
            $stmt->bindParam(':restock_number', $restock_number);
            $stmt->execute();
            echo "New record added successfully";
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    
    function modifyRecord($pdo,$id, $ingredient, $totalInventory,$spoilageNumber,$restockNumber) {
        global $pdo;
        $customer_id = $_POST['customer_id'];
        $ingredient_name = $_POST['ingredient_name'];
        $stocks = $_POST['stocks'];
        $spoilage_number = $_POST['spoilage_number'];
        $restock_number = $_POST['restock_number'];
        try {
            $stmt = $pdo->prepare("INSERT INTO inventory (customer_id, ingredient_name, stocks, spoilage_number, restock_number) VALUES (:customer_id, :ingredient_name, :stocks, :spoilage_number, :restock_number)");
            $stmt->bindParam(':customer_id', $customer_id);
            $stmt->bindParam(':ingredient_name', $ingredient_name);
            $stmt->bindParam(':stocks', $stocks);
            $stmt->bindParam(':spoilage_number', $spoilage_number);
            $stmt->bindParam(':restock_number', $restock_number);
            $stmt->execute();
            echo "New record added successfully";
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    
    function deleteRecord($id) {
        global $pdo;
        try{
            $stmt = $pdo->prepare("DELETE FROM inventory WHERE id=:id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            echo "Record deleted successfully";
        }catch(PDOException $e){
            echo "Error: " . $e->getMessage();
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['action'])) {
            $action = $_POST['action'];
    
            switch ($action) {
                case 'add':
                    addRecord($pdo,$id, $ingredient, $totalInventory,$spoilageNumber,$restockNumber);
                    break;
                case 'modify':
                    modifyRecord($pdo,$id, $ingredient, $totalInventory,$spoilageNumber,$restockNumber);
                    break;
                case 'delete':
                    deleteRecord($id);
                    break;
                default:
                    echo "Invalid action";
                    break;
            }
        } else {
            echo "No action specified";
        }
    }
    
    ?>
</body>
</html>


