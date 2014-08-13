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

    public function findAll()
    {
        return $this->places->findBy(array(), array('id' => 'DESC'));
    }

    public function findById($id)
    {
        return $this->places->find($id);
    }

    public function remove($id)
    {
        $this->places->delete($this->findById($id));
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
                    ->orderBy('e.id', 'DESC');

                return $qb->getQuery()->getResult();
        } else {
            return array();
        }
    }
}