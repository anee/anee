<?php

namespace App\Model;

use Doctrine\ORM\Query;

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

	public function findOneByIdArray($id)
	{
		$qb = $this->dao->createQueryBuilder();
		$qb
			->select('e')
			->from('App\Model\User', 'e')
			->where('e.id = :id')
			->setParameter('id', $id);

		return $qb->getQuery()->getArrayResult(Query::HYDRATE_ARRAY);
	}

	public function findOneSignIn($input)
	{
		$qb = $this->dao->createQueryBuilder();
		$qb
			->select('e')
			->from('App\Model\User', 'e')
			->where('e.username = :input')
			->orWhere('e.email = :input')
			->setParameter('input', $input);

		return $qb->getQuery()->getOneOrNullResult();
	}

	public function findOneByUsername($username)
	{
		$qb = $this->dao->createQueryBuilder();
		$qb
			->select('e')
			->from('App\Model\User', 'e')
			->where('e.username = :username')
			->setParameter('username', $username);

		return $qb->getQuery()->getOneOrNullResult();
	}
} 