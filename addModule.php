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
                    <li><a href="">Home</a></li>
                    <li><a class="active" href="">Module eintragen</a></li>
                    <li><a href="">Noten eintragen</a></li>
                </ul>
            </div>

            <!------------------------------------FORMULAR------------------->
            <div class="container">
                <p id="message">Loading...</p>
            </div>

            <script>
                function toIndex() {
                    window.location.href = "index.php";
                }
                function toBerufsbildner() {
                    window.location.href = "berufsbildner.php";
                }
            </script>

            <?php addModule(); ?>

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

