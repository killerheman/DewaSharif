<?php

$file = __DIR__ . '/../resources/views/admin/hotels/index.blade.php';
$content = file_get_contents($file);

// Pattern to remove extra_mattress_price div block in edit modal
$pattern = '/<div class="col-md-6">\s*<label class="form-label fw-bold">Extra Mattress Rate \(₹\)\*<\/label>\s*<input type="number" step="0\.01" name="extra_mattress_price" class="form-control" value="\{\{ \$hMattress \}\}" required>\s*<\/div>/s';

$cleaned = preg_replace($pattern, '', $content);

file_put_contents($file, $cleaned);
echo "Successfully cleaned Extra Mattress from index.blade.php\n";
