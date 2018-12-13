<!DOCTYPE html>
<html lang="de">
    <head>
        <link rel="stylesheet" text="html/css" href="style.css">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
        <?php include 'functions.php'; ?>

        <title>NoserYoung Noten-Tool</title>
    </head>

    <body>

        <script>function backToBerufsbildner() {window.location.href = "berufsbildner.php";}</script>

        <div class="container">
            <p id="message">Loading...</p>
        </div>

        <?php addModule(); ?>

        <div class="container">
            <button class="btn" onclick="backToBerufsbildner()">Zurück zum Eingabeformular</button>
        </div>
    </body>
</html>