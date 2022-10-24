$files = Import-Csv -Path "C:\Users\Jonah\Desktop\GCloudList.csv"

#This command finds and replaces old video names with new video names
foreach($file in $files) {
    Rename-Item -Path {$file."Output Video Name" + ".mp4"} -NewName {$file."New Video ID" + ".mp4"}
}

#This command finds and replaces old image names with new image names
foreach($file in $files) {
    Rename-Item -Path {$file."Output Video Name" + ".png"} -NewName {$file."New Video ID" + ".png"}
}
