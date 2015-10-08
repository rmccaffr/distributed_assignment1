<?php 
$address = '0.0.0.0';
$port = 8000;

if (($socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) === false) {
    echo "Error socket_create() failed: Reason: " . socket_strerror(socket_last_error()) . "\n";
}else {
    echo "OK.\n";
}
$result = socket_connect($socket, $address, $port);
if ($result === false) {
    echo "Error socket_connect() failed.\nReason: ($result) " . socket_strerror(socket_last_error($socket)) . "\n";
} else {
    echo "OK.\n";
}

echo "Enter message and press return\n";
$handle = fopen ("php://stdin","r");
$input = fgets($handle);
$input = rawurlencode($input);  
 
$in ="GET /echo.php?message=".$input." HTTP/1.1\r\n".
"Host: localhost\r\n".
"Connection: Close\r\n\r\n";

echo "Sending HTTP HEAD request:";
socket_write($socket, $in, strlen($in));
echo "OK.\n";

echo "Response:\n";
while ($out = socket_read($socket, 2048)) {
    echo $out;
}

echo "Closing socket:";
socket_close($socket);
echo "OK.\n";

?>
