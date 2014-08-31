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

    public function findByFilters($values)
    {
        if($values['filterCategory'] == 'Places' || $values['filterCategory'] == '') {
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
                ->orderBy('e.name', 'DESC');

            return $qb->getQuery()->getResult();
        } else {
            return array();
        }
    }

    public function findByFiltersCount($values)
    {
        $qb = $this->places->createQueryBuilder();
        $qb
            ->select('COUNT(e.id)')
            ->from('App\Model\Place', 'e');

        if($values['search'] != '') {
            $qb
                ->where($qb->expr()->like('e.name', ':name'))
                ->setParameter('name', '%' . $values['search'] . '%');
        }
        return $qb->getQuery()->getSingleScalarResult();
    }
}