<?php 
// Include the database and user classes
include 'database.php';
include 'user.php';

// Create an instance of the Database class and get the connection
$database = new Database();
$db = $database->getConnection();

// Create an instance of the User class
$user = new User($db);

// Register the user using POST data if POST is used
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $createResult = $user->createUser($_POST['matric'], $_POST['name'], $_POST['password'], $_POST['role']);
}

// Fetch all users for display
$sql = "SELECT matric, name, role FROM users";
$result = $db->query($sql);

// Close the database connection (do it at the end)
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 80%;
            margin: 40px auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .action-btns a {
            margin-right: 5px;
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 14px;
            display: inline-block;
        }
        .action-btns a.update {
            background-color: #28a745;
            color: white;
        }
        .action-btns a.update:hover {
            background-color: #218838;
        }
        .action-btns a.delete {
            background-color: #dc3545;
            color: white;
        }
        .action-btns a.delete:hover {
            background-color: #c82333;
        }
        .message {
            text-align: center;
            margin-bottom: 20px;
            font-size: 16px;
        }
        .message.success {
            color: green;
        }
        .message.error {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>User List</h2>
        
        <?php
        if (isset($createResult)) {
            echo "<p class='message " . ($createResult === true ? "success" : "error") . "'>";
            echo $createResult === true ? "User created successfully." : "Error: $createResult";
            echo "</p>";
        }
        ?>
        
        <table>
            <thead>
                <tr>
                    <th>Matric</th>
                    <th>Name</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['matric']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['role']) . "</td>";
                        echo "<td class='action-btns'>";
                        echo "<a href='update.php?matric=" . urlencode($row['matric']) . "' class='update'>Update</a>";
                        echo "<a href='delete.php?matric=" . urlencode($row['matric']) . "' class='delete' onclick='return confirm(\"Are you sure you want to delete this user?\");'>Delete</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No data found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
// Close the database connection
$db->close();
?>
