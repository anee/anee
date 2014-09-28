<?php

namespace App\Model;

use Nette;
use Kdyby\Doctrine\EntityDao;



/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class PlaceBaseLogic extends Nette\Object {


	/** @var EntityDao */
    private $places;

    public function __construct(EntityDao $places)
    {
        $this->places = $places;
    }

    public function save($place)
    {
        $this->places->save($place);
    }

    public function remove($id)
    {
        $this->places->delete($this->findById($id));
    }

    public function findAll()
    {
        $qb = $this->places->createQueryBuilder();
        $qb
            ->select('e')
            ->from('App\Model\Place', 'e')
            ->orderBy('e.name', 'ASC');

        return $qb->getQuery()->getResult();
    }

    public function findAllCount()
    {
        $qb = $this->places->createQueryBuilder();
        $qb
            ->select('COUNT(e.id)')
            ->from('App\Model\Place', 'e');

        return $qb->getQuery()->getSingleScalarResult();
    }

    public function findById($id)
    {
        $qb = $this->places->createQueryBuilder();
        $qb
            ->select('e')
            ->from('App\Model\Place', 'e')
            ->where('e.id = :id')
            ->setParameter('id', $id);

        return $qb->getQuery()->getOneOrNullResult();
    }
}