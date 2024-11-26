<?php

namespace PHPNomad\Mail\Integration\Strategies;

use PHPNomad\Email\Interfaces\EmailStrategy;
use PHPNomad\Email\Exceptions\EmailSendFailedException;

class PHPMailStrategy implements EmailStrategy
{
    /**
     * Send an email using PHP's built-in mail() function.
     *
     * @param array $to
     * @param string $subject
     * @param string $body
     * @param array $headers
     * @return void
     * @throws EmailSendFailedException
     */
    public function send(array $to, string $subject, string $body, array $headers): void
    {
        $toEmail = implode(',', $to); // Convert the recipient array to a comma-separated list

        // Format headers for mail() function
        $formattedHeaders = '';
        foreach ($headers as $key => $value) {
            $formattedHeaders .= "$key: $value\r\n";
        }

        // Send email
        $success = mail($toEmail, $subject, $body, $formattedHeaders);

        if (!$success) {
            throw new EmailSendFailedException('Email could not be sent.');
        }
    }
}
