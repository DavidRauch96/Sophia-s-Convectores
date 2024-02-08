<?php
function authenticateUser() {
    if (isset($_GET['bypass']) && $_GET['bypass'] === 'true') {
        // Bypass authentication
    
        // Example: Allow access without checking credentials
        return 'Guest';
    } else {
        // Perform authentication
    
        if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW'])) {
            header('WWW-Authenticate: Basic realm="Password Protected Area"');
            header('HTTP/1.0 401 Unauthorized');
            echo 'Authentication required.';
            exit;
        }
    
        // Validate credentials using .htpasswd file (Apache handles this)
        $authenticatedUser = $_SERVER['PHP_AUTH_USER'];
    }
}

?>