param([string]$Php='php')
$ErrorActionPreference='Stop'
$root=Split-Path $PSScriptRoot -Parent
$source=Join-Path $root 'source'
$release=Join-Path $root 'release'
$runtime=Join-Path $root 'runtime'
New-Item -ItemType Directory -Path $release,$runtime -Force | Out-Null
$phpFiles=Get-ChildItem -LiteralPath $source -Filter '*.php' -Recurse -File
foreach($file in $phpFiles){ $lint=& $Php -l $file.FullName; if($LASTEXITCODE -ne 0){ throw $lint } }
Add-Type -AssemblyName System.IO.Compression.FileSystem
$results=@()
foreach($name in @('people-planet-thrive','ppt-core')) {
 $directory=Join-Path $source $name
 $zip=Join-Path $release ($name+'.zip')
 if(Test-Path -LiteralPath $zip){Remove-Item -LiteralPath $zip}
 [IO.Compression.ZipFile]::CreateFromDirectory($directory,$zip,[IO.Compression.CompressionLevel]::Optimal,$true)
 $archive=[IO.Compression.ZipFile]::OpenRead($zip)
 try {
  $entries=@($archive.Entries | Where-Object { $_.Name })
  $invalid=@($entries | Where-Object { !$_.FullName.StartsWith($name+'/') -or $_.FullName -match '(^|/)(runtime|checkpoint|node_modules|\.git|wp-config\.php|\.env[^/]*)(/|$)' })
  if($invalid.Count){throw 'Unexpected release archive entries'}
  $sourceFiles=@(Get-ChildItem -LiteralPath $directory -Recurse -File -Force)
  if($entries.Count -ne $sourceFiles.Count){throw 'Package file count differs from source'}
  $results+=@{package=$name+'.zip';files=$entries.Count;sha256=(Get-FileHash -LiteralPath $zip -Algorithm SHA256).Hash.ToLower();bytes=(Get-Item -LiteralPath $zip).Length}
 } finally { $archive.Dispose() }
}
$report=@{php_files_linted=$phpFiles.Count;packages=$results;built_at=[DateTime]::UtcNow.ToString('o')}
$report | ConvertTo-Json -Depth 4 | Set-Content -LiteralPath (Join-Path $runtime 'package-results.json') -Encoding utf8
$report | ConvertTo-Json -Depth 4
