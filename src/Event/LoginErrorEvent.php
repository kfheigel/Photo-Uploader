<?php

namespace App\Event;

use Symfony\Contracts\EventDispatcher\Event;
use Symfony\Component\Security\Core\User\UserInterface;

class LoginErrorEvent extends Event
{
    const NAME = 'login.error';

    private $user;

    public function __construct(UserInterface $user)
    {
        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user;
    }

}