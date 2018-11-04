<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>sos0ry</title>

    <!-- Bootstrap -->

    <link href="css/style.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->

    <script src="js/funcs.js"></script>
  </head>
  <body>
     <video poster="https://pp.userapi.com/c416121/v416121046/7230/nay-9gnguoI.jpg" id="bgvid" playsinline autoplay loop>
  <!-- WCAG general accessibility recommendation is that media such as background video play through only once. Loop turned on for the purposes of illustration; if removed, the end of the video will fade in the same way created by pressing the "Pause" button  -->
<?php
include('config.php');
session_start();
if($_SESSION['auth'] == 'true'){
    print"<script>location.href = '/table.php';</script>";
}
$cf = mysql_fetch_assoc(mysql_query("SELECT `sound` FROM `userinfo` WHERE `id` < 10"));
if($cf['sound'] == 'on')
    echo '<source src="http://a0149298.xsph.ru/video/'.rand(1, 7).'.mp4" type="video/mp4">';
?>
</video>
<div id="login-form">
      <h1>A U T H</h1>
        <fieldset>
            <div style="height: 20px;">
                <div class="alert" id="wrong">
                    <strong>Wrong!</strong>
                </div>
            </div>
            <form method="post" id="auth">
                <input type="text" required name="login" value="LOGIN" onBlur="if(this.value=='')this.value='LOGIN'" onFocus="if(this.value=='LOGIN')this.value='' "> 
                <input type="password" required name="password" value="Пароль" onBlur="if(this.value=='')this.value='Пароль'" onFocus="if(this.value=='Пароль')this.value='' "> 
                <input type="submit" value="E N T E R">
            </form>
        </fieldset>
    </div> 
    <script>
        $("#auth").submit(function(e) {
            var url = "cmd.php"; // the script where you handle the form input.

            $.ajax({
                type: "POST",
                url: url,
                data: $("#auth").serialize(), // serializes the form's elements.
                success: function(data)
                {
                    if(data == 'true')
                        location.href = '/table.php';
                    else
                        err(); // show response from the php script.
                }
                });

            e.preventDefault(); // avoid to execute the actual submit of the form.
        });
    </script>
  </body>
</html>