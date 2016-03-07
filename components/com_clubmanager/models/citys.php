<?php

/**
 * @version     1.0.0
 * @package     com_clubmanager
 * @copyright   Copyright (C) 2015. Alle Rechte vorbehalten.
 * @license     GNU General Public License Version 2 oder später; siehe LICENSE.txt
 * @author      Roman Artelsmair <roman@artelsmair.at> - http://www.artelsmair.at
 */
defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');

/**
 * Methods supporting a list of Clubmanager records.
 */
class ClubmanagerModelCitys extends JModelList
{

	/**
	 * Constructor.
	 *
	 * @param    array    An optional associative array of configuration settings.
	 *
	 * @see        JController
	 * @since      1.6
	 */
	public function __construct($config = array())
	{
		if (empty($config['filter_fields']))
		{
			$config['filter_fields'] = array(
				                'id', 'a.id',
                'name', 'a.name',
                'postalcode', 'a.postalcode',
                'district', 'a.district',
                'county', 'a.county',
                'country', 'a.country',
                'default', 'a.default',
                'ordering', 'a.ordering',
                'state', 'a.state',
                'comment', 'a.comment',
                'created_by', 'a.created_by',

			);
		}
		parent::__construct($config);
	}

	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @since    1.6
	 */
	protected function populateState($ordering = null, $direction = null)
	{


		// Initialise variables.
		$app = JFactory::getApplication();

		// List state information
		$limit = $app->getUserStateFromRequest('global.list.limit', 'limit', $app->getCfg('list_limit'));
		$this->setState('list.limit', $limit);

		$limitstart = $app->input->getInt('limitstart', 0);
		$this->setState('list.start', $limitstart);

		if ($list = $app->getUserStateFromRequest($this->context . '.list', 'list', array(), 'array'))
		{
			foreach ($list as $name => $value)
			{
				// Extra validations
				switch ($name)
				{
					case 'fullordering':
						$orderingParts = explode(' ', $value);

						if (count($orderingParts) >= 2)
						{
							// Latest part will be considered the direction
							$fullDirection = end($orderingParts);

							if (in_array(strtoupper($fullDirection), array('ASC', 'DESC', '')))
							{
								$this->setState('list.direction', $fullDirection);
							}

							unset($orderingParts[count($orderingParts) - 1]);

							// The rest will be the ordering
							$fullOrdering = implode(' ', $orderingParts);

							if (in_array($fullOrdering, $this->filter_fields))
							{
								$this->setState('list.ordering', $fullOrdering);
							}
						}
						else
						{
							$this->setState('list.ordering', $ordering);
							$this->setState('list.direction', $direction);
						}
						break;

					case 'ordering':
						if (!in_array($value, $this->filter_fields))
						{
							$value = $ordering;
						}
						break;

					case 'direction':
						if (!in_array(strtoupper($value), array('ASC', 'DESC', '')))
						{
							$value = $direction;
						}
						break;

					case 'limit':
						$limit = $value;
						break;

					// Just to keep the default case
					default:
						$value = $value;
						break;
				}

				$this->setState('list.' . $name, $value);
			}
		}

		// Receive & set filters
		if ($filters = $app->getUserStateFromRequest($this->context . '.filter', 'filter', array(), 'array'))
		{
			foreach ($filters as $name => $value)
			{
				$this->setState('filter.' . $name, $value);
			}
		}

		$ordering = $app->input->get('filter_order');
		if (!empty($ordering))
		{
			$list             = $app->getUserState($this->context . '.list');
			$list['ordering'] = $app->input->get('filter_order');
			$app->setUserState($this->context . '.list', $list);
		}

		$orderingDirection = $app->input->get('filter_order_Dir');
		if (!empty($orderingDirection))
		{
			$list              = $app->getUserState($this->context . '.list');
			$list['direction'] = $app->input->get('filter_order_Dir');
			$app->setUserState($this->context . '.list', $list);
		}

		$list = $app->getUserState($this->context . '.list');

		if (empty($list['ordering']))
{
	$list['ordering'] = 'ordering';
}

if (empty($list['direction']))
{
	$list['direction'] = 'asc';
}

		$this->setState('list.ordering', $list['ordering']);
		$this->setState('list.direction', $list['direction']);
	}

