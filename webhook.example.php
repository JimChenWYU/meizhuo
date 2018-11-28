<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/3/14
 * Time: 22:47
 */
error_reporting(E_ALL);

// GitHub Webhook Secret.
// Keep it the same with the 'Secret' field on your Webhooks / Manage webhook page of your respostory.
$secret = "";
// Path to your respostory on your server.
// e.g. "/var/www/respostory"
$path = "";
// Headers deliveried from GitHub
$signature = $_SERVER['HTTP_X_HUB_SIGNATURE'];

if ($signature) {
    $hash = "sha1=".hash_hmac('sha1', $HTTP_RAW_POST_DATA, $secret);
    if (strcmp($signature, $hash) == 0) {
        echo shell_exec("/usr/bin/git status") . PHP_EOL;
        echo shell_exec("cd {$path} && /usr/bin/git reset --hard origin/master && /usr/bin/git clean -f && /usr/bin/git pull 2>&1") . PHP_EOL;
        exit('Webhook success');
    }
}
http_response_code(404);

