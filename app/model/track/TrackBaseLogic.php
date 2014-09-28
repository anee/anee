<?php

namespace App\Model;

use Nette;
use Kdyby\Doctrine\EntityDao;



/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class TrackBaseLogic extends Nette\Object {


	/** @var EntityDao */
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

        return $qb->getQuery()->setMaxResults(1)->getOneOrNullResult();
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
}