<?php
require __DIR__ . '/views/head.php';

use GuzzleHttp\Client;

$uuid = isValidUuid($transferCode);

$transferCode = $_SESSION['transfer-code'];
$totalcost = $_SESSION['totalcost'];

if (!$uuid) {
    echo 'Transfer code invalid - please try again!';
    return false;
} else {
    $client = new Client([
        'base_uri' => 'https://www.yrgopelag.se/centralbank'
    ]);
    try {
        $response = $client->request('POST', 'https://www.yrgopelag.se/centralbank/transferCode', [
            'form_params' => [
                'transferCode' => $transferCode,
                'totalcost' => $totalcost
            ],
        ]);
        $response = $response->getBody()->getContents();
        $response = json_decode($response, true);
    } catch (Exception $e) {
        echo 'There was an issue with the API. Please try again.';
        return false;
    }
    if (!array_key_exists('amount', $response) || $response['amount'] < $totalCost) {
        echo 'Please double-check amount and transfer code and try again.';
        return false;
    };
    return true;
}




echo $response->getStatusCode();
echo $response->getBody();
