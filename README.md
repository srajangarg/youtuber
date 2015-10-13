# youtuber-php
A Python/PHP powered Web App to download YouTube videos with all the metadata (ID3 Tags)

This version of the website is for local usage. 

# Dependencies

* Python 2.7
* beautifulsoup4 ( $ pip install beautifulsoup4 )
* pafy           ( $ pip install pafy )
* requests       ( $ pip install requests )
* Any PHP based server (eg. Apache2)

# Motivation

# Some notes

# Usage

Simply run your PHP server in the main directory.

index.html page:
![GitHub Logo](/images/index.png)
Currently, the music video can only be 480 seconds long. If you want to change this, edit the file :
```python
# python/getinfo.py

if(currVid.length > 480):
	print "long"
	exit()
```

On entering the URL:
![GitHub Logo](/images/confirm.png)
The script will automatically try and fetch the best possible song information and album art. You can always, manually change them if there are inconsistencies.

On downloading:
![GitHub Logo](/images/dl.png)
Your file is automatically being downloaded in the /download folder of the main directory. The app prompts when the download is complete!