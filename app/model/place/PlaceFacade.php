<?php

namespace App\Model;

/**
 * Class PlaceFacade
 *
 * @author Lukáš Drahník <http://drahnik-lukas.com/>
 */
class PlaceFacade extends BaseFacade {

	public function getAll($userId)
	{
		$query = (new PlaceBaseQuery)
			->byUser($userId);

		return $this->dao->fetch($query);
	}

	public function getOne($userId, $id)
	{
		$query = (new PlaceBaseQuery)
			->byUser($userId)
			->byId($id);

		return $this->dao->fetchOne($query);
	}
}