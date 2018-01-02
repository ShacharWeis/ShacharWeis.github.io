<?php

require_once __DIR__ . '/app/vendor/autoload.php';

use Symfony\Component\HttpFoundation\Session\Session;

$session = new Session();
$session->start();


if ($session->has('token')) {
    $token = $session->get('token');
} else {
    $token = bin2hex(random_bytes(32));
    $session->set('token', $token);
}

?>
