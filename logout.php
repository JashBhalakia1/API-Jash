<?php
session_start();

// ✅ Destroy all session data
session_unset();
session_destroy();

// ✅ Ensure headers are not sent before redirecting
if (!headers_sent()) {
    header("Location: login.php");
    exit;
} else {
    echo "<script>window.location.href='login.php';</script>";
    exit;
}
?>
