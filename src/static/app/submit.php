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
    protected $formData;
    protected $referer;
    protected $sessionToken;
    protected $formFields = [
        'csrfToken',
        'website',
        'name',
        'email',
        'message'
    ];
    protected $formFilters = [
        'csrfToken' => 'trim|escape|cast:string',
        'website' => 'escape|cast:string',
        'name' => 'trim|escape|capitalize|cast:string',
        'email' => 'trim|escape|lowercase|cast:string',
        'message' => 'trim|escape|cast:string',
    ];
    protected $formRules = [
        'csrfToken' => v::alnum()->notEmpty()->noWhitespace()->setName('csrfToken'),
        'website' => v::not(v::notEmpty())->setName('website'),
        'name' => v::alpha()->notEmpty()->setName('name'),
        'email' => v::email()->notEmpty()->noWhitespace()->setName('email'),
        'message' => v::alnum()->notEmpty()->noWhitespace()->setName('message')
    ];

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
        $this->config->referer = $this->request->headers->get('referer');
        $this->config->sessionToken = $this->session->get('token');

        // Define Honeypot, CSRF fields, and form name
        $this->config->formLocation = '#contactForm';
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

        // Custom Error Messages for various errors
        $this->config->formErrorMsg = [
            'honeypot' => 'There was an issue submitting the form, please try again.',
            'token' => 'There was an issue submitting the form, please try again.',
            'serviceError' => 'There was an issue sending the form, please try again later.'
        ];
    }

    private function init()
    {
        // Sanitize Data
        $sanitizedData = $this->formSanitize($this->config->formData);

        // Set Flashbag session data of current form data in case of redirect
        $this->setFlashBag('data', ['form' => $sanitizedData]);

        // Validate Data
        $validation = $this->formValidation($sanitizedData);
        if (!empty($validation)) {
            $this->setFlashBag('errors', ['validation' => $validation]);
            return $this->sendErrorResponse('validation error');
        }

        // Check honeypot
        if (!empty($sanitizedData[$this->config->honeyPot])) {
            $this->setFlashBag('errors', ['formIssue' => $this->config->formErrorMsg['honeypot']]);
            return $this->sendErrorResponse('honeypot error');
        }

        // Check if form has a token
        if (empty($sanitizedData['csrfToken'])) {
            $this->setFlashBag('errors', ['formIssue' => $this->config->formErrorMsg['token']]);
            return $this->sendErrorResponse('token post error');
        }

        // Check if session has a token
        if (empty($this->config->sessionToken)) {
            $this->setFlashBag('errors', ['formIssue' => $this->config->formErrorMsg['token']]);
            return $this->sendErrorResponse('session token error');
        }

        // Compare Tokens
        if (!hash_equals($this->config->sessionToken, $sanitizedData['csrfToken'])) {
            $this->setFlashBag('errors', ['formIssue' => $this->config->formErrorMsg['token']]);
            return $this->sendErrorResponse('token match error');
        }

        // Send email via service
        $transmission = $this->formTransmition($sanitizedData);
        if ($transmission === FALSE) {
            $this->setFlashBag('errors', ['formIssue' => $this->config->formErrorMsg['serviceError']]);
            return $this->sendErrorResponse('service error');
        }

        // Return response
        $this->sendCompletionResponse('sent');
    }

    private function setFlashBag($key, $data)
    {
        return $this->session->getFlashBag()->set($key, $data);
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
        $response = new Response();
        $response->headers->set('Location', $this->config->referer . $this->config->formLocation);
        $response->setStatusCode(400);
        return $response->send();
    }

    private function sendCompletionResponse($message)
    {
        var_dump($message);
    }
}

