<?php

$apiKey = "TU_API_KEY_AQUI";
$secretKey = "TU_SECRET_KEY_AQUI";
$commerceCode = "TU_COMMERCE_CODE_AQUI";

$url = "https://webpay3gint.transbank.cl/rswebpaytransaction/api/webpay/v1.2/transactions";

$body = [
    "buy_order" => "ORDEN123",
    "session_id" => "sesion-test",
    "amount" => 5000,
    "return_url" => "http://localhost/retorno_webpay.php"
];

$bodyString = json_encode($body);

$headers = [
    "Content-Type: application/json",
    "Tbk-Api-Key-Id: $apiKey",
    "Tbk-Api-Key-Secret: $secretKey",
];

$curl = curl_init($url);

curl_setopt_array($curl, [
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $bodyString,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => $headers,
]);

$response = curl_exec($curl);
curl_close($curl);

echo "<pre>";
print_r(json_decode($response, true));
echo "</pre>";
