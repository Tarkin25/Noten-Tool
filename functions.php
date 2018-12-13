<?php

    function connect() {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "mydb";

        // Create connection
        if(!isset($Globals['conn'])) $GLOBALS['conn'] = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($GLOBALS['conn']->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        else {
            echo "<script>alert('Connection established successfully');</script>";
        }
    }

    function disconnect() {
        if(isset($GLOBALS['conn'])) {
            $GLOBALS['conn']->close();
            echo "<script>alert('Connection closed successfully');</script>";
        }
        else {
            echo "<script>alert('No open connection available to close');</script>";
        }
    }

    function addModule() {
        connect();

        if(validateModule() == true) {
            $nummer = $_POST['modulnummer'];
            $mname = $_POST['modulname'];
            $datum = $_POST['durchführungsdatum'];
            $vorname = $_POST['vorname'];
            $nachname = $_POST['nachname'];
            $email = $_POST['email'];

            //insert validated data into the table "module"
            $sql = "INSERT INTO module (ModulNummer, ModulName, Datum, VornameLeiter, NachnameLeiter, eMailLeiter) VALUES('$nummer', '$mname', '$datum', '$vorname', '$nachname', '$email')";

            if($GLOBALS['conn']->query($sql) === TRUE) {
                echo "<script>alert('Modul erfolgreich erfasst');</script>";
            } else {
                //exit;
            }

            //create a new table called '[modulname]' for later record of students' grades
            $sql2 = "CREATE TABLE `{$mname}` (vorname TEXT, nachname TEXT, note INT )";

            if($GLOBALS['conn']->query($sql2) == TRUE) {
                echo "<script>alert('Notentabelle für das Modul $mname erfolgreich erstellt');</script>";
            }
            else {
                //exit;
            }

            //send a mail with the module's data to the teacher
            $msg = "Modulnummer: $nummer<br>Modulname: $mname<br>Durchführungsdatum: $datum<br>Vorname Kursleiter: $vorname<br>Nachname Kursleiter: $nachname";
            $msg = wordwrap($msg, 70);

            mail($email, "Durchführung Modul $nummer", $msg);
            
            echo "<h3>Mail an den Kursleiter</h3><p>Durchführung Modul $nummer</p><p>$msg</p>";
        }

        else {
            echo "<script>alert('Fehler: Das Modul konnte nicht erfasst werden');</script>";
        }
    }

    function validateModule() {
        $validated = true;

        //check if all the required fields have been filled with data
        if(isset($_POST['modulnummer']) && isset($_POST['modulname']) && isset($_POST['durchführungsdatum']) && isset($_POST['vorname']) && isset($_POST['nachname']) && isset($_POST['email'])) {

            //validate the format of all the given inputs
            
            if(!preg_match("/\d+/", $_POST['modulnummer'])) {
                echo "<script>alert('Fehleingabe: Die Modulnummer darf nur aus Zahlen bestehen und muss mindestens eine Ziffer lang sein');</script>";
                $validated = false;
            }
            
            if(!preg_match("/[a-zA-Z0-9]+/", $_POST['modulname'])) {
                echo "<script>alert('Fehleingabe: Der Modulname darf nur Gross- und Kleinbuchstaben oder Zahlen enthalten und muss mindestens ein Zeichen lang sein');</script>";
                $validated = false;
            }

            if(!preg_match("/[a-zA-Z]+/", $_POST['vorname'])) {
                echo "<script>alert('Fehleingabe: Der Name des Kursleiters darf nur aus Gross- und Kleinbuchstaben bestehen und muss mindestens ein Zeichen lang sein');</script>";
                $validated = false;
            }

            if(!preg_match("/[a-zA-Z]+/", $_POST['nachname'])) {
                echo "<script>alert('Fehleingabe: Der Nachname des Kursleiters darf nur aus Gross- und Kleinbuchstaben bestehen und muss mindestens ein Zeichen lang sein');</script>";
                $validated = false;
            }

            /*if(!preg_match("/[\w\d\.]*[a-zA-Z\d]{1}@([\w\d]\.){1,}[a-zA-Z]{2-6}/", $_POST['email'])) {
                echo "<script>alert('Fehleingabe: Die e-Mail Adresse muss ein gültiges Format haben');</script>";
                $validated = false;
            }*/
        }

        //if not, display error message
        else {
            echo "<script>alert('Fehleingabe: Es müssen alle Felder ausgefüllt werden');</script>";
            $validated = false;
        }

        return $validated;
    }

?>