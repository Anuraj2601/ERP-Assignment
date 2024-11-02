<?php
require_once '../database/dbcon.php';


    if (isset($_GET['delete_item'])) {
        $itemId = $_GET['delete_item'];
        $stmt = $conn->prepare("DELETE FROM item WHERE id = ?");
        $stmt->bind_param("i", $itemId);
        if ($stmt->execute()) {
            echo "<script>alert('Item deleted successfully!');</script>";
            echo "<script>window.location.href='index.php';</script>";
        } else {
            echo "<script>alert('Error deleting item');</script>";
        }
    }

    $items = $conn->query("
        SELECT 
            i.id,
            i.item_code,
            i.item_name,
            i.quantity,
            i.unit_price,
            c.category,
            cs.sub_category
        FROM 
            item i 
        JOIN 
            item_category c ON i.item_category = c.id
        JOIN 
            item_subcategory cs ON i.item_subcategory = cs.id;
    ");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item Management</title>
</head>
<body>
<div class="container mt-5">
    <h2>Item Management</h2>
    <a href="../index.php" class="btn btn-secondary mb-3">Back</a>
    <a href="add_item.php" class="btn btn-primary mb-3">Add Item</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Item Code</th>
                <th>Item Name</th>
                <th>Item Category</th>
                <th>Item Sub category</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($item = $items->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $item['id']; ?></td>
                    <td><?php echo $item['item_code']; ?></td>
                    <td><?php echo $item['item_name']; ?></td>
                    <td><?php echo $item['category']; ?></td>
                    <td><?php echo $item['sub_category']; ?></td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td><?php echo $item['unit_price']; ?></td>
                    <td>
                        <a href="edit_item.php?id=<?php echo $item['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        <button onclick="setDeleteItem(<?php echo $item['id']; ?>)" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal">Delete</button>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>


<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this item?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <a href="#" id="confirmDeleteBtn" class="btn btn-danger">Delete</a>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<script>
    function setDeleteItem(itemId) {
        document.getElementById('confirmDeleteBtn').href = 'index.php?delete_item=' + itemId;
    }
</script>
</body>
</html>
