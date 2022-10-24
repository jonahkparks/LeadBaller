$files = Import-Csv "C:\Users\Jonah\Downloads\CloudList.csv"

$totalFiles = 0

#This command finds and replaces old video names with new video names
foreach($file in $files) {
    $oldFile = $file.EmailUniqueID
    $oldFile += ".mp4"

    $newFile = $file."New Video ID"
    $newFile += ".mp4"

    # Write-Output $oldFile
    # Write-Output $newFile

    if (Test-Path -Path $oldFile) {
        Rename-Item -Path $oldFile -NewName $newFile
        $totalFiles++
    }
}

#This command finds and replaces old image names with new image names
foreach($file in $files) {
    $oldFile = $file.EmailUniqueID
    $oldFile += ".png"

    $newFile = $file."New Video ID"
    $newFile += ".png"

    # Write-Output $oldFile
    # Write-Output $newFile

    if (Test-Path -Path $oldFile) {
        Rename-Item -Path $oldFile -NewName $newFile
        $totalFiles++
    }
}

Write-Output $totalFiles