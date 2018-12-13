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
        
        <div class="container">
            <form action="home.php" method="post">
                <label for="modulname">Modulname: </label><input type="text" name="modulname"><br>
                <input class="btn btn-primary" type="submit" value="Noten des Moduls anzeigen" name="grades">
            </form>

            <?php
                if(isset($_POST['grades'])) {
                    showGrades();
                }
            ?>
        </div>

        <div class="container">

            <form class="form" action="home.php" method="post">
                <input class="btn btn-primary" type="submit" value="Module anzeigen" name="modules">
            </form>

            <?php
                if(isset($_POST['modules'])) showModules();
            ?>
        </div>

    </body>

</html>