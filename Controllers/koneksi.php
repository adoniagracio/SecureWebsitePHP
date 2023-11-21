<?php
    require "db.php";
    
    $db = new mysqli(
        $config["server"],
        $config["username"],
        $config["password"],
        $config["database"]
    );