<?php
session_start();
require_once 'config/database_sqlite.php';
require_once 'includes/functions.php';

// Simple routing
$page = $_GET['page'] ?? 'home';

// Header
include 'includes/header.php';

// Navigation
include 'includes/navigation.php';

// Main content based on page
switch ($page) {
    case 'home':
        include 'pages/home.php';
        break;
    case 'problems':
        include 'pages/problems.php';
        break;
    case 'solutions':
        include 'pages/solutions.php';
        break;
    case 'forum':
        include 'pages/forum.php';
        break;
    case 'resources':
        include 'pages/resources.php';
        break;
    case 'contact':
        include 'pages/contact.php';
        break;
    case 'login':
        include 'pages/login.php';
        break;
    case 'register':
        include 'pages/register.php';
        break;
    default:
        include 'pages/home.php';
}

// Footer
include 'includes/footer.php';
?>
