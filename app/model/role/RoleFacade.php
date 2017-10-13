<?php

namespace App\Model;

/**
 * Class UserFacade
 *
 * @author Lukáš Drahník <http://drahnik-lukas.com/>
 */
class RoleFacade extends BaseFacade {

	public function getAll()
	{
		$query = (new RoleBaseQuery);

		return $this->dao->fetch($query);
	}

    public function getOneByName($name)
    {
        $query = (new RoleBaseQuery)
            ->byName($name);

        return $this->dao->fetchOne($query);
    }

}