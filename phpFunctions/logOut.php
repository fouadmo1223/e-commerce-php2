<?php
    if (isset($_COOKIE['username'])) {
        setcookie('username', $_COOKIE['username'], time() - 1, "/");

        echo json_encode(array('status' => 'success', 'message' => "You have been logged out successfully"));
    } else {
        http_response_code(500);
        echo json_encode(array('status' => 'error', 'message' => "Something went wrong"));
    }
?>