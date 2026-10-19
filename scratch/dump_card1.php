<?php
$html = file_get_contents('http://127.0.0.1:8000/hotels/detail/');
$pos1 = strpos($html, 'ROOM CARD 1');
$pos2 = strpos($html, 'ROOM CARD 2');
echo substr($html, $pos1, $pos2 - $pos1);
