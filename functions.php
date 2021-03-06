<?php

    error_reporting(0);

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

        echo "<div class=\"container\">";

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
                 
                echo "<script>message.innerHTML += \"Modul <b>$mname</b> erfolgreich erfasst<br>\";</script>";
            } else {
                $retry = true;
                echo '<script>message.innerHTML += "Die Daten konnten nicht erfasst werden<br>";</script>';
            }

            //create a new table called '[modulname]' for later record of students' grades
            $sql2 = "CREATE TABLE `{$mname}` (vorname TEXT, nachname TEXT, note DOUBLE )";

            if($GLOBALS['conn']->query($sql2) == TRUE) {
                echo "<script>message.innerHTML += 'Notentabelle für das Modul <b>$mname</b> erfolgreich erstellt<br>';</script>";
            }
            else {
                $retry = true;
                echo "<script>message.innerHTML += 'Es konnte keine Notentabelle für das Modul <b>$mname</b> erstellt werden<br>';</script>";
            }

            //send a mail with the module's data to the teacher
            $msg = "Modulnummer: $nummer<br>Modulname: $mname<br>Durchführungsdatum: $datum<br>Vorname Kursleiter: $vorname<br>Nachname Kursleiter: $nachname";
            $msg = wordwrap($msg, 70);

            if(mail($email, "Durchführung Modul $nummer", $msg)) {
                 
                echo "<script>message.innerHTML += 'E-Mail mit den Kursinformationen wurde erfolgreich an <b>$email</b> gesendet<br>';</script>";
            }
            else {
                 
                echo "<script>message.innerHTML += 'Es konnte keine E-Mail mit Kursinformationen an <b>$email</b> gesendet werden<br>';</script>";
            }
            
            echo "<h3>Mail an den Kursleiter</h3><p>Durchführung Modul $nummer</p><p>$msg</p>";
        }

        //if it didn't work, print out an error
        else {
            $retry = true;
            echo "<script>message.innerHTML += \"Fehler: Das Modul <b>$mname</b> konnte nicht erfasst werden<br>\";</script>";
        }

        //if something didn't work, return to the form input, else return to the home page
        if($retry == true) {
            echo "<button class=\"btn btn-primary\" onclick=\"toBerufsbildner()\">Okay</button>";
        }
        else {
            echo "<button class=\"btn btn-primary\" onclick=\"toIndex()\">Okay</button>";
        }

        echo "</div>";
    }

    function addGrade() {
        connect();

        echo "<div class=\"container\">";

        //only if the form is validated insert data into table
        if(validateGrade() == true) {
            $mname = $_POST['modulname'];
            $vorname = $_POST['vorname'];
            $nachname = $_POST['nachname'];
            $note = $_POST['note'];

            //insert validated data into the table named "[$mname]"
            $sql = "INSERT INTO `{$mname}` (vorname, nachname, note) VALUES('$vorname', '$nachname', '$note')";

            if($GLOBALS['conn']->query($sql) === TRUE) {
                echo "<script>message.innerHTML += \"Note für das Modul <b>$mname</b> erfolgreich erfasst<br>\";</script>";
                echo "<button class=\"btn btn-primary\" onclick=\"toIndex()\">Okay</button>";
            } else { 
                echo "<script>message.innerHTML += \"Fehler: Note konnte für das Modul <b>$mname</b> nicht erfasst werden<br>\";</script>";
                echo "<button class=\"btn btn-primary\" onclick=\"toLernender()\">Okay</button>";
            }
        }

        //if it didn't work, print out an error
        else {
            echo "<script>message.innerHTML += 'Fehler: Note konnte nicht erfasst werden<br>';</script>";
            echo "<button class=\"btn btn-primary\" onclick=\"toLernender()\">Okay</button>";
        }

        echo "</div>";
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

            //check if table named "[$mname]" already exists
            $tempname = $_POST['modulname'];
            $checktable = $GLOBALS['conn']->query("SHOW TABLES LIKE '$tempname'");
            if($checktable->num_rows > 0) {
                echo "<script>message.innerHTML += \"Fehler: Das Modul <b>$tempname</b> exisiert bereits<br>\";</script>";
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
                echo "<script>message.innerHTML += \"Fehler: Das Modul <b>$tempname</b> exisiert nicht<br>\";</script>";
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
                echo "Fehler: Das Modul <b>$tempname</b> exisiert nicht<br>";
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

        $sql = "SELECT * FROM module ORDER BY Datum";
        $result = $GLOBALS['conn']->query($sql);

        //take all the listed modules and print them out in a table
        if ($result->num_rows > 0) {

            while($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row['ModulNummer'] . "</td><td>" . $row['ModulName'] . "</td><td>" . $row['Datum'] . "</td><td>" . $row['VornameLeiter'] . "</td><td>" . $row['NachnameLeiter'] . "</td><td>" . $row['eMailLeiter'] ."</td>";
                //TODO echo form
                echo "<td class=\"noBorder\"><form action='index.php' method='post'><input type='hidden' name='modulname' value='" . $row['ModulName'] . "'><button class=\"btn btn-primary btn-sm\" type='submit' name='grades'>Noten</button></form></td></tr>";
            }

        }
    }

    function showGrades() {
        connect();

        if(validateGrade() == true) {
            $modulname = $_POST['modulname'];

            $sql = "SELECT * FROM $modulname ORDER BY Nachname";

            $result = $GLOBALS['conn']->query($sql);

            echo "<br><br><h2>Notenübersicht zum Modul $modulname</h2>";

            //print all the students in the requested module in a table
            if ($result->num_rows > 0) {

                echo "<table><tr><th>Vorname</th><th>Nachname</th><th>Note</th></tr>";
                
                while($row = $result->fetch_assoc()) {
                    echo "<tr><td>" . $row['vorname'] . "</td><td>" . $row['nachname'] . "</td><td>" . $row['note'] . "</td></tr>";
                }

                echo "</table>";
            } 
            else {
                echo "<p>Keine Noteneinträge zum Modul <b>$modulname</b> vorhanden</p>";
            }
        }
    }

?>