<?php

    //error_reporting(0);

    function connect() {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "mydb";

        echo '<script>var message = document.getElementById("message");</script>';

        // Create connection
        if(!isset($Globals['conn'])) $GLOBALS['conn'] = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($GLOBALS['conn']->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        else {
            echo '<script>message.innerHTML = "Verbindung zur Datenbank wurde erfolgreich hergestellt<br>";</script>';
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

        $retry = false;

        //only if the form is validated insert data into database and send e-mail to the teacher
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
                 
                echo '<script>message.innerHTML += "Modul erfolgreich erfasst<br>";</script>';
            } else {
                $retry = true;
                echo '<script>message.innerHTML += "Die Daten konnten nicht erfasst werden<br>";</script>';
            }

            //create a new table called '[modulname]' for later record of students' grades
            $sql2 = "CREATE TABLE `{$mname}` (vorname TEXT, nachname TEXT, note DOUBLE )";

            if($GLOBALS['conn']->query($sql2) == TRUE) {
                echo "<script>message.innerHTML += 'Notentabelle für das Modul $mname erfolgreich erstellt<br>';</script>";
            }
            else {
                $retry = true;
                echo "<script>message.innerHTML += 'Es konnte keine Notentabelle für das Modul $mname erstellt werden<br>';</script>";
            }

            //send a mail with the module's data to the teacher
            $msg = "Modulnummer: $nummer<br>Modulname: $mname<br>Durchführungsdatum: $datum<br>Vorname Kursleiter: $vorname<br>Nachname Kursleiter: $nachname";
            $msg = wordwrap($msg, 70);

            if(mail($email, "Durchführung Modul $nummer", $msg)) {
                 
                echo "<script>message.innerHTML += 'E-Mail mit den Kursinformationen wurde erfolgreich an $email gesendet<br>';</script>";
            }
            else {
                 
                echo "<script>message.innerHTML += 'Es konnte keine E-Mail mit Kursinformationen an $email gesendet werden<br>';</script>";
            }
            
            echo "<div class=\"container\"><h3>Mail an den Kursleiter</h3><p>Durchführung Modul $nummer</p><p>$msg</p></div>";
        }

        //if it didn't work, print out an error
        else {
            $retry = true;
            echo "<script>message.innerHTML += 'Fehler: Das Modul konnte nicht erfasst werden<br>';</script>";
        }

        //if something didn't work, return to the form input, else return to the home page
        if($retry == true) {
            echo "<script>setTimeout(function(){document.location.href = 'berufsbildner.php';}, 4000);</script>";
        }
        else {
            echo "<script>setTimeout(function(){document.location.href = 'index.php';}, 4000);</script>";
        }
    }

    function addGrade() {
        connect();

        //only if the form is validated insert data into table
        if(validateGrade() == true) {
            $mname = $_POST['modulname'];
            $vorname = $_POST['vorname'];
            $nachname = $_POST['nachname'];
            $note = $_POST['note'];

            //insert validated data into the table named "[$mname]"
            $sql = "INSERT INTO `{$mname}` (vorname, nachname, note) VALUES('$vorname', '$nachname', '$note')";

            if($GLOBALS['conn']->query($sql) === TRUE) {
                echo "<script>message.innerHTML += \"Note für das Modul $mname erfolgreich erfasst<br>\";</script>";
                echo "<script>document.getElementById('gradeNavigation').style.display = 'none';</script>";
                echo "<script>setTimeout(function(){document.location.href = 'index.php';}, 4000);</script>";
            } else { 
                echo "<script>message.innerHTML += \"Fehler: Note konnte für das Modul $mname nicht erfasst werden<br>\";</script>";
                echo "<script>setTimeout(function(){document.location.href = 'lernender.php';}, 4000);</script>";
            }
        }

        //if it didn't work, print out an error
        else {
            echo "<script>message.innerHTML += 'Fehler: Note konnte nicht erfasst werden<br>';</script>";
            echo "<script>setTimeout(function(){document.location.href = 'lernender.php';}, 4000);</script>";
        }
    }

    function validateModule() {
        $validated = true;

        //check if all the required fields have been filled with data
        if(isset($_POST['modulnummer']) && isset($_POST['modulname']) && isset($_POST['durchführungsdatum']) && isset($_POST['vorname']) && isset($_POST['nachname']) && isset($_POST['email'])) {

            //validate the format of all the given inputs
            
            if(!preg_match("/\d+/", $_POST['modulnummer'])) {
                 
                echo '<script>message.innerHTML += "Fehleingabe: Die Modulnummer darf nur aus Zahlen bestehen und muss mindestens eine Ziffer lang sein<br>";</script>';
                $validated = false;
            }
            
            if(!preg_match("/[a-zA-Z0-9]+/", $_POST['modulname'])) {
                 
                echo '<script>message.innerHTML += "Fehleingabe: Der Modulname darf nur Gross- und Kleinbuchstaben oder Zahlen enthalten und muss mindestens ein Zeichen lang sein<br>";</script>';
                $validated = false;
            }

            if(!preg_match("/[a-zA-Z]+/", $_POST['vorname'])) {
                 
                echo '<script>message.innerHTML += "Fehleingabe: Der Name des Kursleiters darf nur aus Gross- und Kleinbuchstaben bestehen und muss mindestens ein Zeichen lang sein<br>";</script>';
                $validated = false;
            }

            if(!preg_match("/[a-zA-Z]+/", $_POST['nachname'])) {
                 
                echo '<script>message.innerHTML += "Fehleingabe: Der Nachname des Kursleiters darf nur aus Gross- und Kleinbuchstaben bestehen und muss mindestens ein Zeichen lang sein<br>";</script>';
                $validated = false;
            }

            if(!preg_match("/^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,6})$/", $_POST['email'])) {
                 
                echo '<script>message.innerHTML += "Fehleingabe: Die e-Mail Adresse muss ein gültiges Format haben<br>";</script>';
                $validated = false;
            }
        }

        //if not, display error message
        else {
             
            echo '<script>message.innerHTML += "Fehleingabe: Es müssen alle Felder ausgefüllt werden<br>";</script>';
            $validated = false;
        }

        return $validated;
    }

    function validateGrade() {
        $validated = true;

        //check if all the required fields have been filled with data
        if(isset($_POST['modulname']) && isset($_POST['vorname']) && isset($_POST['nachname']) && isset($_POST['note'])) {

            //validate the format of all the given inputs

            if(!preg_match("/[a-zA-Z0-9]+/", $_POST['modulname'])) {
                 
                echo '<script>message.innerHTML += "Fehleingabe: Der Modulname darf nur Gross- und Kleinbuchstaben oder Zahlen enthalten und muss mindestens ein Zeichen lang sein<br>";</script>';
                $validated = false;
            }

            if(!preg_match("/[a-zA-Z]+/", $_POST['vorname'])) {
                 
                echo '<script>message.innerHTML += "Fehleingabe: Der Name des Kursleiters darf nur aus Gross- und Kleinbuchstaben bestehen und muss mindestens ein Zeichen lang sein<br>";</script>';
                $validated = false;
            }

            if(!preg_match("/[a-zA-Z]+/", $_POST['nachname'])) {
                 
                echo '<script>message.innerHTML += "Fehleingabe: Der Nachname des Kursleiters darf nur aus Gross- und Kleinbuchstaben bestehen und muss mindestens ein Zeichen lang sein<br>";</script>';
                $validated = false;
            }

            if(!preg_match("/^[1-6]{1}(\.[0-9]{1,2})?/", $_POST['note'])) {
                 
                echo '<script>message.innerHTML += "Fehleingabe: Die Note muss ein gültiges Format haben und zwischen 1 und 6 liegen<br>";</script>';
                $validated = false;
            }

            //check if table named "[$mname]" exists
            $tempname = $_POST['modulname'];
            $checktable = $GLOBALS['conn']->query("SHOW TABLES LIKE '$tempname'");
            if($checktable->num_rows == 0) {
                echo "<script>message.innerHTML += \"Fehler: Das Modul $tempname exisiert nicht<br>\";</script>";
                $validated = false;
            }
        }

        else if(isset($_POST['modulname'])) {
            //validate the format of all the given inputs
            if(!preg_match("/[a-zA-Z0-9]+/", $_POST['modulname'])) {
                 
                echo '<script>message.innerHTML += "Fehleingabe: Der Modulname darf nur Gross- und Kleinbuchstaben oder Zahlen enthalten und muss mindestens ein Zeichen lang sein<br>";</script>';
                $validated = false;
            }
            //check if table named "[$modulname]" exists
            $tempname = $_POST['modulname'];
            $checktable = $GLOBALS['conn']->query("SHOW TABLES LIKE '$tempname'");
            if($checktable->num_rows == 0) {
                echo "Fehler: Das Modul $tempname exisiert nicht<br>";
                $validated = false;
            }
        }

        //if not, display error message
        else {
             
            echo '<script>message.innerHTML += "Fehleingabe: Es müssen alle Felder ausgefüllt werden<br>";</script>';
            $validated = false;
        }

        return $validated;
    }

    function showModules() {
        connect();

        $sql = "SELECT * FROM module";
        $result = $GLOBALS['conn']->query($sql);

        //take all the listed modules and print them out in a table
        if ($result->num_rows > 0) {

            echo "<table>";

            while($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row['ModulNummer'] . "</td><td>" . $row['ModulName'] . "</td><td>" . $row['VornameLeiter'] . "</td><td>" . $row['NachnameLeiter'] . "</td><td>" . $row['eMailLeiter'] ."</td></tr>";
            }

            echo "</table>";
        }
        else {
            echo "<p>Keine Module vorhanden</p>";
        }
    }

    function showGrades() {
        connect();

        if(validateGrade() == true) {
            $modulname = $_POST['modulname'];

            $sql = "SELECT * FROM $modulname";

            $result = $GLOBALS['conn']->query($sql);

            //print all the students in the requested module in a table
            if ($result->num_rows > 0) {

                echo "<table>";
                
                while($row = $result->fetch_assoc()) {
                    echo "<tr><td>" . $row['vorname'] . "</td><td>" . $row['nachname'] . "</td><td>" . $row['note'] . "</td></tr>";
                }

                echo "</table>";
            } 
            else {
                echo "<p>Kein Modul mit dem Namen <b>$modulname</b> vorhanden</p>";
            }
        }
    }

?>