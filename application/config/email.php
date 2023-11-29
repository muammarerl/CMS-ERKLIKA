<?php

$config = array(
    'protocol' => 'smtp', // 'mail', 'sendmail', or 'smtp'
    'smtp_host' => 'mail.kineria.com', 
    'smtp_port' => 587,
    'smtp_user' => 'fauzan@kineria.com',
    'smtp_pass' => '*Fauzan123#',
    'smtp_crypto' => 'tls', //can be 'ssl' or 'tls' for example
    'mailtype' => 'text', //plaintext 'text' mails or 'html'
    'smtp_timeout' => '4', //in seconds
    'charset' => 'iso-8859-1',
    'wordwrap' => TRUE
);
/*
 * 
 * MAIL_MAILER=smtp
MAIL_HOST=mail.kineria.com
MAIL_PORT=587
MAIL_USERNAME=fauzan@kineria.com
MAIL_PASSWORD="*Fauzan123#"
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=info@festivalfilm.id
 */