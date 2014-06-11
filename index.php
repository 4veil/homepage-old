<?php 
error_reporting(E_ALL ^ E_NOTICE); // hide all basic notices from PHP

//If the form is submitted
if(isset($_POST['submitted'])) {
  
  // require a name from user
  if(trim($_POST['contactName']) === '') {
    $nameError =  'Forgot your name!'; 
    $hasError = true;
  } else {
    $name = trim($_POST['contactName']);
  }
  
  // need valid email
  if(trim($_POST['email']) === '')  {
    $emailError = 'Forgot to enter in your e-mail address.';
    $hasError = true;
  } else if (!preg_match("/^[[:alnum:]][a-z0-9_.-]*@[a-z0-9.-]+\.[a-z]{2,4}$/i", trim($_POST['email']))) {
    $emailError = 'You entered an invalid email address.';
    $hasError = true;
  } else {
    $email = trim($_POST['email']);
  }
    
  // we need at least some content
  if(trim($_POST['comments']) === '') {
    $commentError = 'You forgot to enter a message!';
    $hasError = true;
  } else {
    if(function_exists('stripslashes')) {
      $comments = stripslashes(trim($_POST['comments']));
    } else {
      $comments = trim($_POST['comments']);
    }
  }
    
  // upon no failure errors let's email now!
  if(!isset($hasError)) {
    
    $emailTo = 'me@danbrownlow.co.uk';
    $subject = 'Submitted message from '.$name;
    $sendCopy = trim($_POST['sendCopy']);
    $body = "Name: $name \n\nEmail: $email \n\nComments: $comments";
    $headers = 'From: ' .' <'.$emailTo.'>' . "\r\n" . 'Reply-To: ' . $email;

    mail($emailTo, $subject, $body, $headers);
        
        // set our boolean completion value to TRUE
    $emailSent = true;
  }
}
?>

