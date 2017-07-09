<?php

require_once __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Waavi\Sanitizer\Sanitizer;
use Respect\Validation\Validator as v;

new Submit();

class Submit
{

    protected $config;

    public function __construct()
    {
        $this->session = new Session();
        $this->session->start();

        $this->request = Request::createFromGlobals();

        $this->dotenv = new Dotenv(__DIR__);
        $this->dotenv->load();

        $this->setup();

        $this->init();
    }

    private function setup()
    {
        $this->config->formData = $this->request->request->all();
        $this->config->sessionToken = $this->session->get('token');

        $this->config->honeyPot = 'website';
        $this->config->formCSRF = 'csrfToken';

        $this->config->sendgridAPIKey = getenv('SENDGRID_KEY');

        $this->config->filters = [
            'csrfToken' => 'trim|escape|cast:string',
            'website' => 'escape|cast:string',
            'name' => 'trim|escape|capitalize|cast:string',
            'email' => 'trim|escape|lowercase|cast:string',
            'message' => 'trim|escape|cast:string',
        ];
    }

    private function init()
    {
        // Sanitize Data
        $sanitizedData = $this->formSanitize($this->config->formData);
        var_dump($sanitizedData);

        // Validate Data
        $validation = $this->formValidation($sanitizedData);
        if ($validation === FALSE) {
            return $this->sendErrorResponse('validation error');
        }

        // Check honeypot
        if (!empty($sanitizedData[$this->config->honeyPot])) {
            return $this->sendErrorResponse('honeypot error');
        }

        // Check if form has a token
        if (empty($sanitizedData['csrfToken'])) {
            return $this->sendErrorResponse('token post error');
        }

        // Check if session has a token
        if (empty($this->config->sessionToken)) {
            return $this->sendErrorResponse('session token error');
        }

        // Compare Tokens
        if (!hash_equals($this->config->sessionToken, $sanitizedData['csrfToken'])) {
            return $this->sendErrorResponse('token match error');
        }

        // Send email via sendgrid

        // Return response

        $this->sendCompletionResponse('sent');
    }

    private function formSanitize($data)
    {
        $sanitized = new Sanitizer($data, $this->config->filters);

        return $sanitized->sanitize();
    }

    private function formValidation($data)
    {
        return $data;
    }

    private function sendErrorResponse($message)
    {
        var_dump($message);
    }

    private function sendCompletionResponse($message)
    {
        var_dump($message);
    }
}

