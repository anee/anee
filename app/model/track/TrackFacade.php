<?php

namespace App\Model;

/**
 * Class TrackFacade
 *
 * @author Lukáš Drahník <http://drahnik-lukas.com/>
 */
class TrackFacade extends BaseFacade {

	public function getAll($userId)
	{
		$query = (new TrackBaseQuery)
			->byUser($userId);

		return $this->dao->fetch($query);
	}

	public function getOne($userId, $id)
	{
		$query = (new TrackBaseQuery)
			->byUser($userId)
			->byId($id);

		return $this->dao->fetchOne($query);
	}
}