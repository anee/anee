<?php

namespace App\Model;



/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class PhotoBaseLogic extends BaseLogic {

	
    public function remove($id)
    {
        $this->dao->delete($this->findOneById($id));
    }

    public function findLast($userId)
    {
        $qb = $this->dao->createQueryBuilder();
        $qb
            ->select('e')
            ->from('App\Model\Photo', 'e')
            ->orderBy('e.date', 'DESC');

        return $this->addFilterByUser($qb, $userId)->getQuery()->setMaxResults(1)->getSingleResult();
    }

    public function findLastByCount($count, $userId)
    {
        $qb = $this->dao->createQueryBuilder();
        $qb
            ->select('e')
            ->from('App\Model\Photo', 'e')
            ->orderBy('e.date', 'DESC');

        return $this->addFilterByUser($qb, $userId)->getQuery()->setMaxResults($count)->getResult();
    }

    public function findAll($userId)
    {
        $qb = $this->dao->createQueryBuilder();
        $qb
            ->select('e')
            ->from('App\Model\Photo', 'e')
            ->orderBy('e.date', 'DESC');

        return $this->addFilterByUser($qb, $userId)->getQuery()->getResult();
    }

    public function findAllCount($userId)
    {
        $qb = $this->dao->createQueryBuilder();
        $qb
            ->select('COUNT(e.id)')
            ->from('App\Model\Photo', 'e');

        return $this->addFilterByUser($qb, $userId)->getQuery()->getSingleScalarResult();
    }

	public function findOneById($id)
	{
		$qb = $this->dao->createQueryBuilder();
		$qb
			->select('e')
			->from('App\Model\Photo', 'e')
			->where('e.id = :id')
			->setParameter('id', $id);

		return $qb->getQuery()->getOneOrNullResult();
	}

    public function findOneByIdAndUserId($id, $userId)
    {
        $qb = $this->dao->createQueryBuilder();
        $qb
            ->select('e')
            ->from('App\Model\Photo', 'e')
            ->where('e.id = :id')
            ->setParameter('id', $id);

        return $this->addFilterByUser($qb, $userId)->getQuery()->getOneOrNullResult();
    }
}