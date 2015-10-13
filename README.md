# youtuber-php
A Python/PHP powered Web App to download YouTube videos with all the metadata (ID3 Tags)

This version of the website is for local usage. 

# Dependencies

* Python 2.7
* beautifulsoup4 ( $ pip install beautifulsoup4 )
* pafy           ( $ pip install pafy )
* requests       ( $ pip install requests )
* Any PHP based server (eg. Apache2)

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