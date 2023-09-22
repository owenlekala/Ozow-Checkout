<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Page</title>
</head>
<body>
    <h1>Payment Page</h1>
    <form action="process_payment.php" method="post">
        <label for="amount">Amount (in ZAR):</label>
        <input type="text" id="amount" name="amount" required>
        <br>
        <button type="submit">Pay with Ozow</button>
    </form>
</body>
</html>
