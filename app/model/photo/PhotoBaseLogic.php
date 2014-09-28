<?php

namespace App\Model;

use Nette;
use Kdyby\Doctrine\EntityDao;



/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class PhotoBaseLogic extends  Nette\Object {


	/** @var EntityDao */
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
            ->orderBy('e.date', 'DESC');

        return $qb->getQuery()->setMaxResults(1)->getSingleResult();
    }

    public function findLastByCount($count)
    {
        $qb = $this->photos->createQueryBuilder();
        $qb
            ->select('e')
            ->from('App\Model\Photo', 'e')
            ->orderBy('e.date', 'DESC');

        return $qb->getQuery()->setMaxResults($count)->getResult();
    }

    public function findAll()
    {
        $qb = $this->photos->createQueryBuilder();
        $qb
            ->select('e')
            ->from('App\Model\Photo', 'e')
            ->orderBy('e.date', 'DESC');

        return $qb->getQuery()->getResult();
    }

    public function findAllCount()
    {
        $qb = $this->photos->createQueryBuilder();
        $qb
            ->select('COUNT(e.id)')
            ->from('App\Model\Photo', 'e');

        return $qb->getQuery()->getSingleScalarResult();
    }

    public function findById($id)
    {
        $qb = $this->photos->createQueryBuilder();
        $qb
            ->select('e')
            ->from('App\Model\Photos', 'e')
            ->where('e.id = :id')
            ->setParameter('id', $id);

        return $qb->getQuery()->getOneOrNullResult();
    }
}