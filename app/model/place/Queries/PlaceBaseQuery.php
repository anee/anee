<?php

namespace App\Model;

use Kdyby\Doctrine\QueryBuilder;

/**
 * Class PlaceBaseQuery
 *
 * @author Lukáš Drahník <http://drahnik-lukas.com/>
 */
class PlaceBaseQuery extends BaseQuery {


	protected function addBaseSelect(QueryBuilder $qb)
	{
		return $qb->select('e')->from('App\Model\Place', 'e');
	}
}