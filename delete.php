<?php
// Include the database and user classes
include 'database.php';
include 'user.php';

// Check if the matric parameter is provided in the URL
if (isset($_GET['matric'])) {
    $matric = $_GET['matric'];

    // Create an instance of the Database class and get the connection
    $database = new Database();
    $db = $database->getConnection();

    // Create an instance of the User class
    $user = new User($db);

    // Call the deleteUser method to delete the user by matric
    $deleteResult = $user->deleteUser($matric);

    // Close the connection
    $db->close();

    // Check if the user was deleted successfully
    if ($deleteResult === true) {
        header("Location: insert.php?message=User deleted successfully");
        exit(); // Ensure no further code is executed
    } else {
        $message = "Error: $deleteResult";
    }
} else {
    $message = "Matric parameter is missing!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete User</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 500px;
            margin: 100px auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h2 {
            color: #333;
        }
        p {
            font-size: 16px;
            color: #555;
        }
        .message {
            margin: 20px 0;
            font-size: 16px;
            color: #ff0000;
        }
        .back-btn {
            text-decoration: none;
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            border-radius: 5px;
            display: inline-block;
            margin-top: 20px;
        }
        .back-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Delete User</h2>
        <?php if (isset($message)) : ?>
            <p class="message"><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>
        <a href="insert.php" class="back-btn">Back to User List</a>
    </div>
</body>
</html>
