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

data = open("python/confirm.txt").read().splitlines()

fileName = validateFileName(data[1])	# this is the name given by user

download(data[0], fileName, ".m4a")	# downlaod audio

cmd = "./ffmpeg -i 'download/"+fileName+".m4a' -ab 256k 'download/"+fileName+".mp3'"
subprocess.call(cmd, shell=True) # convert m4a to mp3

audiofile = eyed3.load("download/"+fileName +".mp3") # tagging starts
audiofile.initTag(eyed3.id3.ID3_V2_3)

audiofile.tag.artist = data[2].decode('utf-8')					# artist
audiofile.tag.title = data[1].decode('utf-8')				# title
audiofile.tag.album = data[3].decode('utf-8')		# album

imagedata = requests.get(data[4].decode('ascii')).content

imgformat = data[4].split(".")[-1].lower()
if imgformat == "png":
	audiofile.tag.images.set (3, imagedata, "image / png")
else:
	audiofile.tag.images.set (3, imagedata, "image / jpeg")
audiofile.tag.save()

print fileName