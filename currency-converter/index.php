<?php
$apiKey = "5493f14ab3ec0c0593342aa4"; 
$fromCurrency = "USD";
$toCurrency = "EUR";
$convertedAmount = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fromCurrency = $_POST["from"];
    $toCurrency = $_POST["to"];
    $amount = $_POST["amount"];

    $apiUrl = "https://v6.exchangerate-api.com/v6/$apiKey/latest/$fromCurrency";

    $response = file_get_contents($apiUrl);
    $data = json_decode($response, true);

    if ($data && isset($data["conversion_rates"][$toCurrency])) {
        $rate = $data["conversion_rates"][$toCurrency];
        $convertedAmount = round($amount * $rate, 2);
    } else {
        $convertedAmount = "Invalid currency code or API issue.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Currency Converter</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Currency Converter</h2>
        <form method="POST" class="mt-4">
            <div class="mb-3">
                <label>Amount</label>
                <input type="number" name="amount" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>From Currency</label>
                <select name="from" class="form-control">
                    <option value="USD">USD (United States Dollar)</option>
                    <option value="EUR">EUR (Euro)</option>
                    <option value="GBP">GBP (British Pound)</option>
                    <option value="INR">INR (Indian Rupee)</option>
                </select>
            </div>
            <div class="mb-3">
                <label>To Currency</label>
                <select name="to" class="form-control">
                    <option value="EUR">EUR (Euro)</option>
                    <option value="USD">USD (United States Dollar)</option>
                    <option value="GBP">GBP (British Pound)</option>
                    <option value="INR">INR (Indian Rupee)</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Convert</button>
        </form>

        <?php if ($convertedAmount !== ""): ?>
            <div class="alert alert-success mt-3">
                Converted Amount: <strong><?php echo $convertedAmount . " " . $toCurrency; ?></strong>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
