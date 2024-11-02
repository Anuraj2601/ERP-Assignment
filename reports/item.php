<?php
    require_once '../database/dbcon.php';

    function getInvoiceReport($conn) {
        $sql = "SELECT 
            itm.item_name AS item_name,
            cat.category AS item_category,
            subcat.sub_category AS item_subcategory,
            SUM(ii.quantity) AS total_quantity
        FROM 
            invoice_master ii
        JOIN 
            item itm ON ii.item_id = itm.id
        JOIN 
            item_category cat ON itm.item_category = cat.id
        JOIN 
            item_subcategory subcat ON itm.item_subcategory = subcat.id
        GROUP BY 
            itm.item_name, cat.category, subcat.sub_category
        ORDER BY 
            itm.item_name";
        
        $result = $conn->query($sql);
        
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }

    $invoiceReportData = getInvoiceReport($conn);
    $conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
        h1 {
            color: #343a40;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="form-container mt-5">
        <h1 class="mb-4">Item Report</h1>
        <a href="index.php" class="btn btn-secondary mb-3">Back</a>

        <?php if (isset($invoiceReportData) && count($invoiceReportData) > 0): ?>
            <table class="table table-striped table-bordered mt-4">
                <thead class="table-light">
                    <tr>
                        <th>Item Name</th>
                        <th>Item Category</th>
                        <th>Item Subcategory</th>
                        <th>Item Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($invoiceReportData as $row): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['item_name']) ?></td>
                            <td><?= htmlspecialchars($row['item_category']) ?></td>
                            <td><?= htmlspecialchars($row['item_subcategory']) ?></td>
                            <td><?= htmlspecialchars($row['total_quantity']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-warning mt-4" role="alert">
                No records found.
            </div>
        <?php endif; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
