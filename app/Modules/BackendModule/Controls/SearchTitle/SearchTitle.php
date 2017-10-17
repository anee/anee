<?php


namespace App\Modules\BackendModule\Controls;


use App\Searching\SearchResults;
use Nette\Application\UI\Control;
use ViewKeeper\ViewKeeper;

/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
interface ISearchTitleFactory
{

	/**
	 * @param array $values
	 * @param SearchResults $results
	 * @return SearchTitle
	 */
	function create(Array $values, SearchResults $results);
}

/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class SearchTitle extends Control {

	/**
	 * @var \ViewKeeper\ViewKeeper
	 */
	public $keeper;

	/**
	 * @var array
	 */
	private $values;

	/**
	 * @var SearchResults
	 */
	private $results;

	public function __construct(Array $values, SearchResults $results, ViewKeeper $keeper)
	{
		$this->keeper = $keeper;
		$this->values = $values;
		$this->results = $results;
	}

	public function render()
	{
		$this->template->setFile($this->keeper->getView('Backend:' . 'SearchTitle', 'controls'));
		
		$this->template->addFilter(NULL, 'App\TemplateHelpers::loader');

		$this->template->results = $this->results;
		$this->template->values = $this->values;

		$this->template->render();
	}
} 