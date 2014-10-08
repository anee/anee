<?php

namespace App\Model;



/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class EventBaseLogic extends BaseLogic {


	public function remove($id)
	{
		$this->dao->delete($this->findOneById($id));
	}

	public function findAll($userId)
    {
        $qb = $this->dao->createQueryBuilder();
        $qb
            ->select('e')
            ->from('App\Model\Event', 'e')
            ->orderBy('e.date', 'DESC');

        return $this->addFilterByUser($qb, $userId)->getQuery()->getResult();
    }

    public function findAllCount($userId)
    {
        $qb = $this->dao->createQueryBuilder();
        $qb
            ->select('COUNT(e.id)')
            ->from('App\Model\Event', 'e');

        return $this->addFilterByUser($qb, $userId)->getQuery()->getSingleScalarResult();
    }

    public function findLast($userId)
    {
        $qb = $this->dao->createQueryBuilder();
        $qb
            ->select('e')
            ->from('App\Model\Event', 'e')
            ->orderBy('e.date', 'DESC');

        return $this->addFilterByUser($qb, $userId)->getQuery()->setMaxResults(1)->getOneOrNullResult();
    }

	public function findOneById($id)
	{
		$qb = $this->dao->createQueryBuilder();
		$qb
			->select('e')
			->from('App\Model\Event', 'e')
			->setParameter('id', $id);

		return $qb->getQuery()->getOneOrNullResult();
	}

	public function findOneByIdAndUserId($id, $userId)
	{
		$qb = $this->dao->createQueryBuilder();
		$qb
			->select('e')
			->from('App\Model\Event', 'e')
			->where('e.id = :id')
			->setParameter('id', $id);

		return $this->addFilterByUser($qb, $userId)->getQuery()->getOneOrNullResult();
	}

    public function distanceSum($userId)
    {
        $distance = 0;
        foreach ($this->findAll($userId) as $event) {
            $distance += $event->getDistance();
        }
        return $distance;
    }
}