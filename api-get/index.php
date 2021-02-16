<?php
require '../vendor/autoload.php';
$k = isset($_GET['k'])&&!empty($_GET['k'])?($_GET['k']): "ERROR";
$s = isset($_GET['s'])&&!empty($_GET['s'])?($_GET['s']): "ERROR";
$api = new Binance\API($k,$s);

echo "<pre><br>METHODOS SUPORTADOS";
echo 
'
	<br><a href="?action=ERROR">get Last Price All</a> 
	<br><a href="?action=getLastPrice">get Last Price</a> 
	<br><a href="?action=getAllyourPositions">get All your Positions</a> 
	<br><a href="?action=PlaceaLIMITorder">Place a LIMIT order</a> 
	<br><a href="?action=PlaceaMARKETorder">Place a MARKET order</a> 
	<br><a href="?action=PlaceaSTOPLOSSorder">Place a STOP LOSS order</a> 
	<br><a href="?action=PlaceanICEBERGorder">Place an ICEBERG order</a> 

	<br><a href="?action=GetMarketDepth">Get Market Depth</a> 
	<br><a href="?action=GetOpenOrders">Get Open Orders</a> 
	<br><a href="?action=GetOrderStatus">Get Order Status</a> 
	<br><a href="?action=CancelanOrder">Cancelan Order</a> 
	<br><a href="?action=GetTradeHistory">Get Trade History</a> 
	<br><a href="?action=GetKline_candlestickdataforasymbol">Get K line_candles tick data for a symbol</a> 
	<br><a href="?action=AggregateTradesList">Aggregate Trades List</a> 
	<br><a href="?action=TradeUpdatesviaWebSocket">Trade Updates viaWebSocket</a> 
	<br><a href="?action=GetcompleterealtimechartdataviaWebSockets">Get completereal time chart data via WebSockets</a> 
	<br><br>
';

//Set default values
$msgError = NULL;


$action = isset($_GET['action'])&&!empty($_GET['action'])?$_GET['action']: "ERROR";
$coin = isset($_GET['coin'])&&!empty($_GET['coin'])?$_GET['coin']: "ERROR";

$price = isset($_GET['price'])&&!empty($_GET['price'])? $_GET['price'] : "ERROR";
$quantity = isset($_GET['quantity'])&&!empty($_GET['quantity'])? $_GET['quantity'] : "ERROR";
$stopPrice = isset($_GET['stopPrice'])&&!empty($_GET['stopPrice'])? $_GET['stopPrice'] : "ERROR";
$icebergQty = isset($_GET['icebergQty'])&&!empty($_GET['icebergQty'])? $_GET['icebergQty'] : "ERROR";
$orderid = isset($_GET['orderid'])&&!empty($_GET['orderid'])? $_GET['orderid'] : "ERROR";
$period = isset($_GET['period'])&&!empty($_GET['period'])? $_GET['period'] : "ERROR";

$symbol  = isset($_GET['$symbol '])&&!empty($_GET['$symbol '])? $_GET['$symbol '] : "ERROR";
$trades = isset($_GET['$trades'])&&!empty($_GET['$trades'])? $_GET['$trades'] : "ERROR";
$chart = isset($_GET['$chart'])&&!empty($_GET['$chart'])? $_GET['$chart'] : "ERROR";
$depth = isset($_GET['$depth'])&&!empty($_GET['$depth'])? $_GET['$depth'] : "ERROR";


if ($action == 'ERROR') // Se não informar nenhum metodo ele lista tudo e foda-se 
{
	// Get latest price of all symbols
	$tickers = $api->prices();
	echo "<br><h1>tickers:</h1> "; print_r($tickers); // List prices of all symbols
}

if ($action == 'getLastPrice') 
{
	// Get latest price of a symbol
	echo '<br> Params expected ($coin) to GET LAST PRICE <br>';
	$price = $api->price($coin);
	echo "Price of $coin: {$price} BTC.\n";
}

if ($action == 'getAllyourPositions') 
{
	// Get all of your positions, including estimated BTC value
	$balances = $api->balances($tickers);
	echo"<br><h1>balances:</h1> "; print_r($balances);

}

if ($action =='Getallbid_askprices') 
{
	// Get all bid/ask prices
	$bookPrices = $api->bookPrices();
	echo"<br><h1>bookPrices:</h1> "; 
	// print_r($bookPrices);
	echo $coin." - TEM O BID = ".$bookPrices[$coin]['bid'];
}


////-------------------------------------------------------------------------------

if ($action == 'PlaceaLIMITorder') 
{
	echo "<br> Place a LIMIT order";
	echo '<br> Params expected ($coin, $quantity, $price) to BUY <br>';
	$quantity = $_GET['quantity'];
	// $price = $_GET['price'];
	$order = $api->buy($coin, $quantity, $price);
	echo "<pre>";
	var_dump($order);
	echo "</pre>";
}

if ($action == 'PlaceaMARKETorder')
{
	echo "<br> Place a MARKET order";
	echo '<br> Params expected ($coin, $quantity) to BUY <br>';
	// $quantity = $_GET['quantity'];
	$order = $api->buy($coin, $quantity, 0, "MARKET");
	echo "<pre>";
	var_dump($order);
	echo "</pre>";
}

