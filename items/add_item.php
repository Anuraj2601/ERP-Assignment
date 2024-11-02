<?php
    require_once '../database/dbcon.php';


    $itemCode = $itemName = $category = $subcategory = $quantity = $unitPrice = '';
    $message = '';


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $itemCode = $_POST['itemCode'];
        $itemName = $_POST['itemName'];
        $category = $_POST['category'];
        $subcategory = $_POST['subcategory'];
        $quantity = $_POST['quantity'];
        $unitPrice = $_POST['unitPrice'];

        
        $stmt = $conn->prepare("INSERT INTO item (item_code, item_name, item_category, item_subcategory, quantity, unit_price) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssii", $itemCode, $itemName, $category, $subcategory, $quantity, $unitPrice);

        if ($stmt->execute()) {
            $message = "Item has been added successfully.";
        } else {
            $message = "Error: " . $stmt->error;
        }

        $stmt->close();
    }


    $categories = $conn->query("SELECT id, category FROM item_category");
    $subcategories = $conn->query("SELECT id, sub_category FROM item_subcategory");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Item</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .form-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
<div class="form-container">
    <h2 class="text-center">Add Item</h2>
    <a href="index.php" class="btn btn-secondary mb-3">Back to Item List</a>
    <?php if ($message): ?>
        <div class="alert alert-info" role="alert"><?php echo $message; ?></div>
    <?php endif; ?>
    <form method="POST" class="needs-validation" novalidate>
        <div class="form-group">
            <label for="itemCode">Item Code</label>
            <input type="text" class="form-control" id="itemCode" name="itemCode" value="<?php echo $itemCode; ?>" required>
            <div class="invalid-feedback">Please enter the item code.</div>
        </div>
        <div class="form-group">
            <label for="itemName">Item Name</label>
            <input type="text" class="form-control" id="itemName" name="itemName" value="<?php echo $itemName; ?>" required>
            <div class="invalid-feedback">Please enter the item name.</div>
        </div>
        <div class="form-group">
            <label for="category">Category</label>
            <select class="form-control" id="category" name="category" required>
                <option value="">Select Category</option>
                <?php while ($cat = $categories->fetch_assoc()): ?>
                    <option value="<?php echo $cat['id']; ?>" <?php echo ($category == $cat['id']) ? 'selected' : ''; ?>><?php echo $cat['category']; ?></option>
                <?php endwhile; ?>
            </select>
            <div class="invalid-feedback">Please select a category.</div>
        </div>
        <div class="form-group">
            <label for="subcategory">Subcategory</label>
            <select class="form-control" id="subcategory" name="subcategory" required>
                <option value="">Select Subcategory</option>
                <?php while ($subcat = $subcategories->fetch_assoc()): ?>
                    <option value="<?php echo $subcat['id']; ?>" <?php echo ($subcategory == $subcat['id']) ? 'selected' : ''; ?>><?php echo $subcat['sub_category']; ?></option>
                <?php endwhile; ?>
            </select>
            <div class="invalid-feedback">Please select a subcategory.</div>
        </div>
        <div class="form-group">
            <label for="quantity">Quantity</label>
            <input type="number" class="form-control" id="quantity" name="quantity" value="<?php echo $quantity; ?>" required>
            <div class="invalid-feedback">Please enter a quantity.</div>
        </div>
        <div class="form-group">
            <label for="unitPrice">Unit Price</label>
            <input type="number" step="100" class="form-control" id="unitPrice" name="unitPrice" value="<?php echo $unitPrice; ?>" required>
            <div class="invalid-feedback">Please enter a unit price.</div>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Add Item</button>
    </form>
</div>

<script>
    // JavaScript for Bootstrap custom validation
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            var forms = document.getElementsByClassName('needs-validation');
            Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
