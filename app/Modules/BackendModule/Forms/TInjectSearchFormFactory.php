<?php
/**
 * Created by PhpStorm.
 * User: Phantom
 * Date: 8.9.14
 * Time: 17:01
 */

namespace App\Modules\BackendModule\Forms;



/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
trait TInjectSearchFormFactory
{

    /**
     * @var \App\Modules\BackendModule\Forms\SearchFormFactory
     */
    protected $searchFormFactory;


    public function injectSearchFormFactory(SearchFormFactory $searchFormFactory)
    {
        $this->searchFormFactory = $searchFormFactory;
    }
} 