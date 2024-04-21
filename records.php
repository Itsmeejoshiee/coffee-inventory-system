<?php
class records {
    private $host;
    private $username;
    private $password;
    private $dbname;
    protected $pdo;

    public function __construct($host, $username, $password, $dbname) {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->dbname = $dbname;

        try {
            $this->pdo = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->username, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function getPdo() {
        return $this->pdo;
    }
}

class RecordManager extends records {
    public function __construct($host, $username, $password, $dbname) {
        parent::__construct($host, $username, $password, $dbname);
    }

    public function addRecord($id, $ingredient, $totalInventory, $expirationDate, $restockNumber) {
        try {
            // Check if the id or ingredient already exists
            $stmtIdCheck = $this->pdo->prepare("SELECT * FROM inventory WHERE id = :id");
            $stmtIdCheck->bindParam(':id', $id);
            $stmtIdCheck->execute();
            $stmtIngredientCheck = $this->pdo->prepare("SELECT * FROM inventory WHERE ingredient = :ingredient");
            $stmtIngredientCheck->bindParam(':ingredient', $ingredient);
            $stmtIngredientCheck->execute();

            if ($stmtIdCheck->rowCount() > 0) {
                echo "Error: ID already exists.";
            } elseif ($stmtIngredientCheck->rowCount() > 0) {
                echo "Error: Ingredient already exists.";
            } else {
                // Insert new record
                $stmtInsert = $this->pdo->prepare("INSERT INTO inventory (id, ingredient, totalInventory, expirationDate , restockNumber) VALUES (:id, :ingredient, :totalInventory, :expirationDate, :restockNumber)");
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
        header("Location: index.php");
        exit;
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
        header("Location: index.php");
        exit;
    }

    function restockRecord ($pdo, $id, $totalInventory, $restockNumber){
        try {
            $restockNumber += 1; // increment stock record by 1
            $stmt = $pdo->prepare("UPDATE inventory SET totalInventory = totalInventory + :totalInventory, restockNumber = restockNumber + :restockNumber WHERE id = :id"); // apply addition in query
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':totalInventory', $totalInventory);
            $stmt->bindParam(':restockNumber', $restockNumber);
            $stmt->execute();
            echo "Record restocked successfully";
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        header("Location: index.php");
        exit;
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
        header("Location: index.php");
        exit;
    }
}

// Usage
$host = "localhost";
$username = "root";
$password = "";
$dbname = "coffeeshop";

$recordManager = new RecordManager($host, $username, $password, $dbname);

?>
