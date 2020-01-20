<?php
session_start();

if (isset($_SESSION['admin'])) {
    # code...
} else {
    header("Location: ../dashboard/index.php");
}