<?php 
  if(!isset($_POST['videourl']))
    $errorfill = true;
  else
    $errorfill = false;
?>

<!DOCTYPE html>
<html>
  <head>
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>

    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <!--Import jQuery before materialize.js-->
    <script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="js/materialize.min.js"></script>
    <title>YouTuber</title>
  </head>

  <body>
    
    <?php if (!$errorfill) : ?>
    
    <div class="section no-pad-bot" id="spinner">
      <div class="container">
      <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
      <div class="row">
        <div class="col s12 l6 offset-l3">
      <div class="progress">
            <div class="indeterminate"></div>
        </div>
        </div>
      </div>
      </div>
    </div>

    <div class="section no-pad-bot" >
        <div class="container"id="index-banner">
        </div>
    </div>

    <script type="text/javascript">
      $(document).ready(function() {

          var url = "<?php echo $_POST['videourl']; ?>";

          $.ajax({
              url: 'infoget.php',
              type: 'GET',
              data: { "url" : url},
              success: function(data) {
                  $('#index-banner').html(data);
                  $('#spinner').hide();
              },
              error: function() {
                  alert("Something went wrong!");
              }
          });
      });

      function validateInput()
      { 

          s = $("#songname").val();

          if( s.length > 0 )
          {
            $("#submit-button").fadeIn(0);
          }
          else
          {
            $("#submit-button").fadeOut();
          }
      }

      $('html').bind('keypress', function(e)
      {
       if(e.keyCode == 13)
       {
          return false;
       }
      });

    </script>

    <?php else : ?>

      <div class="section no-pad-bot" id="index-banner">
          <div class="container">
            <br><br>
              <h2 class="header center teal-text">
                Shucks!
              </h2>
            <div class="row center">
              <h5 class="header col s12 light">
                I think you meant to go <a style='color:teal' href='index.html' >here</a>!
              </h5>
            </div>
          </div>
      </div>
      
      <?php endif ?>
  </body>
</html>