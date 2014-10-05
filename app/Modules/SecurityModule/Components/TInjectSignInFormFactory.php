<?php
/**
 * Created by PhpStorm.
 * User: Phantom
 * Date: 8.9.14
 * Time: 17:01
 */

namespace App\Modules\SecurityModule\Components;



/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
trait TInjectSignInFormFactory
{

    /**
     * @var \App\Modules\SecurityModule\Components\SignInFormFactory
     */
    protected $signInFormFactory;


    public function injectSignInFormFactory(SignInFormFactory $signInFormFactory)
    {
        $this->signInFormFactory = $signInFormFactory;
    }
} 