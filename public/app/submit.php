<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

use Dotenv\Dotenv;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Waavi\Sanitizer\Sanitizer;
use Respect\Validation\Validator as v;
use Mailgun\Mailgun;

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
    protected $mailgunAPIKey;
    protected $mailgunDomain;
    protected $mailgunRecipient;
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

        $this->dotenv = new Dotenv(dirname(__DIR__));
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

        // Define Mailgun Keys
        $this->mailgunAPIKey = getenv('MAILGUN_KEY');
        $this->mailgunDomain = getenv('MAILGUN_DOMAIN');
        $this->mailgunRecipient = getenv('MAILGUN_RECIPIENT');

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
            'message' => v::alnum('!@#$%^&*()_+-=;:\'",.?')->notEmpty()->setName('message')
        ];

        // Custom Error Messages for various errors
        $this->formErrorMsg = [
            'validation' => 'There was an issue with some of your information, please try again.',
            'honeypot' => 'There was an issue submitting the form, please try again.',
            'token' => 'There was an issue submitting the form, please try again.',
            'serviceError' => 'There was an issue sending your message, please try again later.'
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
            $this->setFlashBag('response', ['formIssue' => $this->formErrorMsg['validation']]);
            $this->setFlashBag('validation', ['validation' => $validation]);
            return $this->sendErrorResponse();
        }

        // Check honeypot
        if (!empty($sanitizedData[$this->honeyPotName])) {
            $this->setFlashBag('response', ['formIssue' => $this->formErrorMsg['honeypot']]);
            return $this->sendErrorResponse();
        }

        // Check if form has a token
        if (empty($sanitizedData['csrfToken'])) {
            $this->setFlashBag('response', ['formIssue' => $this->formErrorMsg['token']]);
            return $this->sendErrorResponse();
        }

        // Check if session has a token
        if (empty($this->sessionToken)) {
            $this->setFlashBag('response', ['formIssue' => $this->formErrorMsg['token']]);
            return $this->sendErrorResponse();
        }

        // Compare Tokens
        if (!hash_equals($this->sessionToken, $sanitizedData['csrfToken'])) {
            $this->setFlashBag('response', ['formIssue' => $this->formErrorMsg['token']]);
            return $this->sendErrorResponse();
        }

        // Send email via service
        $transmission = $this->formTransmission($sanitizedData);
        if ($transmission === FALSE) {
            $this->setFlashBag('response', ['formIssue' => $this->formErrorMsg['serviceError']]);
            return $this->sendErrorResponse();
        }

        // Return response
        $this->session->getFlashBag()->clear();
        $this->setFlashBag('response', 'The form has been sent successfully');
        return $this->sendCompletionResponse();
    }

    private function setFlashBag($key, $data)
    {
        return $this->session->getFlashBag()->set($key, $data);
    }

    private function formSanitize($data, $filters)
    {
        $sanitized = new Sanitizer($data, $filters);

        return $sanitized->sanitize();
    }

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
        $mailgun = Mailgun::create($this->mailgunAPIKey);

        $mailgun->messages()->send($this->mailgunDomain, [
            'from' => 'info@packet39.com',
            'h:Reply-To' => $data['name'] .' <'. $data['email'].'>',
            'to' => $this->mailgunRecipient,
            'subject' => 'Contact Form Submission from packet39.com',
            'html' => '<strong>Form Message: </strong><br><br>' . $data['message']
        ]);

        return $mailgun;
    }

    private function sendErrorResponse()
    {
        $response = new RedirectResponse('/'.$this->formLocation, 302);
        return $response->send();
    }

    private function sendCompletionResponse()
    {
        $response = new RedirectResponse('/'.$this->formLocation, 302);
        return $response->send();
    }
}

