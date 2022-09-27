<?php
    $host = "localhost";
    $user = "root";//"u715763332_admin";
    $pw   = "";//"Lab4unicauca";
    $db   = "ausentismos_v1";// "u715763332_db_biodigester";  "db_biodigester"

    $conectar = mysqli_connect($host, $user, $pw, $db);

    //HEROKU: 
    //mysql://b72abce5b070f7:a7e4abc3@us-cdbr-east-06.cleardb.net/heroku_74472d3d099aefc?reconnect=true

    /*$host = "us-cdbr-east-06.cleardb.net";
    $user = "b72abce5b070f7";//"u715763332_admin";
    $pw   = "a7e4abc3";//"Lab4unicauca";
    $db   = "heroku_74472d3d099aefc";//"u715763332_db_biodigester";

    $conectar = mysqli_connect($host, $user, $pw, $db);*/
?>