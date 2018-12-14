<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" text="html/css" href="styles.css">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="functions.js"></script>
    <?php include 'functions.php'; ?>
    <title>NoserYoung Noten-Tool</title>
    <meta charset="utf-8">
</head>

    <body>

        <div class="container-fluid">

            <!--------------------------------NAVBAR-------------------------->
            <div class="koerper">
                <img src="bilder/Logo.JPG">
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="berufsbildner.php">Module eintragen</a></li>
                    <li><a class="active" href="">Noten eintragen</a></li>
                </ul>
            </div>

            <!------------------------------------FORMULAR------------------->
            <div class="container">
                <h2>Formular zum eintragen der Modulnote</h2>
                <form action="addGrade.php" method="post">
                    <div class="form-group">
                        <label for="modulname">Modulname:</label>
                        <input type="text" class="form-control" id="modulname" placeholder="Trage den Modulnamen ein" name="modulname">
                    </div>
                    <div class="form-group">
                        <label for="vorname">Vorname:</label>
                        <input type="text" class="form-control" id="vorname" placeholder="Trage deinen Vornamen ein" name="vorname">
                    </div>
                    <div class="form-group">
                        <label for="nachname">Nachname:</label>
                        <input type="text" class="form-control" id="nachname" placeholder="Trage deinen Nachnamen ein" name="nachname">
                    </div>
                    <div class="form-group">
                        <label for="note">Note:</label>
                        <input type="text" class="form-control" id="note" placeholder="Trage deine Note ein" name="note">
                    </div>
                    <button type="submit" class="btn btn-primary">Eintragen</button>
                </form>
            </div>

            <!-------------------------------FOOTER------------------------------------------>
            <br>
            <br>
            <br>
            <footer class="footer">
                © Copyright by Larissa Bosshard & Severin Weigold
            </footer>

        </div>

    </body>
</html>