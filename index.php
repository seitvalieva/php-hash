<?php
    session_start();
    $mdp = "qwwerty123";

    // weak static password hashing
    $md5 = hash('md5', $mdp);
    echo $md5." md5 <br>";

    $sha256 = hash('sha256', $mdp);
    echo $sha256." sha256 <br>";

    // strong dynamic  password hashing
    $hash = password_hash($mdp, PASSWORD_DEFAULT);
    echo $hash." password_default <br>";

    // compare entered password with hashed one
    $input = "qwwerty123";
    $check = password_verify($input, $hash);
    var_dump($check);
    echo "<br>";

    if(password_verify($input, $hash)) {
        $user = "Michael";
        echo "the password is correct"."<br>";
        $_SESSION["user"] = $user;
        echo $user." est connecté";
    } else {
        echo "wrong password";
    }