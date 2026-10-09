param([string]$WordPressPath='')
$ErrorActionPreference='Stop'
$root=Split-Path $PSScriptRoot -Parent
if(!$WordPressPath){$WordPressPath=Join-Path $root 'runtime/reinstall/wordpress'}
$mismatches=@();$count=0
foreach($item in @(@('people-planet-thrive','themes'),@('ppt-core','plugins'))) {
 $source=Join-Path $root ('source/'+$item[0])
 $installed=Join-Path $WordPressPath ('wp-content/'+$item[1]+'/'+$item[0])
 foreach($file in Get-ChildItem -LiteralPath $source -File -Recurse -Force) {
  $relative=[IO.Path]::GetRelativePath($source,$file.FullName)
  $target=Join-Path $installed $relative
  $count++
  if(!(Test-Path -LiteralPath $target) -or (Get-FileHash -LiteralPath $file.FullName).Hash -ne (Get-FileHash -LiteralPath $target).Hash){$mismatches+=($item[0]+'/'+$relative)}
 }
}
$result=@{pass=$mismatches.Count -eq 0;files=$count;mismatches=$mismatches;verified_at=[DateTime]::UtcNow.ToString('o')}
$result | ConvertTo-Json -Depth 3 | Set-Content -LiteralPath (Join-Path $root 'runtime/installed-source-results.json') -Encoding utf8
$result | ConvertTo-Json -Depth 3
if($mismatches.Count){throw 'Installed source mismatch'}
