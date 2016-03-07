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
class ClubmanagerModelClubs extends JModelList
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
                'fullname', 'a.fullname',
                'praefix', 'a.praefix',
                'union', 'a.union',
                'name', 'a.name',
                'street', 'a.street',
                'postalcode', 'a.postalcode',
                'city', 'a.city',
                'country', 'a.country',
                'county', 'a.county',
                'district', 'a.district',
                'ownclub', 'a.ownclub',
                'zvrno', 'a.zvrno',
                'website', 'a.website',
                'phone1', 'a.phone1',
                'phone2', 'a.phone2',
                'phone3', 'a.phone3',
                'email1', 'a.email1',
                'email2', 'a.email2',
                'email3', 'a.email3',
                'location', 'a.location',
                'distance', 'a.distance',
                'ordering', 'a.ordering',
                'unioncountry', 'a.unioncountry',
                'unioncounty', 'a.unioncounty',
                'uniondistrict', 'a.uniondistrict',
                'uniondistrictno', 'a.uniondistrictno',
                'default', 'a.default',
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

		$query->from('`#__clubmanager_club` AS a');

		
    // Join over the users for the checked out user.
    $query->select('uc.name AS editor');
    $query->join('LEFT', '#__users AS uc ON uc.id=a.checked_out');
    
		// Join over the foreign key 'union'
		$query->select('#__clubmanager_union_1861707.shortname AS unions_shortname_1861707');
		$query->join('LEFT', '#__clubmanager_union AS #__clubmanager_union_1861707 ON #__clubmanager_union_1861707.id = a.union');
		// Join over the foreign key 'postalcode'
		$query->select('#__clubmanager_city_1861711.postalcode AS citys_postalcode_1861711');
		$query->join('LEFT', '#__clubmanager_city AS #__clubmanager_city_1861711 ON #__clubmanager_city_1861711.id = a.postalcode');
		// Join over the foreign key 'city'
		$query->select('#__clubmanager_city_1861714.name AS citys_name_1861714');
		$query->join('LEFT', '#__clubmanager_city AS #__clubmanager_city_1861714 ON #__clubmanager_city_1861714.id = a.city');
		// Join over the foreign key 'country'
		$query->select('#__clubmanager_country_1861712.name AS countries_name_1861712');
		$query->join('LEFT', '#__clubmanager_country AS #__clubmanager_country_1861712 ON #__clubmanager_country_1861712.id = a.country');
		// Join over the foreign key 'county'
		$query->select('#__clubmanager_county_1861715.name AS counties_name_1861715');
		$query->join('LEFT', '#__clubmanager_county AS #__clubmanager_county_1861715 ON #__clubmanager_county_1861715.id = a.county');
		// Join over the foreign key 'district'
		$query->select('#__clubmanager_district_1861716.name AS districts_name_1861716');
		$query->join('LEFT', '#__clubmanager_district AS #__clubmanager_district_1861716 ON #__clubmanager_district_1861716.id = a.district');
		// Join over the foreign key 'unioncountry'
		$query->select('#__clubmanager_unioncountry_1861752.name AS unioncountrys_name_1861752');
		$query->join('LEFT', '#__clubmanager_unioncountry AS #__clubmanager_unioncountry_1861752 ON #__clubmanager_unioncountry_1861752.id = a.unioncountry');
		// Join over the foreign key 'unioncounty'
		$query->select('#__clubmanager_unioncounty_1861759.name AS unioncounties_name_1861759');
		$query->join('LEFT', '#__clubmanager_unioncounty AS #__clubmanager_unioncounty_1861759 ON #__clubmanager_unioncounty_1861759.id = a.unioncounty');
		// Join over the foreign key 'uniondistrict'
		$query->select('#__clubmanager_uniondistrict_1861760.name AS uniondistricts_name_1861760');
		$query->join('LEFT', '#__clubmanager_uniondistrict AS #__clubmanager_uniondistrict_1861760 ON #__clubmanager_uniondistrict_1861760.id = a.uniondistrict');
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
				$query->where('( a.praefix LIKE '.$search.'  OR  a.name LIKE '.$search.'  OR  a.street LIKE '.$search.'  OR  a.zvrno LIKE '.$search.'  OR  a.website LIKE '.$search.'  OR  a.phone1 LIKE '.$search.'  OR  a.phone2 LIKE '.$search.'  OR  a.phone3 LIKE '.$search.'  OR  a.email1 LIKE '.$search.'  OR  a.email2 LIKE '.$search.'  OR  a.email3 LIKE '.$search.'  OR  a.location LIKE '.$search.'  OR  a.uniondistrictno LIKE '.$search.'  OR  a.comment LIKE '.$search.' )');
			}
		}

		

		//Filtering union
		$filter_union = $this->state->get("filter.union");
		if ($filter_union) {
			$query->where("a.union = '".$db->escape($filter_union)."'");
		}

		//Filtering country
		$filter_country = $this->state->get("filter.country");
		if ($filter_country) {
			$query->where("a.country = '".$db->escape($filter_country)."'");
		}

		//Filtering county
		$filter_county = $this->state->get("filter.county");
		if ($filter_county) {
			$query->where("a.county = '".$db->escape($filter_county)."'");
		}

		//Filtering district
		$filter_district = $this->state->get("filter.district");
		if ($filter_district) {
			$query->where("a.district = '".$db->escape($filter_district)."'");
		}

		//Filtering unioncountry
		$filter_unioncountry = $this->state->get("filter.unioncountry");
		if ($filter_unioncountry) {
			$query->where("a.unioncountry = '".$db->escape($filter_unioncountry)."'");
		}

		//Filtering unioncounty
		$filter_unioncounty = $this->state->get("filter.unioncounty");
		if ($filter_unioncounty) {
			$query->where("a.unioncounty = '".$db->escape($filter_unioncounty)."'");
		}

		//Filtering uniondistrict
		$filter_uniondistrict = $this->state->get("filter.uniondistrict");
		if ($filter_uniondistrict) {
			$query->where("a.uniondistrict = '".$db->escape($filter_uniondistrict)."'");
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
	

			if (isset($item->union) && $item->union != '') {
				if(is_object($item->union)){
					$item->union = JArrayHelper::fromObject($item->union);
				}
				$values = (is_array($item->union)) ? $item->union : explode(',',$item->union);

				$textValue = array();
				foreach ($values as $value){
					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query
							->select($db->quoteName('shortname'))
							->from('`#__clubmanager_union`')
							->where($db->quoteName('id') . ' = ' . $db->quote($db->escape($value)));
					$db->setQuery($query);
					$results = $db->loadObject();
					if ($results) {
						$textValue[] = $results->shortname;
					}
				}

			$item->union = !empty($textValue) ? implode(', ', $textValue) : $item->union;

			}

			if (isset($item->postalcode) && $item->postalcode != '') {
				if(is_object($item->postalcode)){
					$item->postalcode = JArrayHelper::fromObject($item->postalcode);
				}
				$values = (is_array($item->postalcode)) ? $item->postalcode : explode(',',$item->postalcode);

				$textValue = array();
				foreach ($values as $value){
					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query
							->select($db->quoteName('postalcode'))
							->from('`#__clubmanager_city`')
							->where($db->quoteName('id') . ' = ' . $db->quote($db->escape($value)));
					$db->setQuery($query);
					$results = $db->loadObject();
					if ($results) {
						$textValue[] = $results->postalcode;
					}
				}

			$item->postalcode = !empty($textValue) ? implode(', ', $textValue) : $item->postalcode;

			}

			if (isset($item->city) && $item->city != '') {
				if(is_object($item->city)){
					$item->city = JArrayHelper::fromObject($item->city);
				}
				$values = (is_array($item->city)) ? $item->city : explode(',',$item->city);

				$textValue = array();
				foreach ($values as $value){
					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query
							->select($db->quoteName('name'))
							->from('`#__clubmanager_city`')
							->where($db->quoteName('id') . ' = ' . $db->quote($db->escape($value)));
					$db->setQuery($query);
					$results = $db->loadObject();
					if ($results) {
						$textValue[] = $results->name;
					}
				}

			$item->city = !empty($textValue) ? implode(', ', $textValue) : $item->city;

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

			if (isset($item->unioncountry) && $item->unioncountry != '') {
				if(is_object($item->unioncountry)){
					$item->unioncountry = JArrayHelper::fromObject($item->unioncountry);
				}
				$values = (is_array($item->unioncountry)) ? $item->unioncountry : explode(',',$item->unioncountry);

				$textValue = array();
				foreach ($values as $value){
					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query
							->select($db->quoteName('name'))
							->from('`#__clubmanager_unioncountry`')
							->where($db->quoteName('id') . ' = ' . $db->quote($db->escape($value)));
					$db->setQuery($query);
					$results = $db->loadObject();
					if ($results) {
						$textValue[] = $results->name;
					}
				}

			$item->unioncountry = !empty($textValue) ? implode(', ', $textValue) : $item->unioncountry;

			}

			if (isset($item->unioncounty) && $item->unioncounty != '') {
				if(is_object($item->unioncounty)){
					$item->unioncounty = JArrayHelper::fromObject($item->unioncounty);
				}
				$values = (is_array($item->unioncounty)) ? $item->unioncounty : explode(',',$item->unioncounty);

				$textValue = array();
				foreach ($values as $value){
					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query
							->select($db->quoteName('name'))
							->from('`#__clubmanager_unioncounty`')
							->where($db->quoteName('id') . ' = ' . $db->quote($db->escape($value)));
					$db->setQuery($query);
					$results = $db->loadObject();
					if ($results) {
						$textValue[] = $results->name;
					}
				}

			$item->unioncounty = !empty($textValue) ? implode(', ', $textValue) : $item->unioncounty;

			}

			if (isset($item->uniondistrict) && $item->uniondistrict != '') {
				if(is_object($item->uniondistrict)){
					$item->uniondistrict = JArrayHelper::fromObject($item->uniondistrict);
				}
				$values = (is_array($item->uniondistrict)) ? $item->uniondistrict : explode(',',$item->uniondistrict);

				$textValue = array();
				foreach ($values as $value){
					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query
							->select($db->quoteName('name'))
							->from('`#__clubmanager_uniondistrict`')
							->where($db->quoteName('id') . ' = ' . $db->quote($db->escape($value)));
					$db->setQuery($query);
					$results = $db->loadObject();
					if ($results) {
						$textValue[] = $results->name;
					}
				}

			$item->uniondistrict = !empty($textValue) ? implode(', ', $textValue) : $item->uniondistrict;

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
