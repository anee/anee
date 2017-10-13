<?php

namespace App\Model;

use Kdyby\Doctrine\QueryBuilder;

/**
 * Class UserBaseQuery
 *
 * @author Lukáš Drahník <http://drahnik-lukas.com/>
 */
class RoleBaseQuery extends BaseQuery {

    public function byName($name)
    {
        $this->filter[] = function (QueryBuilder $qb) use ($name) {
            $qb
                ->andWhere('e.name = :name')
                ->setParameter('name', $name);
        };
        return $this;
    }

    protected function addBaseSelect(QueryBuilder $qb)
    {
        return $qb->select('e')->from('App\Model\Role', 'e');
    }
}