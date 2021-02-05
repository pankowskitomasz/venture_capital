<?php

include_once("php/getdata.php");

header("Access-Control-Allow-Origin: *");

DatabaseConnect();
getData();
DatabaseDisconnect();

?>