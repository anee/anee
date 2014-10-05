<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Lukas
 * Date: 6.4.14
 * Time: 21:57
 * To change this template use File | Settings | File Templates.
 */

namespace App\Model;

use App\Model;
use Nette\Object;
use Nette\Security as NS;
use Nette\Security\Passwords;


/**
 * Users authenticator.
 */
class Authenticator extends Object implements NS\IAuthenticator
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

        if (!$user || !Passwords::verify($password, $user->getPassword()))
            throw new NS\AuthenticationException("Wrong user or password.");

        $data = $user->toArray();
        unset($data['password']);
        return new NS\Identity($user->getId(), null, $data);
    }
}