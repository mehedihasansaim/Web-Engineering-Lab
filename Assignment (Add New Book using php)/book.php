<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "book";

// Connect to database
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_book'])) {
    $title = trim($_POST['title']);
    $author = trim($_POST['author']);
    $genre = $_POST['genre'];
    $description = trim($_POST['description']);
    $best_selling = $_POST['best_selling'];

    if ($title && $author && $genre && $description && $best_selling) {
        $stmt = $conn->prepare("INSERT INTO new_books (title, author, genre, description, best_selling) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $title, $author, $genre, $description, $best_selling);

        if ($stmt->execute()) {
            $message = "✅ Book added successfully!";
        } else {
            $message = "❌ Failed to add book: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $message = "⚠️ Please fill in all fields.";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Add Book</title>
    <style>
        body {
            font-family: Arial;
            background: #f2f2f2;
        }

        .container {
            width: 600px;
            margin: 40px auto;
            padding: 30px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
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
        select,
        textarea {
            width: 100%;
            padding: 10px;
            margin-top: 6px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 16px;
        }

        textarea {
            resize: vertical;
            height: 100px;
        }

        .radio-group {
            margin-top: 10px;
        }

        input[type="submit"],
        .view-btn {
            margin-top: 20px;
            padding: 10px;
            font-size: 16px;
            width: 48%;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
        }

        .view-btn {
            background-color: #2196F3;
            color: white;
            float: right;
            text-decoration: none;
            /* ✅ This removes the underline */
            padding: 10px;
            font-size: 16px;
            width: 48%;
            border: none;
            border-radius: 6px;
            text-align: center;
            display: inline-block;
        }


        .message {
            margin-top: 10px;
            text-align: center;
            font-weight: bold;
        }

        .success {
            color: green;
        }

        .error {
            color: red;
        }

        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>📚 Add a New Book</h2>

        <?php if (!empty($message)): ?>
            <div class="message <?php echo strpos($message, '✅') !== false ? 'success' : 'error'; ?>" id="flash-message">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <form method="post" action="">
            <label for="title">Book Title:</label>
            <input type="text" id="title" name="title" required>

            <label for="author">Author Name:</label>
            <input type="text" id="author" name="author" required>

            <label for="genre">Genre:</label>
            <select id="genre" name="genre" required>
                <option value="">-- Select Genre --</option>
                <option value="Fiction">Fiction</option>
                <option value="Nonfiction">Nonfiction</option>
                <option value="Fantasy">Fantasy</option>
                <option value="Biography">Biography</option>
                <option value="Science">Science</option>
                <option value="Others">Others</option>
            </select>

            <label for="description">Description:</label>
            <textarea id="description" name="description" required></textarea>

            <label>Best Selling:</label>
            <div class="radio-group">
                <input type="radio" name="best_selling" value="Yes" required> Yes
                <input type="radio" name="best_selling" value="No" required style="margin-left: 20px;"> No
            </div>

            <div class="clearfix">
                <input type="submit" name="add_book" value="Add Book">
                <a href="view.php" class="view-btn">View All Books</a>
            </div>
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