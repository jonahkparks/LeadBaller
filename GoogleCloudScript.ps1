$files = Import-Csv "C:\Users\Jonah\Desktop\GCloudList.csv"

#This command finds and replaces old video names with new video names
foreach($file in $files) {
    $oldFile = $file.EmailUniqueID
    $oldFile += ".mp4"

    $newFile = $file."New Video ID"
    $newFile += ".mp4"

    # Write-Output $oldFile
    # Write-Output $newFile

    Rename-Item -Path $oldFile -NewName $newFile
}

#This command finds and replaces old image names with new image names
foreach($file in $files) {
    $oldFile = $file.EmailUniqueID
    $oldFile += ".png"

    $newFile = $file."New Video ID"
    $newFile += ".png"

    # Write-Output $oldFile
    # Write-Output $newFile

    Rename-Item -Path $oldFile -NewName $newFile
}
