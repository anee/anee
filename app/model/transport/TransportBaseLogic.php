<?php

namespace App\Model;




/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class TransportBaseLogic extends BaseLogic {

	

    public function remove($id)
    {
        $this->dao->delete($this->findById($id));
    }

    public function findAll($userId)
    {
        $qb = $this->dao->createQueryBuilder();
        $qb
            ->select('e')
            ->from('App\Model\Transport', 'e')
            ->orderBy('e.name', 'ASC');

        return $this->addFilterByUser($qb, $userId)->getQuery()->getResult();
    }

    public function findById($id)
    {
        $qb = $this->dao->createQueryBuilder();
        $qb
            ->select('e')
            ->from('App\Model\Transport', 'e')
            ->where('e.id = :id')
            ->setParameter('id', $id);

        return $qb->getQuery()->getOneOrNullResult();
    }

	public function findByIdAndUserId($id, $userId)
	{
		$qb = $this->dao->createQueryBuilder();
		$qb
			->select('e')
			->from('App\Model\Transport', 'e')
			->where('e.id = :id')
			->setParameter('id', $id);

		return $this->addFilterByUser($qb, $userId)->getQuery()->getOneOrNullResult();
	}
}