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
				function escape($stringx)
				{
					str_replace('"','\"',$stringx);
					return $stringx;
				}
				// download the file
				$audiourl = escape($_GET["audiourl"]);
				$songname = escape($_GET["song"]);
				$artistname = escape($_GET["artist"]);
				$albumname = escape($_GET["album"]);
				$imgurl = escape($_GET["imgurl"]);

				$data = array();
				$cmd = 'python python/downloadandtag.py "'.$audiourl.'" "'.$songname.'" "'.$artistname.'" "'.$albumname.'" "'.$imgurl.'"';

				exec($cmd, $data);

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
						<meta http-equiv="refresh" content="1;url=send.php?q='.$data[0].'">
				';	
				// echo will echo on the "loading page - download.php", so 1 echo to be used

			}

		?>
	</body>
</html>