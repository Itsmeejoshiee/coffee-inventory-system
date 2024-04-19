<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono&family=Press+Start+2P&family=Roboto&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Inventory Management Form</title>
</head>
<body>
    
<div>
    <!-- Tab buttons -->
    <button class="tab" onclick="openTab(event, 'add')">Add</button>
    <button class="tab" onclick="openTab(event, 'modify')">Modify</button>
    <button class="tab" onclick="openTab(event, 'delete')">Delete</button>
</div>

    <!-- Form for adding a record -->
<div id="add" class="tabContent"> 
    <form method="post" action="records.php">
        <h2 class="font">Add Record</h2>
        <label for="id">Ingredient ID:</label>
        <input type="text" id="id" name="id" required>

        <label for="ingredient">Ingredient Name:</label>
        <input type="text" id="ingredient" name="ingredient" required>

        <label for="stocks">Stocks:</label>
        <input type="number" id="totalInventory" name="totalInventory" required>

        <label for="spoilage_number">Spoilage Threshold:</label>
        <input type="number" id="spoilageNumber" name="spoilageNumber" required>

        <label for="restock_number">Restock Threshold:</label>
        <input type="number" id="restockNumber" name="restockNumber" required>

        <button class="button" type="submit" name="add">Add Record</button>
    </form>
</div>
    <!-- Form for modifying a record -->
<div id="modify" class="tabContent"> 
    <form method="post" action="records.php">
        <h2 class="font">Modify Record</h2>
        <label for="id_to_update">Enter ID to Update:</label>
        <input type="text" id="id_to_update" name="id_to_update">

        <!-- Input fields for modifying other attributes -->
        <label for="new_ingredient">New Ingredient Name:</label>
        <input type="text" id="new_ingredient" name="new_ingredient">

        <label for="new_totalInventory">New Stocks:</label>
        <input type="number" id="new_totalInventory" name="new_totalInventory">

        <label for="new_spoilageNumber">New Spoilage Threshold:</label>
        <input type="number" id="new_spoilageNumber" name="new_spoilageNumber">

        <label for="new_restockNumber">New Restock Threshold:</label>
        <input type="number" id="new_restockNumber" name="new_restockNumber">

        <button class="button" type="submit" name="modify">Modify Record</button>
    </form>
</div>


    <!-- Form for deleting a record -->
<div id="delete" class="tabContent">
    <form method="post" action="records.php" onsubmit="return confirm('Are you sure you want to delete this record?');">
        <h2 class="font">Delete Record</h2>
        <label for="delete_id">Ingredient ID:</label>
        <input type="text" id="delete_id" name="delete_id" required>
        <button class="button" type="submit" name="delete">Delete Record</button>
    </form>
</div>

    <div class = "bgTable">
        <h2 class = "font">Inventory</h2>
     <div class = "scroll">
        <div class = "bgTable1">
                <table>
                <tr>
                    <th>ID</th>
                    <th>Ingredient</th>
                    <th>Stocks</th>
                    <th>Expiration</th>
                    <th>Restock</th>
                </tr>
                <?php
                $host = "localhost";                                                         # initialize host, username, password and database name
                $dbusername = "root";
                $dbpassword = "";
                $dbname = "coffeeshop";

                try{
                    $connection = mysqli_connect($host, $dbusername, $dbpassword, $dbname);  # connect to MYSQL XAMPP database
                } catch(mysqli_sql_exception){                                               # handle exception of connection failed
                    echo "failed to connect to the coffeeshop database.";
                }
                $sqlSum = "SELECT SUM(totalInventory) AS total FROM inventory";           # select query to fetch sum of all stocks, alias = total
                $resultSum = $connection->query($sqlSum);                                 # calls query to execute sql query inside $sqlSum, store results in result 2
                $row = $resultSum->fetch_assoc();                                         # fetches data from a row from mysql
                $totalInventory = $row['total'];                                          # has access to alias total fromthe sql query, results are stored in total inventory.
                echo "Total Inventory: " . $totalInventory;

                $sqlQuery = "SELECT *  from inventory" ;
                $result = $connection-> query($sqlQuery);
                if ($result->num_rows > 0) {
                    while ($rows = $result->fetch_assoc()) {
                        echo "<tr><td>".$rows["id"]."</td><td>".$rows["ingredient"]."</td><td>".$rows["totalInventory"]."</td><td>".$rows["spoilageNumber"]."</td><td>".$rows["restockNumber"]."</td></tr>";
                    }
                } else {
                    echo "0 results";
                }
    
                ?>
            </table>
            </div>
        </div>
    </div>
</div>
<script>
    // Function to open a tab
    function openTab(evt, tabName) {
        var i, tabcontent, tablinks;
        // Hide all tab contents
        tabcontent = document.getElementsByClassName("tabContent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        // Remove "active" class from all tab buttons
        tablinks = document.getElementsByClassName("tab");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        // Show the clicked tab content and set it as active
        document.getElementById(tabName).style.display = "block";
        evt.currentTarget.className += " active";
    }
    // Open the default tab
    document.querySelector('.tab').click();
</script>
</body>
</html>