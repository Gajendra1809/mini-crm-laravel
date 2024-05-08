<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to MiniCRM</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            padding: 20px;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
        }
        .card-title {
            color: #333333;
            font-weight: bold;
        }
        .card-text {
            color: #666666;
        }
        .btn {
            background-color: #007bff;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            text-decoration: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title text-center">Welcome to MiniCRM</h2>
                        <p class="card-text text-center">Dear <b>{{$data}}</b>,</p>
                        <p class="card-text text-center">We are thrilled to welcome you to our community at MiniCRM. Your satisfaction is our top priority, and we are committed to providing you with the best experience.</p>
                        <p class="card-text text-center">Please feel free to reach out to us at any time with questions, concerns, or feedback. We are here to support you every step of the way.</p>
                        <p class="card-text text-center">Thank you for choosing MiniCRM. We look forward to serving you!</p>
                        <p class="card-text text-center">Best regards,<br/>The MiniCRM Team</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
