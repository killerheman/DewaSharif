<?php
$html = file_get_contents('http://127.0.0.1:8000/hotels/detail/');
$pos = strpos($html, 'Select Room Type');
if ($pos !== false) {
    echo substr($html, $pos - 100, 3000);
} else {
    echo "NOT FOUND\n";
}
