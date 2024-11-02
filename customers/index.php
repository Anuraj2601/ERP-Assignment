<?php
    require_once '../database/dbcon.php';


    if (isset($_GET['delete_customer'])) {
        $customerId = $_GET['delete_customer'];
        $stmt = $conn->prepare("DELETE FROM customer WHERE id = ?");
        $stmt->bind_param("i", $customerId);
        if ($stmt->execute()) {
            echo "<script>alert('Customer deleted successfully!');</script>";
            echo "<script>window.location.href='index.php';</script>";
        } else {
            echo "<script>alert('Error deleting customer');</script>";
        }
    }
    $customers = $conn->query("SELECT c.id, c.title, c.first_name, c.last_name, c.contact_no, d.district FROM customer c JOIN district d ON c.district = d.id;");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Management</title>
</head>
<body>
<div class="container mt-5">
    <h2>Customer Management</h2>
    <a href="../index.php" class="btn btn-secondary mb-3">Back</a>
    <a href="add_customer.php" class="btn btn-primary mb-3">Add Customer</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Contact Number</th>
                <th>District</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($customer = $customers->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $customer['id']; ?></td>
                    <td><?php echo $customer['title']; ?></td>
                    <td><?php echo $customer['first_name']; ?></td>
                    <td><?php echo $customer['last_name']; ?></td>
                    <td><?php echo $customer['contact_no']; ?></td>
                    <td><?php echo $customer['district']; ?></td>
                    <td>
                        <a href="edit_customer.php?id=<?php echo $customer['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        <button onclick="setDeleteCustomer(<?php echo $customer['id']; ?>)" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal">Delete</button>
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
                Are you sure you want to delete this customer?
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
    // JavaScript function to set the delete link in the modal
    function setDeleteCustomer(customerId) {
        document.getElementById('confirmDeleteBtn').href = 'index.php?delete_customer=' + customerId;
    }
</script>
</body>
</html>
