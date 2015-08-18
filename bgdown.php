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

				if(preg_match('/[^\x20-\x7f]/', $songname) || preg_match('/[^\x20-\x7f]/', $artistname)|| preg_match('/[^\x20-\x7f]/', $albumname))
				{
					echo '
							<br><br><br><br>
							  <h1 class="header center teal-text">
							    Sorry!
							  </h1>
							<div class="row center">
							  <h4 class="header col s12 light">
							    Non ASCII titles aren\'t supported
							  </h4>
							  <h5 class="header col s12 light">
							    Mainly because I\'m lazy.. <a style="color:teal" href="index.html">back</a>
							  </h5>
							</div>
					';
				}

				else
				{
					$data = array();
					$cmd = 'python python/downloadandtag.py "'.$audiourl.'" "'.$songname.'" "'.$artistname.'" "'.$albumname.'" "'.$imgurl.'"';
					//echo $cmd;
					exec($cmd, $data);
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
				}
				
				// <meta http-equiv="refresh" content="1;url=send.php?q='.$data[0].'">

			}

		?>
	</body>
</html>