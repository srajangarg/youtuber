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
				// do the coputation and return
			$url = $_GET["url"];
			$data = array();

			exec("python python/getinfo.py $url", $data);
			// echo will echo on the "loading page", so 1 echo to be used //ithink

			    if(strcmp($data[0],"invalid") == 0)
			    {	
			    	echo '<br><br>
				        <h2 class="header center teal-text">
				          Invalid URL!
				        </h2>
				      <div class="row center">
				        <h5 class="header col s12 light">
				          Try again <a style="color:teal" href="index.html" >here</a>!
				        </h5>
				      </div>';
			    }
			    elseif(strcmp($data[0],"long") == 0)
			    {
	    	    	echo '<br><br>
	    		        <h2 class="header center teal-text">
	    		          Too long!
	    		        </h2>
	    		      <div class="row center">
	    		        <h5 class="header col s12 light">
	    		          Try another song <a style="color:teal" href="index.html" >here</a>!
	    		        </h5>
	    		      </div>';
			    }
			    else
			    {	
			    	$audiourl = $data[0];
			    	$song = $data[1];
			    	$artist = $data[2];
			    	$album = $data[3];
			    	$url1 = $data[4];
			    	$url2 = $data[5];
			    	$url3 = $data[6];

			    	echo '
						<h3 class="header center teal-text">Confirm?</h3>
						<div class="row center">
						  <h5 class="header col s12 light">Edit your tags and choose album-art</h5>
						</div>
						<br>
						<div class="row">
						    <form id ="myform" action = "download.php" class="col s12" method="post">
						      <div class="row">
						        <div class="input-field col s12 l4">
						          <input autocomplete="off" spellcheck="false" autocorrect="off" onchange="validateInput();" onkeyup="validateInput();" onpaste="validateInput();" oninput="validateInput();" id="songname" name="songname" type="text" value="'.$song.'">
						          <label class="active" for="songname">Song Title</label>
						        </div>

						        <div class="input-field col s12 l4">
						          <input autocomplete="off" spellcheck="false" autocorrect="off" id="artistname" name="artistname" type="text" value="'.$artist.'">
						          <label class="active" for="artistname">Artists</label>
						        </div>

						        <div class="input-field col s12 l4">
						          <input autocomplete="off" spellcheck="false" autocorrect="off" id="albumname" name="albumname" type="text" value="'.$album.'">
						          <label class="active" for="albumname">Album</label>
						        </div>
						        <input type="hidden" name="audiourl" value="'.$audiourl.'">
						      </div>   
						      <br>
						      <div class="row">
						          <div class = "col s12 l4 center">
						            <img class ="responsive" src="'.$url1.'" height="70%" width="70%" style="border: 2px solid #26a69a"><br>
						            <input name="imgurl" type="radio" id="test1" value='.$url1.' checked/>
						            <label for="test1">This!</label>
						          </div>
						          <div class = "col s12 l4 center">
						            <img class ="responsive" src="'.$url2.'" height="70%" width="70%" style="border: 2px solid #26a69a"><br>
						            <input name="imgurl" type="radio" id="test2" value='.$url2.' />
						            <label for="test2">No, this!</label>
						          </div>
						          <div class = "col s12 l4 center">
						            <img class ="responsive" src="'.$url3.'" height="70%" width="70%" style="border: 2px solid #26a69a"><br>
						            <input name="imgurl" type="radio" id="test3" value='.$url3.'  />
						            <label for="test3">THISS!</label>
						          </div>
						      </div>
						      <br><br>
						      <div class="row center">
						        <button type="submit" id="submit-button" class="btn waves-effect waves-light teal lighten-1 ">Download <i class="mdi-content-send right"></i></button>
						      </div>
						    </form>
						  </div>
			    	';

			    }
			}

		?>
	</body>
</html>