<?php
session_start();
session_destroy();
header('location: ../Views/telaInicial.php');
exit;