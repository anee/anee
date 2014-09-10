<?php

namespace App\Model;

use Nette;



/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class TransportFacade extends Nette\Object
{
    /** @var \App\Model\TransportRepository */
    public $transportRepository;

    public function __construct(TransportRepository $transportRepository)
    {
        $this->transportRepository = $transportRepository;
    }

    public function createTransport($values)
    {

    }

    public function removeTransport($id)
    {

    }
}