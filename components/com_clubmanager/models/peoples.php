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
class ClubmanagerModelPeoples extends JModelList
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
                'firstname', 'a.firstname',
                'lastname', 'a.lastname',
                'salutation', 'a.salutation',
                'gender', 'a.gender',
                'nickname', 'a.nickname',
                'birthdate', 'a.birthdate',
                'memberclub', 'a.memberclub',
                'memberno', 'a.memberno',
                'phone1', 'a.phone1',
                'phone2', 'a.phone2',
                'phone3', 'a.phone3',
                'email1', 'a.email1',
                'email2', 'a.email2',
                'email3', 'a.email3',
                'street', 'a.street',
                'postalcode', 'a.postalcode',
                'city', 'a.city',
                'county', 'a.county',
                'country', 'a.country',
                'district', 'a.district',
                'website', 'a.website',
                'function', 'a.function',
                'role', 'a.role',
                'newsletter', 'a.newsletter',
                'iban', 'a.iban',
                'bic', 'a.bic',
                'picture', 'a.picture',
                'died', 'a.died',
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

		$query->from('`#__clubmanager_people` AS a');

		
    // Join over the users for the checked out user.
    $query->select('uc.name AS editor');
    $query->join('LEFT', '#__users AS uc ON uc.id=a.checked_out');
    
		// Join over the foreign key 'salutation'
		$query->select('#__clubmanager_salutation_1861911.name AS salutations_name_1861911');
		$query->join('LEFT', '#__clubmanager_salutation AS #__clubmanager_salutation_1861911 ON #__clubmanager_salutation_1861911.id = a.salutation');
		// Join over the foreign key 'gender'
		$query->select('#__clubmanager_gender_1861903.name AS genders_name_1861903');
		$query->join('LEFT', '#__clubmanager_gender AS #__clubmanager_gender_1861903 ON #__clubmanager_gender_1861903.id = a.gender');
		// Join over the foreign key 'memberclub'
		$query->select('#__clubmanager_club_1861916.name AS clubs_name_1861916');
		$query->join('LEFT', '#__clubmanager_club AS #__clubmanager_club_1861916 ON #__clubmanager_club_1861916.id = a.memberclub');
		// Join over the foreign key 'postalcode'
		$query->select('#__clubmanager_city_1861925.postalcode AS citys_postalcode_1861925');
		$query->join('LEFT', '#__clubmanager_city AS #__clubmanager_city_1861925 ON #__clubmanager_city_1861925.id = a.postalcode');
		// Join over the foreign key 'city'
		$query->select('#__clubmanager_city_1861926.name AS citys_name_1861926');
		$query->join('LEFT', '#__clubmanager_city AS #__clubmanager_city_1861926 ON #__clubmanager_city_1861926.name = a.city');
		// Join over the foreign key 'county'
		$query->select('#__clubmanager_county_1861927.name AS counties_name_1861927');
		$query->join('LEFT', '#__clubmanager_county AS #__clubmanager_county_1861927 ON #__clubmanager_county_1861927.id = a.county');
		// Join over the foreign key 'country'
		$query->select('#__clubmanager_country_1861928.name AS countries_name_1861928');
		$query->join('LEFT', '#__clubmanager_country AS #__clubmanager_country_1861928 ON #__clubmanager_country_1861928.id = a.country');
		// Join over the foreign key 'district'
		$query->select('#__clubmanager_district_1861929.name AS districts_name_1861929');
		$query->join('LEFT', '#__clubmanager_district AS #__clubmanager_district_1861929 ON #__clubmanager_district_1861929.id = a.district');
		// Join over the foreign key 'role'
		$query->select('#__clubmanager_role_1861932.name AS roles_name_1861932');
		$query->join('LEFT', '#__clubmanager_role AS #__clubmanager_role_1861932 ON #__clubmanager_role_1861932.id = a.role');
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
				$query->where('( a.fullname LIKE '.$search.'  OR  a.firstname LIKE '.$search.'  OR  a.lastname LIKE '.$search.'  OR  a.nickname LIKE '.$search.'  OR  a.memberno LIKE '.$search.'  OR  a.phone1 LIKE '.$search.'  OR  a.email1 LIKE '.$search.'  OR  a.street LIKE '.$search.'  OR  a.iban LIKE '.$search.'  OR  a.bic LIKE '.$search.'  OR  a.comment LIKE '.$search.' )');
			}
		}

		

		//Filtering gender
		$filter_gender = $this->state->get("filter.gender");
		if ($filter_gender) {
			$query->where("a.gender = '".$db->escape($filter_gender)."'");
		}

		//Filtering memberclub
		$filter_memberclub = $this->state->get("filter.memberclub");
		if ($filter_memberclub) {
			$query->where("a.memberclub = '".$db->escape($filter_memberclub)."'");
		}

		//Filtering postalcode
		$filter_postalcode = $this->state->get("filter.postalcode");
		if ($filter_postalcode) {
			$query->where("a.postalcode = '".$db->escape($filter_postalcode)."'");
		}

		//Filtering city
		$filter_city = $this->state->get("filter.city");
		if ($filter_city) {
			$query->where("a.city = '".$db->escape($filter_city)."'");
		}

		//Filtering role
		$filter_role = $this->state->get("filter.role");
		if ($filter_role) {
			$query->where("a.role = '".$db->escape($filter_role)."'");
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
	

			if (isset($item->salutation) && $item->salutation != '') {
				if(is_object($item->salutation)){
					$item->salutation = JArrayHelper::fromObject($item->salutation);
				}
				$values = (is_array($item->salutation)) ? $item->salutation : explode(',',$item->salutation);

				$textValue = array();
				foreach ($values as $value){
					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query
							->select($db->quoteName('name'))
							->from('`#__clubmanager_salutation`')
							->where($db->quoteName('id') . ' = ' . $db->quote($db->escape($value)));
					$db->setQuery($query);
					$results = $db->loadObject();
					if ($results) {
						$textValue[] = $results->name;
					}
				}

			$item->salutation = !empty($textValue) ? implode(', ', $textValue) : $item->salutation;

			}

			if (isset($item->gender) && $item->gender != '') {
				if(is_object($item->gender)){
					$item->gender = JArrayHelper::fromObject($item->gender);
				}
				$values = (is_array($item->gender)) ? $item->gender : explode(',',$item->gender);

				$textValue = array();
				foreach ($values as $value){
					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query
							->select($db->quoteName('name'))
							->from('`#__clubmanager_gender`')
							->where($db->quoteName('id') . ' = ' . $db->quote($db->escape($value)));
					$db->setQuery($query);
					$results = $db->loadObject();
					if ($results) {
						$textValue[] = $results->name;
					}
				}

			$item->gender = !empty($textValue) ? implode(', ', $textValue) : $item->gender;

			}

			if (isset($item->memberclub) && $item->memberclub != '') {
				if(is_object($item->memberclub)){
					$item->memberclub = JArrayHelper::fromObject($item->memberclub);
				}
				$values = (is_array($item->memberclub)) ? $item->memberclub : explode(',',$item->memberclub);

				$textValue = array();
				foreach ($values as $value){
					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query
							->select($db->quoteName('name'))
							->from('`#__clubmanager_club`')
							->where($db->quoteName('id') . ' = ' . $db->quote($db->escape($value)));
					$db->setQuery($query);
					$results = $db->loadObject();
					if ($results) {
						$textValue[] = $results->name;
					}
				}

			$item->memberclub = !empty($textValue) ? implode(', ', $textValue) : $item->memberclub;

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
							->where($db->quoteName('name') . ' = ' . $db->quote($db->escape($value)));
					$db->setQuery($query);
					$results = $db->loadObject();
					if ($results) {
						$textValue[] = $results->name;
					}
				}

			$item->city = !empty($textValue) ? implode(', ', $textValue) : $item->city;

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

			if (isset($item->role) && $item->role != '') {
				if(is_object($item->role)){
					$item->role = JArrayHelper::fromObject($item->role);
				}
				$values = (is_array($item->role)) ? $item->role : explode(',',$item->role);

				$textValue = array();
				foreach ($values as $value){
					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query
							->select($db->quoteName('name'))
							->from('`#__clubmanager_role`')
							->where($db->quoteName('id') . ' = ' . $db->quote($db->escape($value)));
					$db->setQuery($query);
					$results = $db->loadObject();
					if ($results) {
						$textValue[] = $results->name;
					}
				}

			$item->role = !empty($textValue) ? implode(', ', $textValue) : $item->role;

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
