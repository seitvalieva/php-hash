<?php

    if(isset($_GET["action"])){         // verifier que l'action est defini
        switch($_GET["action"]) {

            case "register":
                // connection to the database
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

                    $user = $requete->fetch();  // store the result of the request in $user
                    
                    //if user exists
                    if($user) {
                        header("Location: register.php"); exit;         // redirect the user to registration page
                    } else {
                        // var_dump("User doesnt exist"); die;
                        // insert the user in the database

                        if($password == $password2 && strlen($password) >= 8) {     // VERIFY both passwords are identic, and length of the pass min 8
                            
                            $insertUser = $pdo->prepare("
                                INSERT INTO user (pseudo, email, password) 
                                VALUES (:pseudo, :email, :password)
                            ");
                            
                            $insertUser->execute([
                                "pseudo" => $pseudo,
                                "email" => $email,
                                "password" => password_hash($password, PASSWORD_DEFAULT)
                            ]);
                            header("Location: login.php"); exit;        // redirect the user to login page
                        }
                    }
                }


            break;
        }
    }  