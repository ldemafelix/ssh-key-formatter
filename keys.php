<?php

/**
 * SSH Key Formatter
 * Extracts public keys from GitLab and GitHub
 *
 * https://code.liam.ph/liam/ssh-key-formatter
 * Copyright (c) 2020 - Liam Demafelix <hey@liam.ph>
 */
 
header('Content-Type: text/plain');
date_default_timezone_set('Asia/Manila');

// Figure out what format to use
$source = 'github';
if (!empty($_GET['source'])) {
    // Make sure the source is in a correct format
    if (preg_match('/^[a-z]+$/', trim($_GET['source']))) {
        $source = strtolower(trim($_GET['source']));
    }
}

// Find out the username
if (empty($_GET['username'])) {
    // You must specify a username. To preserve functionality, we'll just echo blank text.
    die();
}
$username = trim($_GET['username']);

// If we're not GitHub, we can specify a host
if ($source === 'github') {
    $host = 'api.github.com';
} else {
    $host = 'gitlab.com';
    if (!empty($_GET['host'])) {
        if (filter_var(strtolower(trim($_GET['host'])), FILTER_VALIDATE_DOMAIN, FILTER_FLAG_HOSTNAME)) {
            $host = strtolower(trim($_GET['host']));
        }
    }
}

// Get the keys
if ($source === 'github') {
    $remote = 'https://api.github.com/users/' . $username . '/keys';
} else {
    $remote = 'https://' . $host . '/api/v4/users/' . $username . '/keys';
}
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $remote);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['User-Agent: ' . $username]);
$result = curl_exec($ch);
$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// Process the result
if ($status !== 200) {
    // Return nothing
    die();
}
$data = json_decode($result);
$body = 'Fetched: ' . date('Y/m/d H:i:s') . ' - Asia/Manila Time' . PHP_EOL;
$body .= "Command: wget \"https://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}\" -O ~/.ssh/authorized_keys && chmod 0600 ~/.ssh/authorized_keys" . PHP_EOL . PHP_EOL;
foreach ($data as $datum) {
    $body .= '# From ' . $source . ' - Key ID #' . $datum->id . PHP_EOL . $datum->key . PHP_EOL;
}

echo $body;