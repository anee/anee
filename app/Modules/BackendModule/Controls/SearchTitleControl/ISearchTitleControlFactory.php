<?php


namespace App\Modules\BackendModule\Controls;
use App\Searching\SearchResults;


/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
interface ISearchTitleControlFactory
{

	/**
	 * @param array $values
	 * @param SearchResults $results
	 * @return mixed
	 */
	function create(Array $values, SearchResults $results);
}