<?php

namespace App\Model;



/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class UserBaseLogic extends BaseLogic {


	public function remove($id)
	{
		$this->dao->delete($this->findOneById($id));
	}

	public function findOneById($id)
	{
		$qb = $this->dao->createQueryBuilder();
		$qb
			->select('e')
			->from('App\Model\User', 'e')
			->where('e.id = :id')
			->setParameter('id', $id);

		return $qb->getQuery()->getOneOrNullResult();
	}

	public function findOneByEmail($email)
	{
		$qb = $this->dao->createQueryBuilder();
		$qb
			->select('e')
			->from('App\Model\User', 'e')
			->where('e.email = :email')
			->setParameter('email', $email);

		return $qb->getQuery()->getOneOrNullResult();
	}
} 