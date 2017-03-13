<?php

namespace AppBundle\Service\Mailer\Client;

use AppBundle\Service\Mailer\MailerInterface;
use Kasl\SendPulse\ApiClient;

/**
 * Class SendPulse
 * @package AppBundle\Service\Mailer\Client
 */
class SendPulse implements MailerInterface
{
    /**
     * @var ApiClient
     */
    private $client;

    /**
     * @var string
     */
    private $key;

    /**
     * @var string
     */
    private $secret;

    public function __construct()
    {
        $this->key = 'a5e94a0f54ca8f316b7fda10f739e20a';
        $this->secret = 'd4b027a13372c64b60b6926f90f6d6c6';

        $this->client = new ApiClient($this->key, $this->secret, 'session');
    }

    /**
     * @param $to
     * @param $subject
     * @param $body
     * @param $from
     * @return mixed
     */
    public function send($to, $subject, $body, $from)
    {
        $email = [
            "html" => $body,
            "text" => $body,
            "subject" => $subject,
            "encoding" => "utf8",
            "from" => [
                "name" => isset($from["name"]) ? $from["name"] : "",
                "email" => $from["email"],
            ],
            "to" => [
                [
                    "name" => isset($to["name"]) ? $to["name"] : "",
                    "email" => $to["email"],
                ],
            ],
        ];

        $reponse = $this->client->smtpSendMail($email);

        return $reponse->result;
    }
}