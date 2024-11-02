<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
            text-align: center;
        }
        .card-container {
            display: flex;
            justify-content: center;
            gap: 20px;
        }
        .card {
            width: 200px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .btn-back {
            background-color: #6c757d;
            color: white;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        
        <a href="../" class="btn btn-back mb-4">Back</a>
        
        
        <div class="card-container">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Invoice</h5>
                    <a href="invoice.php" class="btn btn-primary">Go to Page</a>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Invoice Item</h5>
                    <a href="invoice_item.php" class="btn btn-primary">Go to Page</a>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Item</h5>
                    <a href="item.php" class="btn btn-primary">Go to Page</a>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
