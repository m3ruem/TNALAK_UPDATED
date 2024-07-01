<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JUDGING SHEET</title>
    <link rel="stylesheet" href="/float/css/float.css">
    <style>
        .top10 {
            background-color: blue;
            color: white;
        }

        .judge-signatures {
            display: flex;
            justify-content: space-between;
            margin-top: 50px;
        }

        .judge-signature {
            text-align: center;
            width: 45%;
        }

        .judge-signature .line {
            border-bottom: 1px solid black;
            margin-bottom: 5px;
        }
    </style>
</head>

<body>
    <div class="tnalaklogo">
        <img src="../tnalak.png" alt="t'nalak image">
    </div>
    <div class="emblem">
        <img src="../emblem.png" alt="t'nalak image">
    </div>

    <div class="container">
        <?php
        // Retrieve judge name from query string
        $judge = isset($_GET['judge']) ? htmlspecialchars($_GET['judge']) : '';

        // Display judge's scores or perform necessary operations
        
        echo "<h2>Score Sheet of Judge $judge </h2>";
        
        // Include database connection
        require('../db/db_festiveconn.php');

        // Prepare the SQL query to fetch scores for the selected judge
        $query = "SELECT entry_num, festive_spirit_of_parade, costume_and_props, relevance_to_theme FROM scores WHERE judge_name = ?";

        $stmt = $conn->prepare($query);

        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($conn->error));
        }
        $stmt->bind_param("s", $judge);
        $stmt->execute();
        $stmt->bind_result($entry_num, $festive_spirit_of_parade, $costume_and_props, $relevance_to_theme);

        echo "<table>";
        echo "<thead><tr><th>Entry No.</th><th>Festive Spirit of Parade</th><th>Costume and Props</th><th>Relevance to Theme</th><th>Total</th></tr></thead>";
        echo "<tbody>";

    
        // Display each contestant's scores
        while ($stmt->fetch()) {
            $total_score = $festive_spirit_of_parade + $costume_and_props + $relevance_to_theme;
            echo "<tr>";
            echo "<td>" . htmlspecialchars($entry_num) . "</td>";
            echo "<td>" . htmlspecialchars($festive_spirit_of_parade) . "</td>";
            echo "<td>" . htmlspecialchars($costume_and_props) . "</td>";
            echo "<td>" . htmlspecialchars($relevance_to_theme) . "</td>";
            echo "<td>" . htmlspecialchars($total_score) . "</td>";
            echo "</tr>";
            
        }
        echo "</tbody></table>";
        // Close statement and connection
        $stmt->close();
        $conn->close();
        ?>
    </div>
</body>

</html>