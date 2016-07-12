import eyed3, requests, subprocess, os, sys

def validateFileName(string):
	string = string.replace("?","")
	string = string.replace("<","")
	string = string.replace(">","")
	string = string.replace(":","")
	string = string.replace("|","")
	string = string.replace("\n","")
	string = string.replace("\t","")
	string = string.replace("/","")
	string = string.replace("'","")
	string = string.replace('"',"")
	return string
def download(url,name,filetype):

	s = requests.session()
	with open("download/" +name + filetype, 'wb') as handle:
		response = s.get(url, stream=True)
			
		if not response.ok:
			print ('Something went wrong')

		for block in response.iter_content(1024):
			if not block:
				break		
			handle.write(block)
	return

audioURL = sys.argv[1]
data = sys.argv[2:6]

fileName = validateFileName(data[0].strip())	# this is the name given by user
download(audioURL, fileName, ".m4a")	# downlaod audio

cmd = "ffmpeg -i 'download/"+fileName+".m4a' -ab 256k 'download/"+fileName+".mp3'"
subprocess.call(cmd, shell=True) # convert m4a to mp3

audiofile = eyed3.load("download/"+fileName +".mp3") # tagging starts
audiofile.initTag(eyed3.id3.ID3_V2_3)

audiofile.tag.artist = unicode(data[1].strip())		# artist
audiofile.tag.title = unicode(data[0].strip())				# title
audiofile.tag.album = unicode(data[2].strip())				# album
try:
	imagedata = requests.get(data[3]).content

	imgformat = data[3].split(".")[-1].lower()
	if imgformat == "png":
		audiofile.tag.images.set (3, imagedata, "image / png")
	else:
		audiofile.tag.images.set (3, imagedata, "image / jpeg")
except:
	pass
audiofile.tag.save()
print fileName