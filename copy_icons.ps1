$sourceDir = "C:\Users\Pc\.gemini\antigravity-ide\brain\1edb24b1-9b96-4e2d-96b3-b79681288d8b"
$destDir = "d:\lab\lab\public\icons"
New-Item -ItemType Directory -Force -Path $destDir
Get-ChildItem -Path $sourceDir -Filter "icon_*.jpg" | ForEach-Object {
    $newName = $_.Name -replace '_\d+\.jpg','.jpg'
    Copy-Item -Path $_.FullName -Destination (Join-Path $destDir $newName) -Force
}