	/**
	 * Build an SQL query to load the list data.
	 *
	 * @return    JDatabaseQuery
	 * @since    1.6
	 */
	protected function getListQuery()
	{
		// Create a new query object.
		$db    = $this->getDbo();
		$query = $db->getQuery(true);

		// Select the required fields from the table.
		$query
			->select(
				$this->getState(
					'list.select', 'DISTINCT a.*'
				)
			);

		$query->from('`#__clubmanager_city` AS a');

		
    // Join over the users for the checked out user.
    $query->select('uc.name AS editor');
    $query->join('LEFT', '#__users AS uc ON uc.id=a.checked_out');
    
		// Join over the foreign key 'district'
		$query->select('#__clubmanager_district_1861772.name AS districts_name_1861772');
		$query->join('LEFT', '#__clubmanager_district AS #__clubmanager_district_1861772 ON #__clubmanager_district_1861772.id = a.district');
		// Join over the foreign key 'county'
		$query->select('#__clubmanager_county_1861773.name AS counties_name_1861773');
		$query->join('LEFT', '#__clubmanager_county AS #__clubmanager_county_1861773 ON #__clubmanager_county_1861773.id = a.county');
		// Join over the foreign key 'country'
		$query->select('#__clubmanager_country_1861774.name AS countries_name_1861774');
		$query->join('LEFT', '#__clubmanager_country AS #__clubmanager_country_1861774 ON #__clubmanager_country_1861774.id = a.country');
		// Join over the created by field 'created_by'
		$query->join('LEFT', '#__users AS created_by ON created_by.id = a.created_by');

		
if (!JFactory::getUser()->authorise('core.edit.state', 'com_clubmanager'))
{
	$query->where('a.state = 1');
}

		// Filter by search in title
		$search = $this->getState('filter.search');
		if (!empty($search))
		{
			if (stripos($search, 'id:') === 0)
			{
				$query->where('a.id = ' . (int) substr($search, 3));
			}
			else
			{
				$search = $db->Quote('%' . $db->escape($search, true) . '%');
				$query->where('( a.name LIKE '.$search.'  OR  a.postalcode LIKE '.$search.'  OR  a.comment LIKE '.$search.' )');
			}
		}

		

		//Filtering district
		$filter_district = $this->state->get("filter.district");
		if ($filter_district) {
			$query->where("a.district = '".$db->escape($filter_district)."'");
		}

		//Filtering county
		$filter_county = $this->state->get("filter.county");
		if ($filter_county) {
			$query->where("a.county = '".$db->escape($filter_county)."'");
		}

		//Filtering country
		$filter_country = $this->state->get("filter.country");
		if ($filter_country) {
			$query->where("a.country = '".$db->escape($filter_country)."'");
		}

		// Add the list ordering clause.
		$orderCol  = $this->state->get('list.ordering');
		$orderDirn = $this->state->get('list.direction');
		if ($orderCol && $orderDirn)
		{
			$query->order($db->escape($orderCol . ' ' . $orderDirn));
		}

		return $query;
	}

	public function getItems()
	{
		$items = parent::getItems();
		foreach($items as $item){
	

			if (isset($item->district) && $item->district != '') {
				if(is_object($item->district)){
					$item->district = JArrayHelper::fromObject($item->district);
				}
				$values = (is_array($item->district)) ? $item->district : explode(',',$item->district);

				$textValue = array();
				foreach ($values as $value){
					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query
							->select($db->quoteName('name'))
							->from('`#__clubmanager_district`')
							->where($db->quoteName('id') . ' = ' . $db->quote($db->escape($value)));
					$db->setQuery($query);
					$results = $db->loadObject();
					if ($results) {
						$textValue[] = $results->name;
					}
				}

			$item->district = !empty($textValue) ? implode(', ', $textValue) : $item->district;

			}

			if (isset($item->county) && $item->county != '') {
				if(is_object($item->county)){
					$item->county = JArrayHelper::fromObject($item->county);
				}
				$values = (is_array($item->county)) ? $item->county : explode(',',$item->county);

				$textValue = array();
				foreach ($values as $value){
					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query
							->select($db->quoteName('name'))
							->from('`#__clubmanager_county`')
							->where($db->quoteName('id') . ' = ' . $db->quote($db->escape($value)));
					$db->setQuery($query);
					$results = $db->loadObject();
					if ($results) {
						$textValue[] = $results->name;
					}
				}

			$item->county = !empty($textValue) ? implode(', ', $textValue) : $item->county;

			}

			if (isset($item->country) && $item->country != '') {
				if(is_object($item->country)){
					$item->country = JArrayHelper::fromObject($item->country);
				}
				$values = (is_array($item->country)) ? $item->country : explode(',',$item->country);

				$textValue = array();
				foreach ($values as $value){
					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query
							->select($db->quoteName('name'))
							->from('`#__clubmanager_country`')
							->where($db->quoteName('id') . ' = ' . $db->quote($db->escape($value)));
					$db->setQuery($query);
					$results = $db->loadObject();
					if ($results) {
						$textValue[] = $results->name;
					}
				}

			$item->country = !empty($textValue) ? implode(', ', $textValue) : $item->country;

			}
}

		return $items;
	}

	/**
	 * Overrides the default function to check Date fields format, identified by
	 * "_dateformat" suffix, and erases the field if it's not correct.
	 */
	protected function loadFormData()
	{
		$app              = JFactory::getApplication();
		$filters          = $app->getUserState($this->context . '.filter', array());
		$error_dateformat = false;
		foreach ($filters as $key => $value)
		{
			if (strpos($key, '_dateformat') && !empty($value) && !$this->isValidDate($value))
			{
				$filters[$key]    = '';
				$error_dateformat = true;
			}
		}
		if ($error_dateformat)
		{
			$app->enqueueMessage(JText::_("COM_CLUBMANAGER_SEARCH_FILTER_DATE_FORMAT"), "warning");
			$app->setUserState($this->context . '.filter', $filters);
		}

		return parent::loadFormData();
	}

	/**
	 * Checks if a given date is valid and in an specified format (YYYY-MM-DD)
	 *
	 * @param string Contains the date to be checked
	 *
	 */
	private function isValidDate($date)
	{
		return preg_match("/^(19|20)\d\d[-](0[1-9]|1[012])[-](0[1-9]|[12][0-9]|3[01])$/", $date) && date_create($date);
	}

}
