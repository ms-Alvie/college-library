<?php 
session_start();
include '../config/db.php'; 

// Ensure the user is logged in as a student
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    header("Location: ../auth/login.php");
    exit();
}

$username = $_SESSION['username'];
$user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Borrowed Books</title>
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Crimson Text', serif;
            background: url('../assets/bg.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #3e2c23;
            display: flex;
            height: 100vh;
            margin: 0;
        }

        /* Hamburger Menu */
        .hamburger-menu button {
            display: none;
            position: fixed;
            top: 10px;
            left: 10px;
            z-index: 1000;
            background: #8b5e3c;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 24px;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background: rgba(255, 248, 238, 0.98);
            backdrop-filter: blur(6px);
            padding: 40px 20px;
            box-shadow: 2px 0 15px rgba(0, 0, 0, 0.15);
            display: flex;
            flex-direction: column;
            gap: 20px;
            border-right: 2px solid #d4c2b4;
        }

        .sidebar h1 {
            font-size: 24px;
            margin-bottom: 30px;
            color: #5a3e2b;
            text-align: center; /* Center-align heading */
        }

        .sidebar a {
            background-color: #8b5e3c;
            color: #fff8f0;
            padding: 12px; /* Consistent padding */
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s ease, transform 0.2s ease;
            text-align: center; /* Center-align text */
            font-size: 16px; /* Adjust font size for better readability */
        }

        .sidebar a:hover {
            background-color: #70422d;
            transform: translateX(5px);
        }

        /* Main Content */
        .main-content {
            flex: 1;
            padding: 40px;
            display: flex;
            justify-content: center;
            align-items: flex-start;
        }

        .table-container {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(8px);
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 1000px;
            overflow-x: auto;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #5a3e2b;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 18px;
        }

        th, td {
            border: 1px solid #c5b7a5;
            padding: 12px;
            text-align: center;
        }

        th {
            background-color: #8b5e3c;
            color: #fff8f0;
        }

        tr:nth-child(even) {
            background-color: #f7f1eb;
        }

        tr:hover {
            background-color: #f0e6dc;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .hamburger-menu button {
                display: block;
            }

            .sidebar {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(255, 248, 238, 0.98);
                z-index: 999;
                flex-direction: column;
                justify-content: center;
                align-items: center;
            }

            .sidebar.active {
                display: flex;
            }

            .sidebar h1 {
                display: none; /* Hide heading on small screens */
            }

            .sidebar a {
                flex: 1;
                margin: 0 8px; /* Consistent spacing between links */
                font-size: 14px; /* Reduce font size for smaller screens */
                padding: 10px; /* Slightly reduce padding for compactness */
                text-align: center; /* Center-align text */
            }

            .main-content {
                padding: 20px;
            }

            .table-container {
                padding: 20px; /* Reduce padding for smaller screens */
            }
        }
    </style>
</head>
<body>

    <!-- Hamburger Menu -->
    <div class="hamburger-menu">
        <button id="menu-toggle">☰</button>
    </div>

    <!-- Sidebar -->
    <div id="sidebar" class="sidebar">
        <h1>Student</h1>
        <a href="dashboard.php">🏠 Dashboard</a>
        <a href="my_books.php">📚 My Books</a>
        <a href="../auth/logout.php">🚪 Logout</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="table-container">
            <h2>My Borrowed Books</h2>
            <table>
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Due Date</th>
                    <th>Status</th>
                    <th>Fine</th>
                </tr>
                <?php
                $query = "SELECT b.title, b.author, i.due_date, i.return_date, i.fine
                          FROM issued_books i
                          JOIN books b ON i.book_id = b.id
                          WHERE i.user_id = $user_id";

                $res = $conn->query($query);

                if (!$res) {
                    echo "<tr><td colspan='5'>Error: " . $conn->error . "</td></tr>";
                } elseif ($res->num_rows === 0) {
                    echo "<tr><td colspan='5' style='text-align: center;'>No borrowed books found.</td></tr>";
                } else {
                    while ($row = $res->fetch_assoc()) {
                        $status = $row['return_date'] ? "Returned" : "Pending";
                        echo "<tr>
                            <td>{$row['title']}</td>
                            <td>{$row['author']}</td>
                            <td>{$row['due_date']}</td>
                            <td>{$status}</td>
                            <td>{$row['fine']}</td>
                        </tr>";
                    }
                }
                ?>
            </table>
        </div>
    </div>

    <script>
        // Toggle Sidebar
        document.getElementById('menu-toggle').addEventListener('click', function () {
            document.getElementById('sidebar').classList.toggle('active');
        });
    </script>

</body>
</html>