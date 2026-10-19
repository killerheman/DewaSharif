<?php

$url = 'http://127.0.0.1:8000/admin/profile';
$headers = @get_headers($url);
echo "Headers for /admin/profile:\n";
print_r($headers);
