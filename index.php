<?php
    
    $mdp = "qwwerty123";

    // weak static password hashing
    $md5 = hash('md5', $mdp);
    echo $md5." md5 <br>";

    $sha256 = hash('sha256', $mdp);
    echo $sha256." sha256 <br>";

    // strong dynamic  password hashing
    $hash = password_hash($mdp, PASSWORD_DEFAULT);
    echo $hash." password_default <br>";