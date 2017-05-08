<?php

namespace Tatweer\TrainingBundle\Services;

class MailClass
{
    protected $mailer;

    public function __construct($mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendEmail($from, $to, $body, $subject = '')
    {
        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom($from)
            ->setTo($to)
            ->setContentType("text/html")
            ->setBody($body);

        $this->mailer->send($message);
    }
}