<?php
$im = imagecreatefrompng('C:/Users/Lenovo/.gemini/antigravity-ide/brain/0f4730b3-bd68-4901-9ba2-89d16a6e868f/.user_uploaded/media_1792159810611.png');
$crop = imagecrop($im, ['x' => 45, 'y' => 205, 'width' => 450, 'height' => 60]);
imagepng($crop, 'scratch/crop_zigzag.png');
echo "Cropped successfully\n";
