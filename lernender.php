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

<!-- Formular start-->
<div class="container">
    <h2>Formular zum eintragen der Modulnote</h2>
    <form action="/action_page.php">
        <div class="form-group">
        <label for="modulnummer">Modulnummer:</label>
        <input type="modulnummer" class="form-control" id="modulnummer" placeholder="Trage die Modulnummer ein" name="modulnummer">
        </div>
        <div class="form-group">
        <label for="modulname">Modulname:</label>
        <input type="modulname" class="form-control" id="modulname" placeholder="Trage die Modulname ein" name="modulname">
        </div>
        <div class="form-group">
        <label for="durchführungsdatum">Durchführungsdatum:</label>
        <input type="durchführungsdatum" class="form-control" id="durchführungsdatum" placeholder="Trage das Durchführungsdatum ein" name="durchführungsdatum">
        </div>
        <div class="form-group">
        <label for="vorname">Vorname:</label>
        <input type="vorname" class="form-control" id="vorname" placeholder="Trage deinen Vornamen ein" name="vorname">
        </div>
        <div class="form-group">
        <label for="nachname">Nachname:</label>
        <input type="nachname" class="form-control" id="nachname" placeholder="Trage deinen Nachnamen ein" name="nachname">
        </div>
        <div class="form-group">
        <label for="note">Note:</label>
        <input type="note" class="form-control" id="note" placeholder="Trage deine Note ein" name="note">
        </div>
        <button type="submit" class="btn btn-primary">Eintragen</button>
    </form>
    </div>
<!-- Formular ende -->
</body>
</html>