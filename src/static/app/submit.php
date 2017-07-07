<?php

require_once __DIR__ . '/vendor/autoload.php';

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Waavi\Sanitizer\Sanitizer;
use Respect\Validation\Validator as v;

new Submit();

class Submit
{
    protected $session;
    protected $request;

    public function __construct()
    {
        $this->session = new Session();
        $this->session->start();

        $this->request = Request::createFromGlobals();

        $this->init();
    }

    private function init()
    {
        // Format Data
        $formData = $this->request->request->all();

        // Sanitize Data

        // Validate Honeypot

        // Valiate CSRF

        // Validate Data

        // Send email via sendgrid

        // Return response
        var_dump($formData);

        var_dump($this->session->all());


    }

    private function validateCSRF()
    {
    }

    private function sendResponse()
    {

    }
}

