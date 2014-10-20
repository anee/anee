<?php

namespace App\Model;

use App\Model;
use Nette\Security\AuthenticationException;
use Nette\Security\Passwords;
use Nette\Object;
use Nette\Security\IAuthenticator;
use Nette\Security\Identity;


/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class Authenticator extends Object implements IAuthenticator
{
    /** @var \App\Model\UserBaseLogic */
    public $userBaseLogic;

    public function __construct(UserBaseLogic $userBaseLogic)
    {
        $this->userBaseLogic = $userBaseLogic;
    }

    public function authenticate(array $credentials)
    {
        list($usernameOrEmail, $password) = $credentials;

        $user = $this->userBaseLogic->findOneSignIn($usernameOrEmail);

        if (!$user || !Passwords::verify($password, $user->password))
            throw new AuthenticationException("Wrong user or password.");

        $data = $user->toArray();
        unset($data['password']);

        return new Identity($user->getId(), null, $data);
    }
}