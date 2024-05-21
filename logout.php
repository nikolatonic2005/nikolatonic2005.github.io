<?php
session_start();
session_destroy();
echo <<<html
    <script>
        window.location = "begin.php";
    </script>
    html;
