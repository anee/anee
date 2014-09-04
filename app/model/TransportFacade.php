<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Lukas
 * Date: 1.3.14
 * Time: 18:43
 * To change this template use File | Settings | File Templates.
 */

namespace App\Model;

use Nette;


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