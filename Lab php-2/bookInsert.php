
<?php
$message = "";


// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli("localhost", "root", "", "book");


    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }


    // Get input values
    $title = trim($_POST["title"]);
    $author = trim($_POST["author"]);
    $description = trim($_POST["description"]);


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
        $message = "⚠️ All fields are required.";
    }


    $conn->close();
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Book Entry Form</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f5f7fa;
            margin: 0;
            padding: 0;
        }


        .container {
            max-width: 600px;
            margin: 60px auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
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
            margin-top: 6px;
            border: 1px solid #ccc;
            border-radius: 6px;
            resize: none;
            font-size: 16px;
        }


        textarea {
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
            transition: background-color 0.3s;
        }


        input[type="submit"]:hover {
            background-color: #45a049;
        }


        .message {
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
            color: #007BFF;
            padding: 10px;
        }


        .error {
            color: red;
        }


        .success {
            color: green;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>📚 Saim's Book House</h2>


        <?php if (!empty($message)): ?>
            <div id="flash-message" class="message <?php echo (strpos($message, '✅') !== false) ? 'success' : 'error'; ?>">
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


            <input type="submit" value="Submit Book">
        </form>
    </div>


    <!-- ✅ Auto-hide message script -->
    <script>
        const messageDiv = document.getElementById("flash-message");
        if (messageDiv) {
            setTimeout(() => {
                messageDiv.style.display = "none";
            }, 3000); // 3 seconds
        }
    </script>
</body>
</html>