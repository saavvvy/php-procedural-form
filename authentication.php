<?php
session_start(); // this session_start() is already working in dashboard.php, no need for another in dashboard.php

// this is so that if we do not login we cannot access dashboard.php
if (!isset($_SESSION['authenticated'])) {
    $_SESSION['status'] = "Please Login to Access User Dashboard!";
    header("Location: login.php");
    exit(0);
}
