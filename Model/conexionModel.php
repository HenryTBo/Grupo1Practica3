<?php

    function OpenConnection()
        {
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
            return mysqli_connect("localhost", "root", "", "practica3");
        }

        function CloseConnection($context)
        {
            $context -> close();
        }

?>