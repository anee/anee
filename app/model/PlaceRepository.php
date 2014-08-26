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

class PlaceRepository extends Nette\Object {

    private $places;

    public function __construct(EntityDao $dao)
    {
        $this->places = $dao;
    }

    public function save($work)
    {
        $this->places->save($work);
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
            ->orderBy('e.id', 'DESC');

        return $qb->getQuery()->getResult();
    }

    public function findById($id)
    {
        $qb = $this->places->createQueryBuilder();
        $qb
            ->select('e')
            ->from('App\Model\Place', 'e')
            ->where('e.id = :id')
            ->setParameter('id', $id);

        return $qb->getQuery()->getSingleResult();
    }

    public function findByFilters($values)
    {
        $qb = $this->places->createQueryBuilder();
        $qb
            ->select('e')
            ->from('App\Model\Place', 'e');

        if($values['search'] != '') {
            $qb
                ->where($qb->expr()->like('e.name', ':name'))
                ->setParameter('name', '%' . $values['search'] . '%');
        }
        $qb
            ->orderBy('e.id', 'DESC');


        return $qb->getQuery()->getResult();
    }
}