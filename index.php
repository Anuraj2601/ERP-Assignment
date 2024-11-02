<?php
require_once 'database/dbcon.php';

    if (isset($_POST['add_customer'])) {
        $name = $_POST['customer_name'];
        $email = $_POST['customer_email'];
        $conn->query("INSERT INTO customer (name, email) VALUES ('$name', '$email')");
    }


    if (isset($_POST['add_item'])) {
        $name = $_POST['item_name'];
        $price = $_POST['item_price'];
        $conn->query("INSERT INTO item (name, price) VALUES ('$name', '$price')");
    }


    if (isset($_GET['delete_customer'])) {
        $id = $_GET['delete_customer'];
        $conn->query("DELETE FROM customer WHERE id=$id");
    }


    if (isset($_GET['delete_item'])) {
        $id = $_GET['delete_item'];
        $conn->query("DELETE FROM item WHERE id=$id");
    }


    $customers = $conn->query("SELECT * FROM customer");
    $items = $conn->query("SELECT * FROM item");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>ERP Application</title>
    <style>
       body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            background-image: url('assets/bg.jpg'); 
            background-size: cover;
            background-position: center;
            color: white;
            overflow: hidden;
        }
        .button-container {
            text-align: center;
            background-color: rgba(0, 0, 0, 0.5);
            padding: 20px;
            border-radius: 10px;
        }
        .button-container button {
            margin: 10px;
            width: 150px;
            font-size: 18px;
        }
    </style>
</head>
<body>
    <div class="button-container">
        <h1>Welcome to ERP Application</h1>
        <button class="btn btn-primary" onclick="window.location.href='customers/index.php'">Customers</button>
        <button class="btn btn-success" onclick="window.location.href='items/index.php'">Items</button>
        <button class="btn btn-warning" onclick="window.location.href='reports/index.php'">Reports</button>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

