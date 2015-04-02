<?php

namespace App\Model;

use Kdyby\Doctrine\QueryBuilder;

/**
 * Class PhotoBaseQuery
 *
 * @author Lukáš Drahník <http://drahnik-lukas.com/>
 */
class PhotoBaseQuery extends BaseQuery {


	protected function addBaseSelect(QueryBuilder $qb)
	{
		return $qb->select('e')->from('App\Model\Photo', 'e');
	}
}