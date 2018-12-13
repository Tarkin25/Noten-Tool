<!DOCTYPE html>
<html lang="de">

    <head>
        <link rel="stylesheet" text="html/css" href="styles.css">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
        <?php include 'functions.php'; ?>
        <script src="functions.js"></script>

        <title>NoserYoung Noten-Tool</title>
    </head>

    <body>

        <?php
            if(isset($_POST['submit'])) showGrades();
        ?>
        
        <div class="container">
            <form action="home.php" method="post">
                <label for="vorname">Vorname: </label><input type="text" name="vorname"><br>
                <label for="nachname">Nachname: </label><input type="text" name="nachname"><br>
                <input class="btn btn-primary" type="submit" value="Suchen" id="studentGrades" name="submit">
            </form>
        </div>

        <div class="container">
            <div id="modules">
                <?php showModules(); ?>
            </div>
            <button id="moduleButton" class="btn btn-primary" onclick="displayModules()">Alle Module anzeigen</button>
        </div>

    </body>

</html>