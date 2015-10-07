<?php

namespace Derp\Infrastructure;

use Derp\Domain\Model\WalkInRegistered;

class WalkInRegisteredSendEmail
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * WalkInRegisteredSendEmail constructor.
     */
    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function __invoke(WalkInRegistered $walkInWasRegistered)
    {
        $message = \Swift_Message::newInstance(
            'New patient',
            'Indication: ' . $walkInWasRegistered->indication()
        );
        $message->setTo('triage-nurse@derp.nl');
        $this->mailer->send($message);

    }
}