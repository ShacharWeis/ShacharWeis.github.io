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
        // Capture Request and Session
        $this->config->formData = $this->request->request->all();
        $this->config->referer = $this->request->headers->get('referer')
        $this->config->sessionToken = $this->session->get('token');

        // Define Honeypot and CSRF fields
        $this->config->honeyPot = 'website';
        $this->config->formCSRF = 'csrfToken';

        // Define Sendgrid API Key
        $this->config->sendgridAPIKey = getenv('SENDGRID_KEY');

        // Define Form fields
        $this->config->formFields = [
            'csrfToken',
            'website',
            'name',
            'email',
            'message'
        ];

        // Define form field sanitization rules
        $this->config->formFilters = [
            'csrfToken' => 'trim|escape|cast:string',
            'website' => 'escape|cast:string',
            'name' => 'trim|escape|capitalize|cast:string',
            'email' => 'trim|escape|lowercase|cast:string',
            'message' => 'trim|escape|cast:string',
        ];

        // Define validation rules
        $this->config->formRule = [
            'csrfToken' => v::alnum()->notEmpty()->noWhitespace()->setName('csrfToken'),
            'website' => v::not(v::notEmpty())->setName('website'),
            'name' => v::alpha()->notEmpty()->setName('name'),
            'email' => v::email()->notEmpty()->noWhitespace()->setName('email'),
            'message' => v::alnum()->notEmpty()->noWhitespace()->setName('message')
        ];
    }

    private function init()
    {
        // Sanitize Data
        $sanitizedData = $this->formSanitize($this->config->formData);

        // Validate Data
        $validation = $this->formValidation($sanitizedData);
        if (!empty($validation)) {
            $this->session->getFlashBag()->set('errors', ['validation' => $validation]);
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

        // Send email via service
        $transmission = $this->formTransmition($sanitizedData);
        if ($transmission === FALSE) {
            return $this->sendErrorResponse('service error');
        }

        // Return response
        $this->sendCompletionResponse('sent');
    }

    private function formSanitize($data)
    {
        $sanitized = new Sanitizer($data, $this->config->formFilters);

        return $sanitized->sanitize();
    }

    private function formValidation($data)
    {
        $errors = [];

        foreach ($data as $key => $value) {
            try {
                $this->config->formRule[$key]->check($value);
            } catch (\InvalidArgumentException $e) {
                $errors[$key] = $e->getMessage();
            }
        }

        return $errors;
    }

    private function formTransmition($data)
    {
        var_dump('sent message');
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

