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
trait TInjectRegisterInFormFactory
{

    /**
     * @var \App\Modules\SecurityModule\Components\RegisterInFormFactory
     */
    protected $registerInFormFactory;


    public function injectRegistrationFormFactory(RegisterInFormFactory $registerInFormFactory)
    {
        $this->registerInFormFactory = $registerInFormFactory;
    }
} 