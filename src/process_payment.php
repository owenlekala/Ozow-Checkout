<?php

function generate_request_hash() {
    $siteCode = "YOUR_SITE_CODE";
    $countryCode = "ZA";
    $currencyCode = "ZAR";
    $amount = isset($_GET['amount']) ? intval($_GET['amount']) : 0.00;
    $transactionReference = "TEST123";
    $bankReference = "TEST456";
    $cancelUrl = "http://pay.domain.co.za/cancel.php";
    $errorUrl = "http://pay.domain.co.za/error.php";
    $successUrl = "http://pay.domain.co.za/success.php";
    $notifyUrl = "http://pay.domain.co.za/notify.php";
    $privateKey = "YOUR_PRIVATE_KEY";
    $isTest = "false";
    
    $inputString = $siteCode . $countryCode . $currencyCode . $amount . $transactionReference . $bankReference . $cancelUrl . $errorUrl . $successUrl . $notifyUrl . $isTest . $privateKey;
    
    $calculatedHashResult = generate_request_hash_check($inputString);
    

    return $calculatedHashResult;
}

function generate_request_hash_check($inputString) {
    $stringToHash = strtolower($inputString);
    
    return get_sha512_hash($stringToHash);
}

function get_sha512_hash($stringToHash) {
    $bytes = hash('sha512', $stringToHash, true);
    $hex = bin2hex($bytes);
    return $hex;
}

$HashResult = generate_request_hash(); 

$curl = curl_init();

$data = [
    "countryCode" => "ZA", 
    "amount" => isset($_GET['amount']) ? intval($_GET['amount']) : 0.00, // Use a float value
    "transactionReference" => "TEST123",
    "bankReference" => "TEST456",
    "cancelUrl" => "http://pay.domain.co.za/cancel.php",
    "currencyCode" => "ZAR",
    "errorUrl" => "http://pay.domain.co.za/error.php",
    "isTest" => false, // Use a boolean value
    "notifyUrl" => "http://pay.domain.co.za/notify.php",
    "siteCode" => "YOUR_SITE_CODE",
    "successUrl" => "http://pay.domain.co.za/success.php",
    "hashCheck" => $HashResult // Use the calculated hash variable
];

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.ozow.com/postpaymentrequest',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => json_encode($data),
  CURLOPT_HTTPHEADER => array(
    'Accept: application/json',
    'ApiKey: YOUR_API_KEY', // Replace with your API key
    'Content-Type: application/json'
  ),
));

$response = curl_exec($curl);

curl_close($curl);

$responseData = json_decode($response, true); // Decode the JSON response

if ($responseData && $responseData['url']) {
    // If the response contains a valid URL, redirect the user to that URL
    header("Location: " . $responseData['url']);
    exit; // Stop further script execution
} else {
    // Handle the case where the response does not contain a valid URL
    echo "Invalid response or missing URL.";
    echo $response;
    // You can also add additional error handling code here
}

?>
