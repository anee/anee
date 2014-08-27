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
use App\Utils\FilterUtils;


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

    public function remove($id)
    {
        $this->photos->delete($this->findById($id));
    }

    public function findLast()
    {
        $qb = $this->photos->createQueryBuilder();
        $qb
            ->select('e')
            ->from('App\Model\Photo', 'e')
            ->orderBy('e.id', 'DESC');

        return $qb->getQuery()->setMaxResults(1)->getSingleResult();
    }

    public function findLastByCount($count)
    {
        $qb = $this->photos->createQueryBuilder();
        $qb
            ->select('e')
            ->from('App\Model\Photo', 'e')
            ->orderBy('e.id', 'DESC');

        return $qb->getQuery()->setMaxResults($count)->getResult();
    }

    public function findAll()
    {
        $qb = $this->photos->createQueryBuilder();
        $qb
            ->select('e')
            ->from('App\Model\Photo', 'e')
            ->orderBy('e.id', 'DESC');

        return $qb->getQuery()->getResult();
    }

    public function findById($id)
    {
        $qb = $this->photos->createQueryBuilder();
        $qb
            ->select('e')
            ->from('App\Model\Photos', 'e')
            ->where('e.id = :id')
            ->setParameter('id', $id);

        return $qb->getQuery()->getSingleResult();
    }

    public function findByFilters($values)
    {
        $qb = $this->photos->createQueryBuilder();
        $qb
            ->select('e')
            ->from('App\Model\Photo', 'e');

        if($values['search'] != '') {
            $qb
                //track
                ->leftJoin('e.track', 'b')
                ->where('b IS NOT NULL')
                ->join('b.place', 'g')
                ->leftJoin('b.placeTo','h')
                ->where('h IS NOT NULL')
                //event
                ->leftJoin('e.event', 'o')
                ->where('o IS NOT NULL')
                ->join('o.place', 'p')
                ->leftJoin('p.placeTo','q')
                ->where('q IS NOT NULL')
                //place
                ->leftJoin('e.place', 'a')
                ->where('a IS NOT NULL')
                ->where($qb->expr()->like('g.name', ':search'))
                ->orWhere($qb->expr()->like('h.name', ':search'))
                ->orWhere($qb->expr()->like('o.name', ':search'))
                ->orWhere($qb->expr()->like('p.name', ':search'))
                ->orWhere($qb->expr()->like('a.name', ':search'))
                ->setParameter('search', '%' . $values['search'] . '%');
        }
        if($values['filterTime'] != '') {
            $qb
                ->andWhere('e.date >= :date')
                ->setParameter('date', FilterUtils::timeSubFilterTime($values['filterTime']));
        }
        $qb
            ->orderBy('e.id', 'DESC');
        return $qb->getQuery()->getResult();
    }
}