<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Daniel Brownlow // Hello</title>
    <link rel="stylesheet" href="css/app.css" />
    <script src="bower_components/modernizr/modernizr.js"></script>
  </head>
  <body>

    <!-- Begin Hero -->
    <section id="hero-panel">
      <div class="row">
        <div class="large-12 columns">
          <div class="title-container">
              <h1 class="heading">Daniel Brownlow</h1>
              <h2 class="subheading">Hi, I'm a Web Designer and Developer based in England.</h2>
          </div>
        </div>
      </div>
    </section>
    <!-- End Hero -->

    <!-- Begin About -->
    <section id="about">
      <div class="row">
        <div class="large-12 columns">
          <h3>About Me</h3>
        </div>
      </div>

      <div class="row">
        <div class="large-12 columns">
          <p class="about-text">I'm currently a web designer working at .... I enjoy creating sites that are accessible and clean using a variety of web technologies.</p>
        </div>
      </div>
    </section>
    <!-- End About -->

    <!-- Begin Featured -->
    <section id="featured">
      <div class="row">
        <div class="large-12 columns">
        </div>
      </div>

      <div class="row">
        <div class="large-4 medium-4 columns" id="gallery">
          <img class="circular" src="http://lorempixel.com/300/200/sports">
        </div>

        <div class="large-4 medium-4 columns" id="gallery">
          <img class="circular" src="http://lorempixel.com/300/200/animals">
        </div>

        <div class="medium-4 large-4 columns" id="gallery">
          <img class="circular" src="http://lorempixel.com/300/200/food">
        </div>
    </section>
    <!-- End Featured -->

    <!-- Begin Skills -->
    <section id="skills">
      <div class="row">
        <div class="large-12 columns">
          <h3>Skills</h3>
        </div>
      </div>

      <div class="row">
        <div class="large-12 columns">
          <p>HTML</p>
          <p>CSS</p>
          <p>Javascript / jQuery</p>
          <p>PHP</p>
          <p>Search Engine Optimisation</p>
          <p>Photoshop</p>
        </div>
      </div>
    </section>
    <!-- End Skills -->

    <!-- Begin Contact -->
    <section id="contact-section">
      <div class="row">
        <div class="large-12 columns">
          <h3>Get in touch</h3>
        </div>

      <div class="large-12 columns">

        <!-- @begin contact -->
        <div id="contact">
          <div class="container content">
          
                <?php if(isset($emailSent) && $emailSent == true) { ?>
                      <p class="info">Your email was sent. Huzzah!</p>
                  <?php } else { ?>
                  
              
              <div id="contact-form">
                <?php if(isset($hasError) || isset($captchaError) ) { ?>
                              <p class="alert">Error submitting the form</p>
                          <?php } ?>
              
                <form id="contact-us" action="index.php" method="post">
                  <div class="formblock">
                    <input type="text" name="contactName" id="contactName" value="<?php if(isset($_POST['contactName'])) echo $_POST['contactName'];?>" class="txt requiredField" placeholder="Name:" />
                    <?php if($nameError != '') { ?>
                      <br /><span class="error"><?php echo $nameError;?></span> 
                    <?php } ?>
                  </div>
                              
                  <div class="formblock">
                    <input type="text" name="email" id="email" value="<?php if(isset($_POST['email']))  echo $_POST['email'];?>" class="txt requiredField email" placeholder="Email:" />
                    <?php if($emailError != '') { ?>
                      <br /><span class="error"><?php echo $emailError;?></span>
                    <?php } ?>
                  </div>
                              
                  <div class="formblock">
                     <textarea name="comments" id="commentsText" class="txtarea requiredField" placeholder="Message:"><?php if(isset($_POST['comments'])) { if(function_exists('stripslashes')) { echo stripslashes($_POST['comments']); } else { echo $_POST['comments']; } } ?></textarea>
                    <?php if($commentError != '') { ?>
                      <br /><span class="error"><?php echo $commentError;?></span> 
                    <?php } ?>
                  </div>
                              
                    <button name="submit" type="submit" class="subbutton">Send</button>
                    <input type="hidden" name="submitted" id="submitted" value="true" />
                </form>     
              </div>
              
            <?php } ?>
          </div>
          </div><!-- End #contact -->
      </div>
      </div>
    </section>

    <!-- End Contact -->
    <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <script src="js/app.js"></script>

    <script type="text/javascript">
      <!--//--><![CDATA[//><!--
      $(document).ready(function() {
        $('form#contact-us').submit(function() {
          $('form#contact-us .error').remove();
          $(this).addClass('inputError');
          $('.requiredField').css("outline", "#fff");
          $('.requiredField').css("box-shadow", "#fff");
          $('.requiredField').css("border-color", "#fff");
          var hasError = false;
          $('.requiredField').each(function() {
            if($.trim($(this).val()) == '') {
              var labelText = $(this).prev('label').text();
              // $(this).parent().append('<span class="error">Your forgot to enter your '+labelText+'.</span>');
              $(this).addClass('inputError');
              $(this).css("outline", "#FF6666");
              $(this).css("box-shadow", "0px 0px 7px #FF6666");
              $(this).css("border-color", "#FF6666");


              hasError = true;
            } else if($(this).hasClass('email')) {
              var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
              if(!emailReg.test($.trim($(this).val()))) {
                var labelText = $(this).prev('label').text();
                // $(this).parent().append('<span class="error">Sorry! You\'ve entered an invalid '+labelText+'.</span>');
                $(this).addClass('inputError');
                hasError = true;
              }
            }
          });

          if(!hasError) {
            var formInput = $(this).serialize();
            $.post($(this).attr('action'),formInput, function(data){
              $('form#contact-us').slideUp("fast", function() {          
                $(this).before('<p class="tick"><strong>Thank you, I\'ll get back to you shortly</p>');

              });
            });
          }
          
          return false; 
        });
      });
      //-->!]]>
    </script>
  </body>
</html>