if ($action == 'PlaceaSTOPLOSSorder')
{
	echo "<br> Place a STOP LOSS order";
	echo "<br> When the stop is reached, a stop order becomes a market order";
	echo '<br> Params expected ($coin, $quantity, $price) to SELL <br>';
	// $quantity = $_GET['quantity'];
	// $price = $_GET['price'];
	// $stopPrice = $_GET['stopPrice']; // Sell immediately if price goes below 0.4 btc
	$order = $api->sell($coin, $quantity, $price, "LIMIT", ["stopPrice"=>$stopPrice]);
	echo"<br><h1>order:</h1> "; print_r($order);	
}


if ($action == 'PlaceanICEBERGorder')
{
	echo "<br>Place an ICEBERG order";
	echo "<br>Iceberg orders are intended to conceal the true order quantity.";
	echo '<br> Params expected ($coin, $quantity, $price) to SELL <br>';
	// $quantity = $_GET['quantity'];
	// $price = $_GET['price'];
	$icebergQty = $_GET['icebergQty'];
	$order = $api->sell($coin, $quantity, $price, "LIMIT", ["icebergQty"=>$icebergQty]);
	echo"<br><h1>order:</h1> "; print_r($order);
}




// --------------------------------------------------------------------------------------------------------------

if ($action == 'GetMarketDepth')
{
	echo "<br>Get Market Depth";
	echo '<br> Params expected ($coin)<br>';
	$depth = $api->depth($coin);
	echo"<br><h1>depth:</h1> "; print_r($depth);
}

if ($action == 'GetOpenOrders')
{
	echo "<br>Get Open Orders";
	echo '<br> Params expected ($coin)<br>';
	$openorders = $api->openOrders($coin);
	echo"<br><h1>openorders:</h1> "; print_r($openorders);
}

if ($action == 'GetOrderStatus')
{
	echo "<br> Get Order Status";
	// $orderid = "7610385";
	echo '<br> Params expected ($coin, $orderid)<br>';
	$orderstatus = $api->orderStatus($coin, $orderid);
	echo"<br><h1>orderstatus:</h1> "; print_r($orderstatus);
}

if ($action == 'CancelanOrder')
{
	echo "<br> Cancel an Order";
	echo '<br> Params expected ($coin, $orderid)<br>';
	$response = $api->cancel($coin, $orderid);
	echo"<br><h1>response:</h1> "; print_r($response);
}

if ($action == 'GetTradeHistory')
{
	echo "<br> Get Trade History";
	echo '<br> Params expected ($coin)<br>';
	$history = $api->history($coin);
	echo"<br><h1>history:</h1> "; print_r($history);
}

if ($action == 'GetKline_candlestickdataforasymbol')
{
	echo "<br> Get Kline/candlestick data for a symbol";
	echo "<br> Periods: 1m,3m,5m,15m,30m,1h,2h,4h,6h,8h,12h,1d,3d,1w,1M";
	echo '<br> Params expected ($coin, $period)<br>';
	$ticks = $api->candlesticks($coin, $period);
	echo"<br><h1>ticks:</h1> "; print_r($ticks);
}

if ($action == 'AggregateTradesList')
{
	echo "<br>Aggregate Trades List";
	echo '<br> Params expected ($coin)<br>';
	$trades = $api->aggTrades($coin);
	echo"<br><h1>trades:</h1> "; print_r($trades);
}

// --------------------------------CONTINGENCIA-----------------------------------------
if ($action == 'TradeUpdatesviaWebSocket')
{
	echo "<br> Trade Updates via WebSocket";
	echo '<br> Params expected ($api, $symbol, $trades)<br>';
	$api->trades([$coin], function($api, $symbol, $trades) {
	   echo "{$symbol} trades update".PHP_EOL;
	   echo"<br><h1>trades:</h1> "; print_r($trades);
	});
}

if ($action == 'GetcompleterealtimechartdataviaWebSockets')
{
	echo "<br> Get complete realtime chart data via WebSockets";
	echo '<br> Params expected ($api, $symbol, $chart)<br>';
	$api->chart([$coin], "15m", function($api, $symbol, $chart) {
	   echo "{$symbol} chart update\n";
	   echo"<br><h1>chart:</h1> "; print_r($chart);
	});
}

if ($action == 'GrabrealtimeupdateddepthcacheviaWebSockets')
{
	echo "<br> Grab realtime updated depth cache via WebSockets";
	echo '<br> Params expected ($api, $symbol, $depth)<br>';
	$api->depthCache([$coin], function($api, $symbol, $depth) {
	    echo "{$symbol} depth cache update\n";
	    $limit = 11; // Show only the closest asks/bids
	    $sorted = $api->sortDepth($symbol, $limit);
	    $bid = $api->first($sorted['bids']);
	    $ask = $api->first($sorted['asks']);
	    echo $api->displayDepth($sorted);
	    echo "ask: {$ask}\n";
	    echo "bid: {$bid}\n";
	});
}
?>
