<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function est_connecte() {
    return isset($_SESSION['user']);
}
