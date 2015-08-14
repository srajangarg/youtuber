# -*- coding: utf-8 -*- 

# this script takes url of video as input
# writes to 'info.txt'
# song/title name
# artist name
# 3 lines of imgurls
# audio url

import requests, os, pafy, re, sys, urllib2
from urlparse import urlparse
from bs4 import BeautifulSoup

def removePercent(string):

	while string.find("%25")!= -1:
		string=string.replace("%25","%")

	return string
def simplify(string):
	if string == "":
		return string

	string = string.replace('"',"")
	string = string.replace("'","")
	
	tobe = ["Official", "Music", "Video", "Original", "Audio", "AUDIO", "Lyric", "OUT", "NOW"]
	for phrase in tobe:
		string = string.replace(phrase, "")

	string = re.sub(r'\([^)]*\)', '', string)
	string = re.sub(r'\[[^)]*\]', '', string)

	string = string.strip()

	return string
def extractFeatandRemix(string):

	feats = ["feat", " ft ", "ft.", "Ft.", "Feat.", "with"]
	endings = ["(", ")", "[", "]", "-", '"', "'"]

	featString = "none"
	featTypeR = "none"
	remixString = "none"

	for featType in feats:

		indexFound = string.find(featType)

		if indexFound != -1:

			i = indexFound
			while i < len(string):
				if string[i] in endings:
					break
				i = i + 1

			featString = string[indexFound : i].strip()
			featTypeR = featType	
			
	indexFound = string.find("Remix")

	if indexFound != -1:
		i = indexFound
		while i > 0:
			if string[i] in endings:
				break
			i = i - 1

			remixString = "(" + string[i + 1: indexFound + len("Remix")].strip() + ")"

	return (featString, featTypeR, remixString)
def getNames(string):

	(featString, featTypeR, remixString) = extractFeatandRemix(string)
	string = simplify(string)

	if "-" in string:
		dashIndex = string.find("-")
		artist = string[0 : dashIndex].strip()

		if featString == "none":
			song = string[dashIndex + 1 : len(string)].strip()
		else:

			if string.find(featTypeR) != -1:

				if dashIndex < string.find(featTypeR):
					song = string[dashIndex + 1 : string.find(featTypeR)]
					song = song.strip() +" "+ featString
				else:
					song = string[dashIndex + 1 : len(string)].strip()
					
			else:
				song = string[dashIndex + 1 : len(string)].strip() +" "+ featString

		if remixString != "none":
			song = song +" "+ remixString
		
		return (song, artist)

	else:
		if remixString == "none":
			return (string,"")
		else:
			return (string +" "+ remixString,"")
def getImageURLs(songName, artistName):

	searchTerm = songName +" "+ artistName + " album art"
	searchTerm = simplify(searchTerm)
	searchTerm = urllib2.quote(searchTerm)
	s = requests.session()
	searchURL = "https://www.google.co.in/search?q="+searchTerm+"&espv=2&biw=1536&bih=758&tbm=isch&source=lnt&tbs=isz:ex,iszw:500,iszh:500"

	headers = {'User-Agent': 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:20.0) Gecko/20100101 Firefox/20.0'}
	page = s.get(searchURL, headers=headers)
	soup = BeautifulSoup(page.content, "html.parser")
	box = soup.find(id = "rg_s")

	i = 1
	imgURLs = []
	while len(imgURLs) < 3 :

		URL = box.contents[i].find("a").get("href")

		rurl = urlparse(URL)
		aurl = rurl.query.split("&")[0].replace("imgurl=","")
		aurl = removePercent(aurl)

		if aurl.endswith(".png") or aurl.endswith(".jpg") or aurl.endswith(".jpeg") or aurl.endswith(".PNG") or aurl.endswith(".JPG"):
			if "tumblr" not in aurl:
				imgURLs.append(aurl)

		i = i+3

	return imgURLs
def getAlbum(songName, artistName):

	searchTerm = songName +" "+ artistName + " album art"
	searchTerm = simplify(searchTerm)
	searchTerm = searchTerm.replace("#","")
	searchTerm = searchTerm.replace("&"," ")
	searchTerm = searchTerm.replace(" ","+")
	s = requests.session()
	searchURL = "https://www.google.co.in/search?q=" + searchTerm

	headers = {'User-Agent': 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:20.0) Gecko/20100101 Firefox/20.0'}
	page = s.get(searchURL, headers=headers)
	soup = BeautifulSoup(page.content, "html.parser")
	box = soup.find(id = "rg_s")
	albumname=""
	a_s = soup.find_all("a")
	for a in a_s:
	    
	    link = a.get("href")
	    try:
	        if "wikipedia" in link:
	            
	            newpage = s.get(link)
	            soup = BeautifulSoup(newpage.content)
	            trs = soup.select("tr.description")
	            if len(trs)==1:
	                albumname="Single"
	            else:
	                albumname=trs[1].find("a").text
	            break
	    except:
	        pass

	return albumname
# read the URL sent by PHP
vidURL = sys.argv[1]
try:
	currVid = pafy.new(vidURL)
except:
	print "invalid"
	exit()

if(currVid.length > 480):
	print "long"
	exit()

vidURL = currVid.getbestaudio().url
title = currVid.title.encode('utf-8').strip()
songName, artistName = getNames(title)
imgURLs = getImageURLs(songName, artistName)
albumName = getAlbum(songName, artistName)

print vidURL
print songName
print artistName
print albumName
print imgURLs[0]
print imgURLs[1]
print imgURLs[2]
