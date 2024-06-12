<?php

    if(isset($_GET["action"])){         // verifier que l action est defini
        switch($_GET["action"]) {

            case "register":
                $pdo = new PDO("mysql:host=localhost;dbname=php_hash_sev;charset=utf8", "root", "");

                $pseudo =  filter_input(INPUT_POST, "pseudo", FILTER_SANITIZE_FULL_SPECIAL_CHARS);     // name attribute of the same input field
                $email =  filter_input(INPUT_POST, "email", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_VALIDATE_EMAIL); // FILTERING the inputs of corresponding fields of reg form
                $password =  filter_input(INPUT_POST, "password1", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $password2 =  filter_input(INPUT_POST, "password2", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                if($pseudo && $email && $password && $password2){
                    // var_dump("ok"); die;

                    $requete = $pdo->prepare("
                        SELECT *
                        FROM user
                        WHERE email = :email
                    ");
                    $requete->execute(["email" => $email]);
                }


            break;
        }
    }  