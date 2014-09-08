<?php
/**
 * Created by PhpStorm.
 * User: Phantom
 * Date: 8.9.14
 * Time: 17:01
 */

namespace App\Modules\FrontModule\Forms;


trait TInjectSearchFormFactory
{

    /**
     * @var \App\Modules\FrontModule\Forms\SearchFormFactory
     */
    protected $searchFormFactory;


    public function injectSearchFormFactory(\App\Modules\FrontModule\Forms\SearchFormFactory $searchFormFactory)
    {
        $this->searchFormFactory = $searchFormFactory;
    }
} 