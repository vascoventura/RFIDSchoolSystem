<?php
session_start();
session_destroy();
header('Location: ProjetoFinal.php');
exit();
?>