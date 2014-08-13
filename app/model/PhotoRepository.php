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
use App\Utils\TimeUtils;


class PhotoRepository extends Nette\Object {

    private $photos;

    public function __construct(EntityDao $dao)
    {
        $this->photos = $dao;
    }

    public function save($photo)
    {
        $this->photos->save($photo);
    }

    public function findLast()
    {
        return $this->photos->findOneBy(array(), array('id' => 'DESC'), 1);
    }

    public function findLastByCount($count)
    {
        return $this->photos->findBy(array(), array('id' => 'DESC'), $count);
    }

    public function findFromEnd($position)
    {
        $counter = 0;
        $photos = $this->photos->findBy(array(), array('id' => 'DESC'));

        foreach($photos as $photo) {
            $counter ++;
            if ($counter == $position)
                return $photo;
            }
        return NULL;
    }

    public function findAll()
    {
        return $this->photos->findBy(array(), array('id' => 'DESC'));
    }

    public function findById($id)
    {
        return $this->photos->find($id);
    }

    public function remove($id)
    {
        $this->photos->delete($this->findById($id));
    }

    public function findByFilters($values)
    {
        if($values['filterCategory'] == 'Photos' || $values['filterCategory'] == '') {

            $qb = $this->photos->createQueryBuilder();
            $qb
                ->select('e')
                ->from('App\Model\Photo', 'e');

            if($values['search'] != '') {
                $qb
                    ->where($qb->expr()->like('e.eventFrom', ':search'))
                    ->orWhere($qb->expr()->like('e.eventTo', ':search'))
                    ->setParameter('search', '%' . $values['search'] . '%');
            }
            if($values['filterTime'] != '') {
                $qb
                    ->andWhere('e.date >= :date')
                    ->setParameter('date', TimeUtils::timeSubFilterTime($values['filterTime']));
            }
            $qb
                ->orderBy('e.id', 'DESC');

            return $qb->getQuery()->getResult();
        } else {
            return array();
        }
    }
}