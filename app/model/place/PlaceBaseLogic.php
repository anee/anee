<?php

namespace App\Model;



/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class PlaceBaseLogic extends BaseLogic {

	
    public function remove($id)
    {
        $this->dao->delete($this->findOneById($id));
    }

    public function findAll($userId)
    {
        $qb = $this->dao->createQueryBuilder();
        $qb
            ->select('e')
            ->from('App\Model\Place', 'e')
            ->orderBy('e.name', 'ASC');

        return $this->filterByUser($qb, $userId)->getQuery()->getResult();
    }

    public function findAllCount($userId)
    {
        $qb = $this->dao->createQueryBuilder();
        $qb
            ->select('COUNT(e.id)')
            ->from('App\Model\Place', 'e');

        return $this->filterByUser($qb, $userId)->getQuery()->getSingleScalarResult();
    }

    public function findOneById($id)
    {
        $qb = $this->dao->createQueryBuilder();
        $qb
            ->select('e')
            ->from('App\Model\Place', 'e')
            ->where('e.id = :id')
            ->setParameter('id', $id);

        return $qb->getQuery()->getOneOrNullResult();
    }

	public function findOneByIdAndUserId($id, $userId)
	{
		$qb = $this->dao->createQueryBuilder();
		$qb
			->select('e')
			->from('App\Model\Place', 'e')
			->where('e.id = :id')
			->setParameter('id', $id);

		return $this->filterByUser($qb, $userId)->getQuery()->getOneOrNullResult();
	}
}