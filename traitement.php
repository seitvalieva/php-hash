<?php

    session_start();

    if(isset($_GET["action"])){         // verifier que l'action est defini
        switch($_GET["action"]) {

            case "register":

                // if the form is submitted 
                if($_POST["submit"]) {

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
                            } else {
    
                                // message "The password is short"
    
                            }
                        }
                    } else {
                        // probleme de saisie dans les champs de formulaire
                    }
                }
                header("Location: register.php"); exit;
            break;


           case "login":

                if($_POST["submit"]){
                    // connection to the app
                    $pdo = new PDO("mysql:host=localhost;dbname=php_hash_sev;charset=utf8", "root", "");
                    
                    $email =  filter_input(INPUT_POST, "email", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_VALIDATE_EMAIL); // FILTERING the inputs of corresponding fields of reg form
                    $password =  filter_input(INPUT_POST, "password1", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                    // si les filtres sont valides
                    if($email && $password){
                        $requete = $pdo->prepare("
                            SELECT *
                            FROM user
                            WHERE email = :email
                        ");
                        $requete->execute(["email" => $email]);
                        $user = $requete->fetch();
                        // var_dump($user); die;

                        if($user){                          // if user exists in db
                            $hash = $user["password"];      // get password from db
                            if(password_verify($password, $hash)) {         // verify that entered password is correct 

                                 $_SESSION["user"] = $user;                    // session is open and user is connected

                                 header("Location: home.php"); exit; //"Location: index.php?ctrl=home&action=index.php&id=" for mvc structure
                            } else {
                                header("Location: login.php"); exit;
                                // message utilisateur inconnu ou mdp incorrect
                            }
                        } else {
                            // message utilisateur inconnu ou mdp incorrect
                            header("Location: login.php"); exit;
                        }

                    }

                }

                header("Location: login.php"); exit;


            break;


            case "logout":
                // connection to the app

            break;
        }
    }  