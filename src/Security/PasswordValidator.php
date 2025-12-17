<?php

namespace App\Security;

class PasswordValidator
{
    /**
     * Validates the strength of a password.
     *
     * @param string $password
     * @return bool
     */
    public function validate(string $password): bool
    {
        // Minimum length of 6 characters
        if (strlen($password) < 6) {
            return false;
        }

        // At least one uppercase letter
        if (!preg_match('/[A-Z]/', $password)) {
            return false;
        }

        // At least one lowercase letter
        if (!preg_match('/[a-z]/', $password)) {
            return false;
        }

        // At least one digit
        if (!preg_match('/\d/', $password)) {
            return false;
        }

        // At least one special character
        if (!preg_match('/[\W_]/', $password)) {
            return false;
        }

        $dangerousPatterns = [
            '<script',
            'javascript:',
            'onload=',
            'onerror=',
            "' OR",
            '" OR',
            '1=1',
            'DROP TABLE',
            'UNION SELECT'
        ];

        foreach ($dangerousPatterns as $pattern) {
            if (stripos($password, $pattern) !== false) {
                return false; // Password contains disallowed characters
            }
        } 

        return true;
    }
}
