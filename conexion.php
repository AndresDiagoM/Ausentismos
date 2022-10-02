<?php
    $host = "localhost";
    $user = "root";//"u715763332_admin";
    $pw   = "";//"Lab4unicauca";
    $db   = "ausentismos_v1";// "u715763332_db_biodigester";  "db_biodigester"

    $conectar = mysqli_connect($host, $user, $pw, $db);

    //HEROKU: 
    //mysql://bd5b665eca0324:a57ba49d@us-cdbr-east-06.cleardb.net/heroku_0ede410b33699d1?reconnect=true

    /*$host = "us-cdbr-east-06.cleardb.net";
    $user = "bd5b665eca0324";//"u715763332_admin";
    $pw   = "a57ba49d";//"Lab4unicauca";
    $db   = "heroku_0ede410b33699d1";

    $conectar = mysqli_connect($host, $user, $pw, $db);*/
?>