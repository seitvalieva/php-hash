<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>S'inscrire</h1>
    <form action="traitement.php?action=register" method="POST">
        <label for="pseudo">Pseudo</label>
        <input type="text" name="pseudo" id="pseudo"><br><br>

        <label for="email">Email</label>
        <input type="email" name="email" id="email"><br><br>

        <label for="password">Mot de pass</label>
        <input type="password" name="password1" id="password1"><br><br>

        <label for="password2">Confirmation du mot de passe</label>
        <input type="password" name="password2" id="password2"><br><br>

        <input type="submit" value="S'enregistrer">
    </form>
    
</body>
</html>