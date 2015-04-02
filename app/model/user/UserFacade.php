<?php

namespace App\Model;

/**
 * Class UserFacade
 *
 * @author Lukáš Drahník <http://drahnik-lukas.com/>
 */
class UserFacade extends BaseFacade {

	public function getAll()
	{
		$query = (new UserBaseQuery);

		return $this->dao->fetch($query);
	}

	public function getOneByUsername($username)
	{
		$query = (new UserBaseQuery)
			->byUsername($username);

		return $this->dao->fetchOne($query);
	}
}