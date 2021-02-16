<?php
require 'php-binance-api.php';
require 'vendor/autoload.php';


$api_key = "z5RQZ9n8JcS3HLDQmPpfLQIGGQN6TTs5pCP5CTnn4nYk2ImFcew49v4ZrmP3MGl5";
$api_secret = "ZqePF1DcLb6Oa0CfcLWH0Tva59y8qBBIqu789JEY27jq0RkOKXpNl9992By1PN9Z";

$api = new Binance\API($api_key, $api_secret);
$result = $api->marketBuy( "BNBBTC", 1 );
print_r( $result ) . "\n";
echo("-------------------------SEPARACAO---------------------------------------------------- <br>");
$api_key = "z5RQZ9n8JcS3HLDQmPpfLQIGGQN6TTs5pCP5CTnn4nYk2ImFcew49v4ZrmP3MGl5";
$api_secret = "intentionally wrong";

$api = new Binance\API($api_key, $api_secret);
$result = $api->marketBuy( "BNBBTC", 1 );
print_r( $result ) . "\n";
echo("-------------------------SEPARACAO---------------------------------------------------- <br>");

$api_key = "YDjDADdXLCkY1BnjFxKVvBzheIyFjtafSU4yyadffiBXdezyViMi0ngiVBawwd3x";
$api_secret = "CtWl7kkYB4eKePyosmuGbJH8FBH4ArTB2qOIedHcOYfzALDG2eD46mWVGsf7lrHJ"; // trading disabled

$api = new Binance\API($api_key, $api_secret);
$result = $api->marketBuy( "BNBBTC", 1 );
print_r( $result ) . "\n";
echo("-------------------------SEPARACAO---------------------------------------------------- <br>");

// 4. Rate Limiting Support
$api = new Binance\RateLimiter(new Binance\API($api_key, $api_secret));


$price = $api->price("BNBBTC");
echo "<br><Br>Price of BNB: {$price} BTC.".PHP_EOL;

?>