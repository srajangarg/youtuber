import eyed3, requests, subprocess, os, sys
from unidecode import unidecode

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

data[0] = data[0].strip().decode(sys.stdin.encoding or locale.getpreferredencoding(True))
data[1] = data[1].strip().decode(sys.stdin.encoding or locale.getpreferredencoding(True))
data[2] = data[2].strip().decode(sys.stdin.encoding or locale.getpreferredencoding(True))

fileName = validateFileName(data[0])	# this is the name given by user
print type(data[0])
print data[0]
print fileName
#download(audioURL, fileName, ".m4a")	# downlaod audio

cmd = "./ffmpeg -i 'download/"+fileName+".m4a' -ab 256k 'download/"+fileName+".mp3'"
subprocess.call(cmd, shell=True) # convert m4a to mp3

audiofile = eyed3.load("download/"+fileName +".mp3") # tagging starts
audiofile.initTag(eyed3.id3.ID3_V2_3)

audiofile.tag.artist = data[1]			# artist
audiofile.tag.title = data[0]				# title
audiofile.tag.album = data[2]				# album

imagedata = requests.get(data[3]).content

imgformat = data[3].split(".")[-1].lower()
if imgformat == "png":
	audiofile.tag.images.set (3, imagedata, "image / png")
else:
	audiofile.tag.images.set (3, imagedata, "image / jpeg")
audiofile.tag.save()

print fileName