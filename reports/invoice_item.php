<?php
require_once '../database/dbcon.php';

function getInvoiceReport($startDate, $endDate, $conn) {
    $sql = "SELECT 
    i.invoice_no AS invoice_number,
    i.date AS invoice_date,
    c.first_name AS customer_name,
    itm.item_name AS item_name,
    itm.item_code AS item_code,
    cat.category AS item_category,
    ii.unit_price AS item_unit_price
FROM 
    invoice i
JOIN 
    customer c ON i.customer = c.id
JOIN 
    invoice_master ii ON i.invoice_no = ii.invoice_no
JOIN 
    item itm ON ii.item_id = itm.id
JOIN 
    item_category cat ON itm.item_category = cat.id
WHERE 
    i.date BETWEEN ? AND ?
ORDER BY 
    i.date, i.invoice_no;
";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $startDate, $endDate);
    $stmt->execute();
    $result = $stmt->get_result();

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    return $data;
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['start_date']) && isset($_GET['end_date'])) {
    $startDate = $_GET['start_date'];
    $endDate = $_GET['end_date'];
    $invoiceReportData = getInvoiceReport($startDate, $endDate, $conn);
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Item Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .form-container {
            max-width: 900px;
            margin: 50px auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2.text-center {
            color: #343a40;
            font-weight: bold;
        }

        .btn-secondary.mb-3 {
            background-color: #6c757d;
            border: none;
            color: white;
        }

        .btn-primary.btn-block {
            background-color: #007bff;
            border: none;
        }

        .form-group label {
            font-weight: 500;
            color: #495057;
        }

        .invalid-feedback {
            font-size: 0.9em;
            color: #dc3545;
        }

    </style>
</head>
<body>
    <div class="form-container mt-5">
        <h1 class="mb-4">Invoice Item Report</h1>
        <a href="index.php" class="btn btn-secondary mb-3">Back</a>
        <form method="GET" action="">
            <div class="mb-3">
                <label for="startDate" class="form-label">Start Date:</label>
                <input type="date" id="startDate" name="start_date" class="form-control" required>
            </div>
            
            <div class="mb-3">
                <label for="endDate" class="form-label">End Date:</label>
                <input type="date" id="endDate" name="end_date" class="form-control" required>
            </div>
            
            <button type="submit" class="btn btn-success">Generate Report</button>
        </form>

        <?php if (isset($invoiceReportData) && count($invoiceReportData) > 0): ?>
            <table class="table table-striped table-bordered mt-4">
                <thead class="table-light">
                    <tr>
                        <th>Invoice Number</th>
                        <th>Invoiced Date</th>
                        <th>Customer Name</th>
                        <th>Item Name and Code</th>
                        <th>Item Category</th>
                        <th>Unit Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($invoiceReportData as $row): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['invoice_number']) ?></td>
                            <td><?= htmlspecialchars($row['invoice_date']) ?></td>
                            <td><?= htmlspecialchars($row['customer_name']) ?></td>
                            <td><?= htmlspecialchars($row['item_name']) ."\t". htmlspecialchars($row['item_code']) ?></td>
                            <td><?= htmlspecialchars($row['item_category']) ?></td>
                            <td><?= htmlspecialchars($row['item_unit_price']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php elseif (isset($invoiceReportData)): ?>
            <div class="alert alert-warning mt-4" role="alert">
                No records found for the selected date range.
            </div>
        <?php endif; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
