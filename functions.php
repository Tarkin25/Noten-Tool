<?php

    function connect() {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "mydb";

        // Create connection
        $GLOBALS['conn'] = new mysqli($servername, $username, $password, $dbname);
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
?>