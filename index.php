<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
        <script src="functions.js"></script>
        <link rel="stylesheet" text="html/css" href="styles.css">
        <?php include 'functions.php'; ?>
        <title>NoserYoung Noten-Tool</title>
    </head>

    <body>

        <div class="jumbotron">

                <!--------------------------------NAVBAR------------------------------------------------------>
                <div class="koerper">
                    <img src="logo.png">
                    <ul>
                        <li><a class="active" href="">Home</a></li>
                        <li><a href="berufsbildner.php">Module eintragen</a></li>
                        <li><a href="lernender.php">Noten eintragen</a></li>
                    </ul>
                </div>

                <!--------------------------------DISPLAY--------------------------------------------->
                <br>
                <br>
                <br>

                <div class="col-md-12">
                    <h2>Modulübersicht</h2>
                    <table>
                        <tr><th>Nummer</th><th>Name</th><th>Datum</th><th>Vorn. Leiter</th><th>Nachn. Leiter</th><th>e-Mail</th></tr>
                        <?php showModules();?>
                    </table>
                </div>

                <div class="col-md-12"><?php if(isset($_POST['grades'])) showGrades(); ?></div>

        </div>

    </body>
</html>