<?php
session_start();

function est_connecte()
{
    return isset($_SESSION['user']);
}
