<?php

$api_key = "[YOUR API KEY]";
$site_code = "[YOUR SITE CODE]";
$transaction_id = isset($_GET['tref']) ? $_GET['tref'] : '';
$base_url = "https://stagingapi.ozow.com/GetTransaction";

$url = "{$base_url}?siteCode={$site_code}&transactionId={$transaction_id}";

$headers = array("ApiKey" => $api_key);

$options = array(
    "http" => array(
        "header" => "ApiKey: {$api_key}\r\n",
        "method" => "GET"
    )
);

$context = stream_context_create($options);
$response = file_get_contents($url, false, $context);

echo $response;

?>
