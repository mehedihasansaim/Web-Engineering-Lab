
<?php
include 'connect.php'; // Make sure this file defines $conn


$message = "";


// Form submitted
if (isset($_POST['submit'])) {
    $title = trim($_POST['title']);
    $author = trim($_POST['author']);
    $description = trim($_POST['description']);


    if (!empty($title) && !empty($author) && !empty($description)) {
        $stmt = $conn->prepare("INSERT INTO new_books (title, author, description) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $title, $author, $description);


        if ($stmt->execute()) {
            $message = "✅ Book added successfully!";
        } else {
            $message = "❌ Error: " . $stmt->error;
        }


        $stmt->close();
    } else {
        $message = "⚠️ All fields are required!";
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Saim's Book House</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f7fa;
            margin: 0;
            padding: 0;
        }


        .container {
            max-width: 600px;
            background: #fff;
            margin: 60px auto;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }


        h2 {
            text-align: center;
            color: #333;
        }


        label {
            font-weight: bold;
            display: block;
            margin-top: 15px;
        }


        input[type="text"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 15px;
        }


        textarea {
            resize: none;
            height: 120px;
        }


        input[type="submit"] {
            margin-top: 20px;
            width: 100%;
            background-color: #4CAF50;
            color: white;
            padding: 12px;
            font-size: 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }


        input[type="submit"]:hover {
            background-color: #45a049;
        }


        .message {
            margin-top: 10px;
            text-align: center;
            padding: 10px;
            font-weight: bold;
        }


        .success {
            color: green;
        }


        .error {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>📚 Saim's Book House</h2>


        <?php if (!empty($message)): ?>
            <div id="flash-message" class="message <?php echo strpos($message, '✅') !== false ? 'success' : 'error'; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>


        <form method="post" action="">
            <label for="title">Book Title:</label>
            <input type="text" id="title" name="title" placeholder="Enter book title" required>


            <label for="author">Author Name:</label>
            <input type="text" id="author" name="author" placeholder="Enter author name" required>


            <label for="description">Description:</label>
            <textarea id="description" name="description" placeholder="Write a short description..." required></textarea>


            <input type="submit" name="submit" value="Submit Book">
        </form>
    </div>


    <script>
        const messageDiv = document.getElementById("flash-message");
        if (messageDiv) {
            setTimeout(() => {
                messageDiv.style.display = "none";
            }, 3000);
        }
    </script>
</body>
</html>
