<?php

namespace App\Model;

use Kdyby\Doctrine\QueryBuilder;

/**
 * Class UserBaseQuery
 *
 * @author Lukáš Drahník <http://drahnik-lukas.com/>
 */
class UserBaseQuery extends BaseQuery {


	public function byUsername($username)
	{
		$this->filter[] = function (QueryBuilder $qb) use ($username) {
			$qb
				->andWhere('e.username = :username')
				->setParameter('username', $username);
		};
		return $this;
	}

	protected function addBaseSelect(QueryBuilder $qb)
	{
		return $qb->select('e')->from('App\Model\User', 'e');
	}
}