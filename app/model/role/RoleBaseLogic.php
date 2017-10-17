<?php

namespace App\Model;

use Doctrine\ORM\Query;

/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class RoleBaseLogic extends BaseLogic {


	public function remove($id)
	{
		$this->dao->delete($this->findOneById($id));
	}

    public function findOneById($id)
    {
        $qb = $this->dao->createQueryBuilder();
        $qb
            ->select('e')
            ->from('App\Model\Role', 'e')
            ->where('e.id = :id')
            ->setParameter('id', $id);

        return $qb->getQuery()->getOneOrNullResult();
    }

} 