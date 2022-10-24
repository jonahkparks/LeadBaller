$files = Import-Csv "C:\Users\Jonah\Desktop\GCloudList.csv"

#This command finds and replaces old video names with new video names
foreach($file in $files) {
    Rename-Item {$file."Output Video Name" + ".mp4"} {$file."New Video ID" + ".mp4"}
}

#This command finds and replaces old image names with new image names
foreach($file in $files) {
    Rename-Item {$file."Output Video Name" + ".png"} {$file."New Video ID" + ".png"}
}

echo $file.'Output Video Name' + ".png"