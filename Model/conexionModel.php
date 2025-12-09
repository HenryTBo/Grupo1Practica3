<?php

    function OpenConnection()
        {
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
            return mysqli_connect("127.0.0.1:3307", "root", "", "practica3");
        }

        function CloseConnection($context)
        {
            $context -> close();
        }

?>