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


class TrackRepository extends Nette\Object {

    private $tracks;

    public function __construct(EntityDao $dao)
    {
        $this->tracks = $dao;
    }

    public function save($track)
    {
        $this->tracks->save($track);
    }

    public function remove($id)
    {
        $this->tracks->delete($this->findById($id));
    }

    public function findAll()
    {
        $qb = $this->tracks->createQueryBuilder();
        $qb
            ->select('e')
            ->from('App\Model\Track', 'e')
            ->orderBy('e.date', 'DESC');

        return $qb->getQuery()->getResult();
    }

    public function findLast()
    {
        $qb = $this->tracks->createQueryBuilder();
        $qb
            ->select('e')
            ->from('App\Model\Track', 'e')
            ->orderBy('e.date', 'DESC');

        return $qb->getQuery()->setMaxResults(1)->getSingleResult();
    }

    public function findAllCount()
    {
        $qb = $this->tracks->createQueryBuilder();
        $qb
            ->select('COUNT(e.id)')
            ->from('App\Model\Track', 'e');

        return $qb->getQuery()->getSingleScalarResult();
    }

    public function findLastByCount($count)
    {
        $qb = $this->tracks->createQueryBuilder();
        $qb
            ->select('e')
            ->from('App\Model\Track', 'e')
            ->orderBy('e.date', 'DESC');

        return $qb->getQuery()->setMaxResults($count)->getResult();
    }

    public function findById($id)
    {
        $qb = $this->tracks->createQueryBuilder();
        $qb
            ->select('e')
            ->from('App\Model\Track', 'e')
            ->where('e.id = :id')
            ->setParameter('id', $id);

        return $qb->getQuery()->getOneOrNullResult();
    }

    public function distanceSum()
    {
        $distance = 0;
        foreach ($this->findAll() as $track) {
            $distance += $track->getDistance();
        }
        return $distance;
    }

    public function findByFilters($values)
    {
        if(FilterUtils::arrayContainsOrEmpty('Tracks', $values['filterCategory']) == true) {
        $qb = $this->tracks->createQueryBuilder();
        $qb
            ->select('e')
            ->from('App\Model\Track', 'e');

        if($values['search'] != '') {
            $qb
                ->join('e.place', 'a')
                ->leftJoin('e.placeTo', 'b')
                ->where('b IS NOT NULL')
                ->where($qb->expr()->like('a.name', ':search'))
                ->where($qb->expr()->like('b.name', ':search'))
                ->setParameter('search', '%' . $values['search'] . '%');
        }
        if($values['filterTime'] != '') {
            $qb
                ->andWhere('e.date >= :date')
                ->setParameter('date', FilterUtils::timeSubFilterTime($values['filterTime']));
        }
        if(empty($values['filterTransport']) != true) {
            $qb
                ->join('e.transport', 'c')
                ->andWhere('c.name IN (:transports)')
                ->setParameter('transports', $values['filterTransport']);
        }
        $qb
            ->orderBy('e.date', 'DESC');

        return $qb->getQuery()->getResult();
        } else {
            return array();
        }
    }

    public function findByFiltersCount($values)
    {
        $qb = $this->tracks->createQueryBuilder();
        $qb
            ->select('COUNT(e.id)')
            ->from('App\Model\Track', 'e');
        if($values['search'] != '') {
            $qb
                ->join('e.place', 'a')
                ->leftJoin('e.placeTo', 'b')
                ->where('b IS NOT NULL')
                ->where($qb->expr()->like('a.name', ':search'))
                ->where($qb->expr()->like('b.name', ':search'))
                ->setParameter('search', '%' . $values['search'] . '%');
        }
        if($values['filterTime'] != '') {
            $qb
                ->andWhere('e.date >= :date')
                ->setParameter('date', FilterUtils::timeSubFilterTime($values['filterTime']));
        }
        if(empty($values['filterTransport']) != true) {
            $qb
                ->join('e.transport', 'c')
                ->andWhere('c.name IN (:transports)')
                ->setParameter('transports', $values['filterTransport']);
        }
        return $qb->getQuery()->getSingleScalarResult();
    }
}