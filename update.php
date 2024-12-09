<?php
include 'database.php';
include 'user.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $matric = $_POST['matric'];
    $name = $_POST['name'];
    $role = $_POST['role'];

    $database = new Database();
    $db = $database->getConnection();

    $user = new User($db);
    $result = $user->updateUser($matric, $name, $role);

    if ($result) {
        echo "<p style='color: green; text-align: center;'>User updated successfully!</p>";
    } else {
        echo "<p style='color: red; text-align: center;'>Failed to update user!</p>";
    }

    $db->close();
} elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
    $matric = $_GET['matric'];

    $database = new Database();
    $db = $database->getConnection();

    $user = new User($db);
    $userDetails = $user->getUser($matric);

    if (!$userDetails) {
        echo "<p style='color: red; text-align: center;'>User not found!</p>";
        exit;
    }

    $db->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 500px;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }
        input[type="text"], select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            width: 100%;
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #218838;
        }
        .back-btn {
            display: inline-block;
            text-decoration: none;
            padding: 10px 15px;
            margin-top: 15px;
            background-color: #007bff;
            color: white;
            border-radius: 5px;
            text-align: center;
            width: 100%;
            box-sizing: border-box;
        }
        .back-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Update User</h2>
        <form action="update.php" method="post">
            <input type="hidden" name="matric" value="<?php echo htmlspecialchars($userDetails['matric']); ?>">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($userDetails['name']); ?>" required>
            <label for="role">Role:</label>
            <select name="role" id="role" required>
                <option value="" disabled>Please select</option>
                <option value="lecturer" <?php echo ($userDetails['role'] == 'lecturer') ? "selected" : ""; ?>>Lecturer</option>
                <option value="student" <?php echo ($userDetails['role'] == 'student') ? "selected" : ""; ?>>Student</option>
            </select>
            <input type="submit" value="Update">
        </form>
        <a href="insert.php" class="back-btn">Back to User List</a>
    </div>
</body>
</html>
<?php
}
?>
