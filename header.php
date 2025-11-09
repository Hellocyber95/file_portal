<?php
// ============================
// Secure Header Initialization
// ============================

// Start session safely
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include database connection
include_once 'db.php';

// ============================
// Security Checks
// ============================

// Block directory traversal attempts
$request_uri = $_SERVER['REQUEST_URI'];
if (strpos($request_uri, '../') !== false || strpos($request_uri, '..\\') !== false) {
    header("Location: index.php?page=home");
    exit();
}

// Block suspicious characters in URL
if (preg_match('/[<>\"\'\;]/', $request_uri)) {
    header("Location: index.php?page=home");
    exit();
}

// ============================
// Handle ?page= Parameter
// ============================

// If ?page is missing, auto-redirect to the current script with ?page=<basename>
if (!isset($_GET['page']) || empty($_GET['page'])) {
    $current = basename($_SERVER['PHP_SELF'], ".php"); // e.g., "products"
    header("Location: {$current}.php?page={$current}");
    exit();
}

// Sanitize the page variable
$page = htmlspecialchars($_GET['page'], ENT_QUOTES, 'UTF-8');

// Optional: whitelist allowed pages (extra safety)
$allowed_pages = ['index', 'home', 'login', 'register', 'dashboard', 'upload', 'admin', 'products', 'cart', 'view_file'];
if (!in_array($page, $allowed_pages)) {
    header("Location: index.php?page=home");
    exit();
}

// ============================
// Common Header HTML (Optional)
// ============================
// You can include a global navigation bar or meta tags here if you like
?>
