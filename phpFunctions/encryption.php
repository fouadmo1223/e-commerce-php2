<?php
// Example usage
$key = "your_secret_key"; // Should be a long, random string
$iv = openssl_random_pseudo_bytes(16); // Initialization Vector

function encrypt($data, $key, $iv) {
    $cipher = "aes-256-cbc";
    $options = 0;
    return base64_encode(openssl_encrypt($data, $cipher, $key, $options, $iv));
}

function decrypt($encryptedData, $key, $iv) {
    $cipher = "aes-256-cbc";
    $options = 0;
    return openssl_decrypt(base64_decode($encryptedData), $cipher, $key, $options, $iv);
}




// $encryptedData = encrypt("category", $key, $iv);
// echo "Encrypted: " . $encryptedData ;

// $decryptedData = decrypt($encryptedData, $key, $iv);
// echo "Decrypted: " . $decryptedData ;
?>
