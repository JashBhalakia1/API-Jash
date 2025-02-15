<?php
session_start();

// ✅ Destroy all session data
session_unset();
session_destroy();

// ✅ Ensure headers are not sent before redirecting
if (!headers_sent()) {
    header("Location: Index.php");
    exit;
} else {
    echo "<script>window.location.href='Index.php';</script>";
    exit;
}
?>
