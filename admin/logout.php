<?php
session_start();
unset($_SESSION['userInformation']);
header('Location: ../index.php');