<?php
	if(isset($_GET['q']))
	{
		$name = urldecode($_GET['q']);
		$File = "download/".$name.".mp3";
		$File2  = "download/".$name.".m4a";

		if(file_exists($File))
		{
			header("Content-Disposition: attachment; filename='".$name.".mp3'");
			header("Content-Type: audio/mpeg");
			header("Content-Length: " . filesize($File));
			header("Connection: close");
			readfile($File);

			sleep(3);
			unlink($File2);
			unlink($File);
		}
	}
?>