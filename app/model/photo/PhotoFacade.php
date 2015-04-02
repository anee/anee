<?php

namespace App\Model;

/**
 * Class PhotoFacade
 *
 * @author Lukáš Drahník <http://drahnik-lukas.com/>
 */
class PhotoFacade extends BaseFacade {

	public function getAll($userId)
	{
		$query = (new PhotoBaseQuery)
			->byUser($userId);

		return $this->dao->fetch($query);
	}

	public function getOne($userId, $id)
	{
		$query = (new PhotoBaseQuery)
			->byUser($userId)
			->byId($id);

		return $this->dao->fetchOne($query);
	}
}