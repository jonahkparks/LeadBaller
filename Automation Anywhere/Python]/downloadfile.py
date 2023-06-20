import requests
import requests
import re

def DownloadVideo(arg):
    f = open('/Users/jeremylahners/Downloads/output.txt', 'w')
    f.write('Execution Start\n')
    f.write('Input Path: ' + arg[r'path'] + '\n')
    f.write('Video URL: ' + arg[r'video_url'] + '\n')

    video_file_name = re.search("[a-zA-Z0-9]{15,}\/(.*)\?", arg[r'video_url'])
    f.write('Video File Name: ' + video_file_name.group(1))
    f.close()

    r = requests.get(arg[r'video_url'], allow_redirects=True)
    open(arg[r'path'] + video_file_name.group(1) + '.mp4', 'wb').write(r.content)
    
    
#url = 'https://storage.googleapis.com/shakr-videos-lime/2023/06/18/d20ed51ce3f6f3b42208b6f14bab5dbae4ae69df02e793c7557e7c8ff2bffcaf/990d90?Expires=1687783813&GoogleAccessId=storage-accessor%40shakr-infra-stag.iam.gserviceaccount.com&Signature=PkwAS%2BaUQRzZGupAmhde9OfFeS8ale8BRR9dcjrm16DpNtfZJ1rnoGlplWGZbaj3z%2BMJtGGHlWJjVjUtzuD3D29aFTUkHuHySbkLiJFeHuk4eCukvd5ucARaFHmg3RX7oNBi9RTaOXd%2FWvdDvEfx6UMmRomQki3RyScOSQ%2F5h4ItFgrT6I1sJxS%2FHngj5Oeptt%2FzSEmnih7XfJUXXILKNdIS8kD4v0Xu1AVbrbZ46QKGwottvarUaSYMaR4yQOZeDaxmwJuD5h08oh61USNH4jGYnkc8wu2gIBTgTc2qlOCEKIvz%2F19h6I7tjbhARAPfgwg9R0hQv91umYbNZk6g2A%3D%3D'
#video_file_name = '990d90.mp4'
Path = '/users/jeremylahners/Downloads/'
VideoURL = 'https://storage.googleapis.com/shakr-videos-lime/2023/06/18/d20ed51ce3f6f3b42208b6f14bab5dbae4ae69df02e793c7557e7c8ff2bffcaf/990d90?Expires=1687783813&GoogleAccessId=storage-accessor%40shakr-infra-stag.iam.gserviceaccount.com&Signature=PkwAS%2BaUQRzZGupAmhde9OfFeS8ale8BRR9dcjrm16DpNtfZJ1rnoGlplWGZbaj3z%2BMJtGGHlWJjVjUtzuD3D29aFTUkHuHySbkLiJFeHuk4eCukvd5ucARaFHmg3RX7oNBi9RTaOXd%2FWvdDvEfx6UMmRomQki3RyScOSQ%2F5h4ItFgrT6I1sJxS%2FHngj5Oeptt%2FzSEmnih7XfJUXXILKNdIS8kD4v0Xu1AVbrbZ46QKGwottvarUaSYMaR4yQOZeDaxmwJuD5h08oh61USNH4jGYnkc8wu2gIBTgTc2qlOCEKIvz%2F19h6I7tjbhARAPfgwg9R0hQv91umYbNZk6g2A%3D%3D'
ArgList = {
    "path": Path,
    "video_url": VideoURL
}
DownloadVideo(ArgList)