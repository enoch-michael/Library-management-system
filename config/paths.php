<?php
/**
 * Dynamic BASE_URL resolver (Windows-safe version)
 * -----------------------------------------------------
 * Works out the correct URL prefix automatically, based on where
 * this project actually sits inside htdocs.
 *
 * Include this from ANY file, at any folder depth:
 *   require_once __DIR__ . '/../config/paths.php';   (one level deep)
 *   require_once __DIR__ . '/../../config/paths.php'; (two levels deep)
 *
 * Defines one constant: BASE_URL (always ends with a trailing slash)
 */

if (!defined('BASE_URL')) {

    // realpath() normalizes slashes AND resolves any ../ segments,
    // which is more reliable than manual string concatenation
    $projectRoot = realpath(__DIR__ . '/..');
    $docRoot     = realpath($_SERVER['DOCUMENT_ROOT']);

    if ($projectRoot === false || $docRoot === false) {
        // Fallback — should not normally happen, but prevents a fatal
        // error if realpath() fails for some reason
        define('BASE_URL', '/');
    } else {
        $projectRoot = str_replace('\\', '/', $projectRoot);
        $docRoot     = str_replace('\\', '/', $docRoot);

        // Windows filesystems are case-insensitive (C:/xampp vs c:/XAMPP
        // can both be valid), so use stripos() not strpos()
        $pos = stripos($projectRoot, $docRoot);

        if ($pos === 0) {
            $base = substr($projectRoot, strlen($docRoot));
        } else {
            // Project root isn't inside document root as expected —
            // fall back to root rather than break every link
            $base = '';
        }

        $base = '/' . trim($base, '/') . '/';
        define('BASE_URL', $base);
    }
}

// ---------------------------------------------------------------
// TEMPORARY DEBUG TOOL — visit any page with ?debug_paths=1 in the
// URL to see exactly what this computed. Remove once everything
// works, or just leave it — it only shows if the query param is set.
// Example: http://localhost/.../index.php?debug_paths=1
// ---------------------------------------------------------------
if (isset($_GET['debug_paths'])) {
    echo '<div style="background:#fff3cd;border:1px solid #ffc107;padding:16px;margin:16px;font-family:monospace;font-size:13px;">';
    echo '<strong>PATH DEBUG INFO</strong><br>';
    echo 'This file (paths.php) location: ' . __FILE__ . '<br>';
    echo 'Computed project root: ' . (realpath(__DIR__ . '/..') ?: 'FAILED') . '<br>';
    echo 'Server DOCUMENT_ROOT: ' . ($_SERVER['DOCUMENT_ROOT'] ?? 'NOT SET') . '<br>';
    echo 'Computed BASE_URL: <strong>' . BASE_URL . '</strong><br>';
    echo 'Try this in your browser: <a href="' . BASE_URL . 'assets/css/style.css" target="_blank">' . BASE_URL . 'assets/css/style.css</a>';
    echo '</div>';
}
?>