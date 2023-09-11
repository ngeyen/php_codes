<?php

/**
 * Generates a random code by combining a prefix with random characters.
 *
 * @param string $prefix The initial part of the generated code.
 *
 * @return string|false The generated random code if successful, or `false` if the prefix is too long (8 characters or more).
 */

function generateCode($prefix) {
    // A string containing the characters from which random characters will be selected.
    $chars = 'abcdefghijklmnopqrstuvwxyz0123456789';
    
    // Calculate the length of the prefix.
    $prefix_length = strlen($prefix);
    
    // Check if the prefix length exceeds the maximum allowed length (8 characters).
    if ($prefix_length >= 8) {
        return false;
    }

    // Calculate how many random characters are needed to reach a total length of 8 characters.
    $size = 8 - $prefix_length;

    // Initialize the randomCode with the prefix.
    $randomCode = $prefix;

    // Generate and append random characters to the randomCode.
    for ($i = 0; $i < $size; $i++) {
        // Select a random character from the provided character set ($chars).
        $randomCharacter = $chars[rand(0, strlen($chars) - 1)];

        // Append the random character to the randomCode.
        $randomCode .= $randomCharacter;
    }

    // Return the generated random code.
    return $randomCode;
}

?>