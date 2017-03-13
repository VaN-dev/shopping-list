<?php

namespace AppBundle\Service\Mailer;

/**
 * Interface MailerInterface
 * @package AppBundle\Service\Mailer
 */
interface MailerInterface
{
    /**
     * @param $to
     * @param $subject
     * @param $body
     * @param $from
     * @return mixed
     */
    public function send($to, $subject, $body, $from);
}