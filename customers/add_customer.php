<?php
require_once '../database/dbcon.php';

// Initialize variables for form data
$title = $firstName = $middleName = $lastName = $contactNumber = $districtId = '';
$message = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $firstName = $_POST['firstName'];
    $middleName = $_POST['middleName'];
    $lastName = $_POST['lastName'];
    $contactNumber = $_POST['contactNumber'];
    $districtId = $_POST['district'];

    // Prepare an SQL statement for inserting data
    $stmt = $conn->prepare("INSERT INTO customer (title, first_name, middle_name, last_name, contact_no, district) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $title, $firstName, $middleName, $lastName, $contactNumber, $districtId);

    // Execute the statement and check for success
    if ($stmt->execute()) {
        $message = "Customer information has been added successfully.";
    } else {
        $message = "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Fetch districts for the dropdown
$districts = $conn->query("SELECT id, district FROM district");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Customer Information Form</title>
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
        <h2 class="text-center">Customer Information Form</h2>
        <a href="index.php" class="btn btn-secondary mb-3">Back</a>
        <?php if ($message): ?>
            <div class="alert alert-info" role="alert">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        <form id="customerForm" class="needs-validation" method="POST" novalidate>
            <div class="form-group">
                <label for="title">Title</label>
                <select class="form-control" id="title" name="title" required>
                    <option value="">Select Title</option>
                    <option value="Mr" <?php echo ($title == "Mr") ? 'selected' : ''; ?>>Mr</option>
                    <option value="Mrs" <?php echo ($title == "Mrs") ? 'selected' : ''; ?>>Mrs</option>
                    <option value="Miss" <?php echo ($title == "Miss") ? 'selected' : ''; ?>>Miss</option>
                    <option value="Dr" <?php echo ($title == "Dr") ? 'selected' : ''; ?>>Dr</option>
                </select>
                <div class="invalid-feedback">Please select a title.</div>
            </div>
            <div class="form-group">
                <label for="firstName">First Name</label>
                <input type="text" class="form-control" id="firstName" name="firstName" placeholder="Enter First Name" value="<?php echo $firstName; ?>" required>
                <div class="invalid-feedback">Please provide a first name.</div>
            </div>
            <div class="form-group">
                <label for="middleName">Middle Name</label>
                <input type="text" class="form-control" id="middleName" name="middleName" placeholder="Enter Middle Name" value="<?php echo $middleName; ?>" required>
                <div class="invalid-feedback">Please provide a middle name.</div>
            </div>
            <div class="form-group">
                <label for="lastName">Last Name</label>
                <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Enter Last Name" value="<?php echo $lastName; ?>" required>
                <div class="invalid-feedback">Please provide a last name.</div>
            </div>
            <div class="form-group">
                <label for="contactNumber">Contact Number</label>
                <input type="tel" class="form-control" id="contactNumber" name="contactNumber" placeholder="Enter Contact Number" required pattern="0[0-9]{10}" value="<?php echo $contactNumber; ?>">
                <div class="invalid-feedback">Please enter a valid 10-digit contact number starting with 0.</div>
            </div>
            <div class="form-group">
                <label for="district">District</label>
                <select class="form-control" id="district" name="district" required>
                    <option value="">Select District</option>
                    <?php while ($district = $districts->fetch_assoc()): ?>
                        <option value="<?php echo $district['id']; ?>" <?php echo ($districtId == $district['id']) ? 'selected' : ''; ?>><?php echo $district['district']; ?></option>
                    <?php endwhile; ?>
                </select>
                <div class="invalid-feedback">Please select a district.</div>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Submit</button>
        </form>
    </div>

    <script>
        // JavaScript for Bootstrap custom validation
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                // Fetch all forms we want to apply custom Bootstrap validation styles to
                var forms = document.getElementsByClassName('needs-validation');
                // Loop over them and prevent submission
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
