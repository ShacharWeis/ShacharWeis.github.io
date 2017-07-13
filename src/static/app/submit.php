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
    protected $referrer;
    protected $sessionToken;
    protected $formLocation;
    protected $honeyPotName;
    protected $formCSRFName;
    protected $sendgridAPIKey;
    protected $formFields;
    protected $formFilters;
    protected $formRules;
    protected $formErrorMsg;


    /**
     * Submit constructor.
     */
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

    protected function setup()
    {
        // Capture Request and Session
        $this->formData = $this->request->request->all();
        $this->referrer = $this->request->headers->get('referer');
        $this->sessionToken = $this->session->get('token');

        // Define Honeypot, CSRF fields, and form name
        $this->formLocation = '#contactForm';
        $this->honeyPotName = 'website';
        $this->formCSRFName = 'csrfToken';

        // Define Sendgrid API Key
        $this->sendgridAPIKey = getenv('SENDGRID_KEY');

        // Define Form fields
        $this->formFields = [
            'csrfToken',
            'website',
            'name',
            'email',
            'message'
        ];

        // Define form field sanitization rules
        $this->formFilters = [
            'csrfToken' => 'trim|escape|cast:string',
            'website' => 'escape|cast:string',
            'name' => 'trim|escape|capitalize|cast:string',
            'email' => 'trim|escape|lowercase|cast:string',
            'message' => 'trim|escape|cast:string',
        ];

        // Define validation rules
        $this->formRules = [
            'csrfToken' => v::alnum()->notEmpty()->noWhitespace()->setName('csrfToken'),
            'website' => v::not(v::notEmpty())->setName('website'),
            'name' => v::alpha()->notEmpty()->setName('name'),
            'email' => v::email()->notEmpty()->noWhitespace()->setName('email'),
            'message' => v::alnum()->notEmpty()->noWhitespace()->setName('message')
        ];

        // Custom Error Messages for various errors
        $this->formErrorMsg = [
            'honeypot' => 'There was an issue submitting the form, please try again.',
            'token' => 'There was an issue submitting the form, please try again.',
            'serviceError' => 'There was an issue sending the form, please try again later.'
        ];
    }

    private function init()
    {
        // Sanitize Data
        $sanitizedData = $this->formSanitize($this->formData, $this->formFilters);

        // Set Flashbag session data of current form data in case of redirect
        $this->setFlashBag('data', ['form' => $sanitizedData]);

        // Validate Data
        $validation = $this->formValidation($sanitizedData, $this->formRules);
        if (!empty($validation)) {
            $this->setFlashBag('errors', ['validation' => $validation]);
            return $this->sendErrorResponse('Validation error');
        }

        // Check honeypot
        if (!empty($sanitizedData[$this->honeyPotName])) {
            $this->setFlashBag('errors', ['formIssue' => $this->formErrorMsg['honeypot']]);
            return $this->sendErrorResponse('Honeypot error');
        }

        // Check if form has a token
        if (empty($sanitizedData['csrfToken'])) {
            $this->setFlashBag('errors', ['formIssue' => $this->formErrorMsg['token']]);
            return $this->sendErrorResponse('Token Error');
        }

        // Check if session has a token
        if (empty($this->sessionToken)) {
            $this->setFlashBag('errors', ['formIssue' => $this->formErrorMsg['token']]);
            return $this->sendErrorResponse('Token Error');
        }

        // Compare Tokens
        if (!hash_equals($this->sessionToken, $sanitizedData['csrfToken'])) {
            $this->setFlashBag('errors', ['formIssue' => $this->formErrorMsg['token']]);
            return $this->sendErrorResponse('Token Error');
        }

        // Send email via service
        $transmission = $this->formTransmission($sanitizedData);
        if ($transmission === FALSE) {
            $this->setFlashBag('errors', ['formIssue' => $this->formErrorMsg['serviceError']]);
            return $this->sendErrorResponse('Service error');
        }

        // Return response
        $this->setFlashBag('complete', 'The form has been sent successfully');
        $this->sendCompletionResponse('sent');
    }

    /**
     * @param $key
     * @param $data
     * @return mixed
     */
    private function setFlashBag($key, $data)
    {
        return $this->session->getFlashBag()->set($key, $data);
    }

    /**
     * @param $data
     * @param $filters
     * @return array
     */
    private function formSanitize($data, $filters)
    {
        $sanitized = new Sanitizer($data, $filters);

        return $sanitized->sanitize();
    }

    /**
     * @param $data
     * @param $rules
     * @return array
     */
    private function formValidation($data, $rules)
    {
        $errors = [];

        foreach ($data as $key => $value) {
            try {
                $rules[$key]->check($value);
            } catch (\InvalidArgumentException $e) {
                $errors[$key] = $e->getMessage();
            }
        }

        return $errors;
    }

    private function formTransmission($data)
    {
        var_dump('sent message');
        var_dump($data);
        return true;
    }

    private function sendErrorResponse($message)
    {
        if ($this->request->isXmlHttpRequest()) {
            $response = new Response($message, 400);
            return $response->send();
        }

        $response = new RedirectResponse('/', 302);
        return $response->send();
    }

    private function sendCompletionResponse($message)
    {
        if ($this->request->isXmlHttpRequest()) {
            $response = new Response($message, 201);
            return $response->send();
        }

        $response = new RedirectResponse('/', 302);
        return $response->send();
    }
}

