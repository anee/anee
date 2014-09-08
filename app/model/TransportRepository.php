<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Lukas
 * Date: 8.4.14
 * Time: 0:28
 * To change this template use File | Settings | File Templates.
 */

namespace App\Model;

use Nette;
use Kdyby\Doctrine\EntityDao;

class TransportRepository extends Nette\Object {

    private $transport;

    public function __construct(EntityDao $dao)
    {
        $this->transport = $dao;
    }

    public function save($transport)
    {
        $this->transport->save($transport);
    }

    public function remove($id)
    {
        $this->transport->delete($this->findById($id));
    }

    public function findAll()
    {
        $qb = $this->transport->createQueryBuilder();
        $qb
            ->select('e')
            ->from('App\Model\Transport', 'e')
            ->orderBy('e.name', 'ASC');

        return $qb->getQuery()->getResult();
    }

    public function findById($id)
    {
        $qb = $this->transport->createQueryBuilder();
        $qb
            ->select('e')
            ->from('App\Model\Transport', 'e')
            ->where('e.id = :id')
            ->setParameter('id', $id);

        return $qb->getQuery()->getOneOrNullResult();
    }
}