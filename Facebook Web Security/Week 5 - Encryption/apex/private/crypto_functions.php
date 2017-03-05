<?php

// Symmetric Encryption

// Cipher method to use for symmetric encryption
const CIPHER_METHOD = 'AES-256-CBC';

function key_encrypt($string, $key, $cipher_method=CIPHER_METHOD) {

     // AES Encryption needs a key of length 32 (256-bit)
     $key = str_pad($key, 32, '*');

     // Finding the correct length for the Cipher Method
     $iv_length = openssl_cipher_iv_length($cipher_method);

     // Generates an initialization vector which randomizes the inital settings of the algorithm, which makes it harder to decrypt
     $iv = openssl_random_pseudo_bytes($iv_length);

     // Encryption
     $encrypted = openssl_encrypt($string, $cipher_method, $key, OPENSSL_RAW_DATA, $iv);

     // Returning $iv at the front of the string. It is needed for decoding
     $encrypted_message = $iv . $encrypted;

     // Encoding ensures that encrypted characters are viewable/savable by the computer
     $encrypted_message = base64_encode($encrypted_message);

  return $encrypted_message;
}

function key_decrypt($string, $key, $cipher_method=CIPHER_METHOD) {

     // AES Encryption needs a key of length 32 (256-bit)
     $key = str_pad($key, 32, '*');

     // Base64 decoding must be done before decryption
     $iv_with_ciphertext = base64_decode($string);

     // Parsing in order to seperate the initialization vector and and encrypted string
     $iv_length = openssl_cipher_iv_length($cipher_method);
     $iv = substr($iv_with_ciphertext, 0, $iv_length);
     $ciphertext = substr($iv_with_ciphertext, $iv_length);

     // Decryption
     $decrypted_message = openssl_decrypt($ciphertext, $cipher_method, $key, OPENSSL_RAW_DATA, $iv);

  return $decrypted_message;
}


// Asymmetric Encryption / Public-Key Cryptography

// Cipher configuration to use for asymmetric encryption
const PUBLIC_KEY_CONFIG = array(
    "digest_alg" => "sha512",
    "private_key_bits" => 2048,
    "private_key_type" => OPENSSL_KEYTYPE_RSA,
);

function generate_keys($config=PUBLIC_KEY_CONFIG) {
  $resource = openssl_pkey_new($config);

  // Extracting private key from the pair
  openssl_pkey_export($resource, $private_key);

  // Extracting public key from the Pair
 $key_details = openssl_pkey_get_details($resource);
 $public_key = $key_details["key"];

  return array('private' => $private_key, 'public' => $public_key);
}

function pkey_encrypt($string, $public_key) {
  openssl_public_encrypt($string, $encrypted, $public_key);

  // Encoding ensures that encrypted characters are viewable/savable by the computer
  $message = base64_encode($encrypted);

  return $message;
}

function pkey_decrypt($string, $private_key) {
     // Base64 decoding must be done before decryption
     $ciphertext = base64_decode($string);

     openssl_private_decrypt($ciphertext, $decrypted, $private_key);

     return $decrypted;
}


// Digital signatures using public/private keys

function create_signature($data, $private_key) {
  // A-Za-z : ykMwnXKRVqheCFaxsSNDEOfzgTpYroJBmdIPitGbQUAcZuLjvlWH
  openssl_sign($data, $raw_signature, $private_key);

  // Encoding ensures that encrypted characters are viewable/savable by the computer
  $signature = base64_encode($raw_signature);

  return $signature;
}

function verify_signature($data, $signature, $public_key) {
  $raw_signature = base64_decode($signature);
  return openssl_verify($data, $raw_signature, $public_key);
}

?>
