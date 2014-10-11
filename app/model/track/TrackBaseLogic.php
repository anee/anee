<?php

namespace App\Model;




/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class TrackBaseLogic extends BaseLogic {


    public function remove($id)
    {
        $this->dao->delete($this->findOneById($id));
    }

    public function findAll($userId)
    {
        $qb = $this->dao->createQueryBuilder();
        $qb
            ->select('e')
            ->from('App\Model\Track', 'e')
            ->orderBy('e.date', 'DESC');

        return $this->addFilterByUser($qb, $userId)->getQuery()->getResult();
    }

    public function findLast($userId)
    {
        $qb = $this->dao->createQueryBuilder();
        $qb
            ->select('e')
            ->from('App\Model\Track', 'e')
            ->orderBy('e.date', 'DESC');

        return $this->addFilterByUser($qb, $userId)->getQuery()->setMaxResults(1)->getOneOrNullResult();
    }

    public function findAllCount($userId)
    {
        $qb = $this->dao->createQueryBuilder();
        $qb
            ->select('COUNT(e.id)')
            ->from('App\Model\Track', 'e');

        return $this->addFilterByUser($qb, $userId)->getQuery()->getSingleScalarResult();
    }

    public function findLastByCount($count, $userId)
    {
        $qb = $this->dao->createQueryBuilder();
        $qb
            ->select('e')
            ->from('App\Model\Track', 'e')
            ->orderBy('e.date', 'DESC');

        return $this->addFilterByUser($qb, $userId)->getQuery()->setMaxResults($count)->getResult();
    }

    public function findOneById($id)
    {
        $qb = $this->dao->createQueryBuilder();
        $qb
            ->select('e')
            ->from('App\Model\Track', 'e')
            ->where('e.id = :id')
            ->setParameter('id', $id);

        return $qb->getQuery()->getOneOrNullResult();
    }

	public function findAllByUserId($userId)
	{
		$qb = $this->dao->createQueryBuilder();
		$qb
			->select('e')
			->from('App\Model\Track', 'e');

		return $this->addFilterByUser($qb, $userId)->getQuery()->getResult();
	}

	public function findOneByIdAndUserId($id, $userId)
	{
		$qb = $this->dao->createQueryBuilder();
		$qb
			->select('e')
			->from('App\Model\Track', 'e')
			->andWhere('e.id = :id')
			->setParameter('id', $id);

		return $this->addFilterByUser($qb, $userId)->getQuery()->getOneOrNullResult();
	}

	public function findOneByIdAndUsername($id, $username)
	{
		$qb = $this->dao->createQueryBuilder();
		$qb
			->select('e')
			->from('App\Model\Track', 'e')
			->andWhere('e.id = :id')
			->setParameter('id', $id);

		return $this->addFilterByUserName($qb, $username)->getQuery()->getOneOrNullResult();
	}


	public function distanceSum($userId)
    {
        $distance = 0;
        foreach ($this->findAll($userId) as $track) {
            $distance += $track->getDistance();
        }
        return $distance;
    }
}