<?php
/**
 * PostageApp
 *
 * PHP 5
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the below copyright notice.
 *
 * @author     Robert Love <robert@pollenizer.com>
 * @copyright  Copyright 2012, Pollenizer Pty. Ltd. (http://pollenizer.com)
 * @license    MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @since      CakePHP(tm) v 2.0.4
 */

/**
 * PostageApp Config
 */
Configure::load('postageapp');

/**
 * Cake.Network.Http
 */
App::uses('HttpSocket', 'Network/Http');

/**
 * PostageApp
 *
 * A CakePHP Lib class used for interfacing with the PostageApp API.
 *
 * @link http://help.postageapp.com/kb/api/api-overview
 */
class PostageApp
{
    /**
     * API Key
     *
     * @var string
     */
    public $apiKey = null;

    /**
     * Attachments
     *
     * @var array
     */
    public $attachments = array();

    /**
     * From
     *
     * @var string
     */
    public $from = null;

    /**
     * HTML Message
     *
     * @var string
     */
    public $htmlMessage = null;

    /**
     * HTTP Socket
     *
     * @var object
     */
    public $HttpSocket = null;

    /**
     * Recipient Override
     *
     * @var string
     */
    public $recipientOverride = null;

    /**
     * Recipients
     *
     * @var mixed
     */
    public $recipients = null;

    /**
     * Request
     *
     * @var array
     */
    public $request = array();

    /**
     * Request Header
     *
     * @var array
     */
    public $requestHeader = array(
        'header' => array(
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'User-Agent' => 'CakePHP PostageApp Component 1.0'
        )
    );

    /**
     * Response
     *
     * @var array
     */
    public $response = array();

    /**
     * Subject
     *
     * @var string
     */
    public $subject = null;

    /**
     * Template
     *
     * @var string
     */
    public $template = null;

    /**
     * Text Message
     *
     * @var string
     */
    public $textMessage = null;

    /**
     * UID
     *
     * @var string
     */
    public $uid = null;

    /**
     * URL
     *
     * @var string
     */
    public $url = null;

    /**
     * Variables
     *
     * @var array
     */
    public $variables = array();

    /**
     * Headers
     *
     * @var array
     */
    public $headers = array();

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->HttpSocket = new HttpSocket();
        $settings = Configure::read('PostageApp');
        if ($settings) {
            foreach ($settings as $key => $value) {
                if (method_exists($this, $key)) {
                    $this->$key($value);
                }
            }
        }
    }

    /**
     * API Key
     *
     * @param string $value
     * @return PostageApp $this
     */
    public function apiKey($value = null)
    {
        $this->apiKey = $value;
        return $this;
    }

    /**
     * Attachments
     *
     * @param array $value
     * @return PostageApp $this
     */
    public function attachments($value = array())
    {
        $this->attachments = $value;
        return $this;
    }

    /**
     * From
     *
     * @param string $value
     * @return PostageApp $this
     */
    public function from($value = null)
    {
        $this->from = $value;
        return $this;
    }

    /**
     * Get Account Info
     *
     * @return PostageApp $this
     * @see http://help.postageapp.com/kb/api/get_account_info
     */
    public function getAccountInfo()
    {
        $this->url = 'https://api.postageapp.com/v.1.0/get_account_info.json';
        $this->request = array(
            'api_key' => $this->apiKey
        );
        $this->setResponse();
        return $this;
    }

    /**
     * Get Message Receipt
     *
     * @return PostageApp $this
     * @see http://help.postageapp.com/kb/api/get_message_receipt
     */
    public function getMessageReceipt()
    {
        $this->url = 'https://api.postageapp.com/v.1.0/get_message_receipt.json';
        $this->request = array(
            'api_key' => $this->apiKey,
            'uid' => $this->uid
        );
        $this->setResponse();
        return $this;
    }

    /**
     * Get Method List
     *
     * @return PostageApp $this
     * @see http://help.postageapp.com/kb/api/get_method_list
     */
    public function getMethodList()
    {
        $this->url = 'https://api.postageapp.com/v.1.0/get_method_list.json';
        $this->request = array(
            'api_key' => $this->apiKey
        );
        $this->setResponse();
        return $this;
    }

    /**
     * Get Project Info
     *
     * @return PostageApp $this
     * @see http://help.postageapp.com/kb/api/get_project_info
     */
    public function getProjectInfo()
    {
        $this->url = 'https://api.postageapp.com/v.1.0/get_project_info.json';
        $this->request = array(
            'api_key' => $this->apiKey
        );
        $this->setResponse();
        return $this;
    }

    /**
     * HTML Message
     *
     * @param string $value
     * @return PostageApp $this
     */
    public function htmlMessage($value = null)
    {
        $this->htmlMessage = $value;
        return $this;
    }

    /**
     * Recipient Override
     *
     * @param string $value
     * @return PostageApp $this
     */
    public function recipientOverride($value = null)
    {
        $this->recipientOverride = $value;
        return $this;
    }

    /**
     * Recipients
     *
     * @param mixed $value
     * @return PostageApp $this
     */
    public function recipients($value = null)
    {
        $this->recipients = $value;
        return $this;
    }

    /**
     * Send Message
     *
     * @return PostageApp $this
     * @see http://help.postageapp.com/kb/api/send_message
     */
    public function sendMessage()
    {
        $this->url = 'https://api.postageapp.com/v.1.0/send_message.json';
        $this->request = array(
            'api_key' => $this->apiKey,
            'uid' => $this->uid,
            'arguments' => array(
                'recipients' => $this->recipients,
                'headers' => array(
                    'subject' => $this->subject,
                    'from' => $this->from
                ),
                'content' => array(
                    'text/plain' => $this->textMessage,
                    'text/html' => $this->htmlMessage
                ),
                'attachments' => $this->attachments,
                'template' => $this->template,
                'variables' => $this->variables,
                'recipient_override' => $this->recipientOverride
            )
        );
        $this->request['arguments']['headers'] = array_merge($this->request['arguments']['headers'], $this->headers);
        if (!$this->uid) {
            $this->uid = $this->request['uid'] = sha1(time() . json_encode($this->request['arguments']));
        }
        $this->setResponse();
        return $this;
    }

    /**
     * Set Response
     *
     * @return PostageApp $this
     */
    public function setResponse()
    {
        $result = $this->HttpSocket->post(
            $this->url,
            json_encode($this->request),
            $this->requestHeader
        );
        if ($result = json_decode($result, true)) {
            $this->response = $result;
        }
        return $this;
    }

    /**
     * Subject
     *
     * @param string $value
     * @return PostageApp $this
     */
    public function subject($value = null)
    {
        if (configure::read('debug') > 0) {
            $value = '[[STAGING]] ' . $value;
        }
        $this->subject = $value;
        return $this;
    }

    /**
     * Template
     *
     * @param string $value
     * @return PostageApp $this
     */
    public function template($value = null)
    {
        $this->template = $value;
        return $this;
    }

    /**
     * Text Message
     *
     * @param string $value
     * @return PostageApp $this
     */
    public function textMessage($value = null)
    {
        $this->textMessage = $value;
        return $this;
    }

    /**
     * UID
     *
     * @param string $value
     * @return PostageApp $this
     */
    public function uid($value = null)
    {
        $this->uid = $value;
        return $this;
    }

    /**
     * Variables
     *
     * @param array $value
     * @return PostageApp $this
     */
    public function variables($value = array())
    {
        $this->variables = $value;
        return $this;
    }

    /**
     * Headers
     *
     * @param array $value
     * @return PostageApp $this
     */
    public function headers($value = array())
    {
        $this->headers = $value;
        return $this;
    } 
}
