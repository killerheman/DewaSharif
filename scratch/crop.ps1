Add-Type -AssemblyName System.Drawing
$img = [System.Drawing.Image]::FromFile("C:\Users\Lenovo\.gemini\antigravity-ide\brain\0f4730b3-bd68-4901-9ba2-89d16a6e868f\.user_uploaded\media_1792159810611.png")
$bmp = New-Object System.Drawing.Bitmap(600, 70)
$g = [System.Drawing.Graphics]::FromImage($bmp)
$rectSrc = New-Object System.Drawing.Rectangle(45, 110, 600, 70)
$rectDest = New-Object System.Drawing.Rectangle(0, 0, 600, 70)
$g.DrawImage($img, $rectDest, $rectSrc, [System.Drawing.GraphicsUnit]::Pixel)
$bmp.Save("D:\OldProjects\DewaSharif\scratch\crop_zigzag2.png", [System.Drawing.Imaging.ImageFormat]::Png)
$g.Dispose()
$bmp.Dispose()
$img.Dispose()
Write-Host "DONE"
