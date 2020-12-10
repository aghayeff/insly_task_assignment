<!DOCTYPE html>
<html>
<body>

<?php

$filename = "name.bin";

$handle = fopen($filename, 'r');;
$contents = fread($handle, filesize($filename));
$binaries = explode(' ', $contents);
$output = '';

foreach ($binaries as $binary) {
    $output .= chr(intval($binary, 2));
}

fclose($handle);

echo '<b>' . $output . '</b>';

echo "<br><br>";

$myName = "Rashad Aghayev";
$myNameInLoop = str_split($myName, 1);

foreach ($myNameInLoop as $letter) {
    echo $letter . " ";
}

?>

</body>
</html>