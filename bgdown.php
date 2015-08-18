	<!DOCTYPE html>
<html>

	<head>
	  <!--Import materialize.css-->
	  <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>

	  <!--Let browser know website is optimized for mobile-->
	  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

	  <title>YouTuber</title>
	</head>

	<body>

		<?php

			if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest')
			{
				echo
				'
					<div class="section no-pad-bot" id="index-banner">
					    <div class="container">
					      <br><br>
					        <h2 class="header center teal-text">
					          Stop Messing!
					        </h2>
					      <div class="row center">
					        <h5 class="header col s12 light">
					          I think you meant to go <a style="color:teal" href="index.html" >here</a>!
					        </h5>
					      </div>
					    </div>
					</div>
				' ;
			}
			else
			{
				
				// download the file
				$audiourl = $_GET["audiourl"];
				$songname = $_GET["song"];
				$artistname = $_GET["artist"];
				$albumname = $_GET["album"];
				$imgurl = $_GET["imgurl"];

				$myfile = fopen("python/confirm.txt", "w");
				fwrite($myfile,$audiourl."\n");
				fwrite($myfile,$songname."\n");
				fwrite($myfile,$artistname. "\n");
				fwrite($myfile,$albumname. "\n");
				fwrite($myfile,$imgurl. "\n");
				fclose($myfile);

				$data = array();
				exec('python python/downloadandtag.py', $data);
				//system($cmd);
				echo '
						<br><br><br><br>
						  <h1 class="header center teal-text">
						    Done!
						  </h1>
						<div class="row center">
						  <h4 class="header col s12 light">
						    Your file will automatically download!
						  </h4>
						  <h5 class="header col s12 light">
						    Click <a style="color:teal" href="index.html">here</a> to download more!
						  </h5>
						</div>
					<iframe src="send.php?q='.urlencode($data[0]).'" style="display:none;" />
				';	
				// <meta http-equiv="refresh" content="1;url=send.php?q='.$data[0].'">

			}

		?>
	</body>
</html>