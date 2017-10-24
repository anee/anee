<?php

namespace App\Model;

/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class RoleBaseLogic extends BaseLogic {


	public function remove($id)
	{
		$this->dao->delete($this->findOneById($id));
	}

    public function findAll()
    {
        $qb = $this->dao->createQueryBuilder();
        $qb
            ->select('e')
            ->from('App\Model\Role', 'e');

        return $qb->getQuery()->getResult();
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

    public function findOneByName($name)
    {
        $qb = $this->dao->createQueryBuilder();
        $qb
            ->select('e')
            ->from('App\Model\Role', 'e')
            ->where('e.name = :name')
            ->setParameter('name', $name);

        return $qb->getQuery()->getOneOrNullResult();
    }

} 