# youtuber-php
A Python/PHP powered Web App to download YouTube videos with all the metadata (ID3 Tags)

This version of the website is for local usage. 

# Dependencies

* Python 2.7
* beautifulsoup4 ( $ pip install beautifulsoup4 )
* pafy           ( $ pip install pafy )
* requests       ( $ pip install requests )
* eyed3 ( $ pip install eyeD3 )
* Any PHP based server (eg. Apache2)

# Motivation
I usually downloaded all my music straight from YouTube, using free YouTube MP3 downloader sites. These sites got the job done (sort of). However, these sites just gave the raw mp3 file without any metadata. This led to incomplete music libraries on my phone. Also, the library just looked ugly because of the missing album art.

This inspired me to try and automate this whole process, by which I could get complete mp3 files.

# How it works
* The artist name and song name are cleverly parsed from the YouTube video title. This step takes care of all possible combinations of mixed artists, feat. artists and remixes. However, I've worked on the basic assumption on the base format of **Artist - SongName**. Videos which do not follow this format are usually incorrectly parsed.

* Now using the song name and artist, the script searches for an album on Wikipedia. This step usually fails for not so popular songs.

* The album art is obtained by scraping Google Images using appropriate filters. As this is an automated process, it works best for popular songs!

* The song is downloaded using the pafy library, in m4a format. ffmpeg converts the file to mp3. After this, eyed3 tags the mp3 file for me.

# Usage
Run the following commands to give su powers to www-data:

```bash
$ sudo usermod -aG www-data <rootusernamehere>
$ addgroup www-data
$ sudo chown -R www-data:www-data /var/www/path/to/youtuber
$ sudo chmod -R 775 /var/www/path/to/youtuber
```
After this, simply run your PHP server.

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

# To-do
* Currently, the fields cannot have non-ASCII characters. Have to work on it.
* Ability to supply a playlist link, which downloads the whole playlist.
* On the deployable version, test and fix for different browsers.