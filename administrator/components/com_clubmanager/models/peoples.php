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
class ClubmanagerModelPeoples extends JModelList {

    /**
     * Constructor.
     *
     * @param    array    An optional associative array of configuration settings.
     * @see        JController
     * @since    1.6
     */
    public function __construct($config = array()) {
        if (empty($config['filter_fields'])) {
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
     */
    protected function populateState($ordering = null, $direction = null) {
        // Initialise variables.
        $app = JFactory::getApplication('administrator');

        // Load the filter state.
        $search = $app->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
        $this->setState('filter.search', $search);

        $published = $app->getUserStateFromRequest($this->context . '.filter.state', 'filter_published', '', 'string');
        $this->setState('filter.state', $published);

        
		//Filtering gender
		$this->setState('filter.gender', $app->getUserStateFromRequest($this->context.'.filter.gender', 'filter_gender', '', 'string'));

		//Filtering memberclub
		$this->setState('filter.memberclub', $app->getUserStateFromRequest($this->context.'.filter.memberclub', 'filter_memberclub', '', 'string'));

		//Filtering postalcode
		$this->setState('filter.postalcode', $app->getUserStateFromRequest($this->context.'.filter.postalcode', 'filter_postalcode', '', 'string'));

		//Filtering city
		$this->setState('filter.city', $app->getUserStateFromRequest($this->context.'.filter.city', 'filter_city', '', 'string'));

		//Filtering role
		$this->setState('filter.role', $app->getUserStateFromRequest($this->context.'.filter.role', 'filter_role', '', 'string'));


        // Load the parameters.
        $params = JComponentHelper::getParams('com_clubmanager');
        $this->setState('params', $params);

        // List state information.
        parent::populateState('a.fullname', 'asc');
    }

    /**
     * Method to get a store id based on model configuration state.
     *
     * This is necessary because the model is used by the component and
     * different modules that might need different sets of data or different
     * ordering requirements.
     *
     * @param	string		$id	A prefix for the store id.
     * @return	string		A store id.
     * @since	1.6
     */
    protected function getStoreId($id = '') {
        // Compile the store id.
        $id.= ':' . $this->getState('filter.search');
        $id.= ':' . $this->getState('filter.state');

        return parent::getStoreId($id);
    }

    /**
     * Build an SQL query to load the list data.
     *
     * @return	JDatabaseQuery
     * @since	1.6
     */
    protected function getListQuery() {
        // Create a new query object.
        $db = $this->getDbo();
        $query = $db->getQuery(true);

        // Select the required fields from the table.
        $query->select(
                $this->getState(
                        'list.select', 'DISTINCT a.*'
                )
        );
        $query->from('`#__clubmanager_people` AS a');

        
		// Join over the users for the checked out user
		$query->select("uc.name AS editor");
		$query->join("LEFT", "#__users AS uc ON uc.id=a.checked_out");
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
		// Join over the user field 'created_by'
		$query->select('created_by.name AS created_by');
		$query->join('LEFT', '#__users AS created_by ON created_by.id = a.created_by');

        

		// Filter by published state
		$published = $this->getState('filter.state');
		if (is_numeric($published)) {
			$query->where('a.state = ' . (int) $published);
		} else if ($published === '') {
			$query->where('(a.state IN (0, 1))');
		}

        // Filter by search in title
        $search = $this->getState('filter.search');
        if (!empty($search)) {
            if (stripos($search, 'id:') === 0) {
                $query->where('a.id = ' . (int) substr($search, 3));
            } else {
                $search = $db->Quote('%' . $db->escape($search, true) . '%');
                $query->where('( a.fullname LIKE '.$search.'  OR  a.firstname LIKE '.$search.'  OR  a.lastname LIKE '.$search.'  OR  a.salutation LIKE '.$search.'  OR  a.gender LIKE '.$search.'  OR  a.nickname LIKE '.$search.'  OR  a.birthdate LIKE '.$search.'  OR  a.memberclub LIKE '.$search.'  OR  a.memberno LIKE '.$search.'  OR  a.phone1 LIKE '.$search.'  OR  a.email1 LIKE '.$search.'  OR  a.street LIKE '.$search.'  OR  a.postalcode LIKE '.$search.'  OR  a.city LIKE '.$search.'  OR  a.role LIKE '.$search.'  OR  a.newsletter LIKE '.$search.'  OR  a.iban LIKE '.$search.'  OR  a.bic LIKE '.$search.'  OR  a.picture LIKE '.$search.'  OR  a.comment LIKE '.$search.' )');
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
        $orderCol = $this->state->get('list.ordering');
        $orderDirn = $this->state->get('list.direction');
        if ($orderCol && $orderDirn) {
            $query->order($db->escape($orderCol . ' ' . $orderDirn));
        }

        return $query;
    }

    public function getItems() {
        $items = parent::getItems();
        
		foreach ($items as $oneItem) {

			if (isset($oneItem->salutation)) {
				$values = explode(',', $oneItem->salutation);

				$textValue = array();
				foreach ($values as $value){
					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query
							->select($db->quoteName('name'))
							->from('`#__clubmanager_salutation`')
							->where($db->quoteName('id') . ' = '. $db->quote($db->escape($value)));
					$db->setQuery($query);
					$results = $db->loadObject();
					if ($results) {
						$textValue[] = $results->name;
					}
				}

			$oneItem->salutation = !empty($textValue) ? implode(', ', $textValue) : $oneItem->salutation;

			}

			if (isset($oneItem->gender)) {
				$values = explode(',', $oneItem->gender);

				$textValue = array();
				foreach ($values as $value){
					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query
							->select($db->quoteName('name'))
							->from('`#__clubmanager_gender`')
							->where($db->quoteName('id') . ' = '. $db->quote($db->escape($value)));
					$db->setQuery($query);
					$results = $db->loadObject();
					if ($results) {
						$textValue[] = $results->name;
					}
				}

			$oneItem->gender = !empty($textValue) ? implode(', ', $textValue) : $oneItem->gender;

			}

			if (isset($oneItem->memberclub)) {
				$values = explode(',', $oneItem->memberclub);

				$textValue = array();
				foreach ($values as $value){
					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query
							->select($db->quoteName('fullname'))
							->from('`#__clubmanager_club`')
							->where($db->quoteName('id') . ' = '. $db->quote($db->escape($value)));
					$db->setQuery($query);
					$results = $db->loadObject();
					if ($results) {
						$textValue[] = $results->fullname;
					}
				}

			$oneItem->memberclub = !empty($textValue) ? implode(', ', $textValue) : $oneItem->memberclub;

			}

			if (isset($oneItem->postalcode)) {
				$values = explode(',', $oneItem->postalcode);

				$textValue = array();
				foreach ($values as $value){
					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query
							->select($db->quoteName('postalcode'))
							->from('`#__clubmanager_city`')
							->where($db->quoteName('id') . ' = '. $db->quote($db->escape($value)));
					$db->setQuery($query);
					$results = $db->loadObject();
					if ($results) {
						$textValue[] = $results->postalcode;
					}
				}

			$oneItem->postalcode = !empty($textValue) ? implode(', ', $textValue) : $oneItem->postalcode;

			}

			if (isset($oneItem->city)) {
				$values = explode(',', $oneItem->city);

				$textValue = array();
				foreach ($values as $value){
					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query
							->select($db->quoteName('name'))
							->from('`#__clubmanager_city`')
							->where($db->quoteName('name') . ' = '. $db->quote($db->escape($value)));
					$db->setQuery($query);
					$results = $db->loadObject();
					if ($results) {
						$textValue[] = $results->name;
					}
				}

			$oneItem->city = !empty($textValue) ? implode(', ', $textValue) : $oneItem->city;

			}

			if (isset($oneItem->county)) {
				$values = explode(',', $oneItem->county);

				$textValue = array();
				foreach ($values as $value){
					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query
							->select($db->quoteName('name'))
							->from('`#__clubmanager_county`')
							->where($db->quoteName('id') . ' = '. $db->quote($db->escape($value)));
					$db->setQuery($query);
					$results = $db->loadObject();
					if ($results) {
						$textValue[] = $results->name;
					}
				}

			$oneItem->county = !empty($textValue) ? implode(', ', $textValue) : $oneItem->county;

			}

			if (isset($oneItem->country)) {
				$values = explode(',', $oneItem->country);

				$textValue = array();
				foreach ($values as $value){
					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query
							->select($db->quoteName('name'))
							->from('`#__clubmanager_country`')
							->where($db->quoteName('id') . ' = '. $db->quote($db->escape($value)));
					$db->setQuery($query);
					$results = $db->loadObject();
					if ($results) {
						$textValue[] = $results->name;
					}
				}

			$oneItem->country = !empty($textValue) ? implode(', ', $textValue) : $oneItem->country;

			}

			if (isset($oneItem->district)) {
				$values = explode(',', $oneItem->district);

				$textValue = array();
				foreach ($values as $value){
					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query
							->select($db->quoteName('name'))
							->from('`#__clubmanager_district`')
							->where($db->quoteName('id') . ' = '. $db->quote($db->escape($value)));
					$db->setQuery($query);
					$results = $db->loadObject();
					if ($results) {
						$textValue[] = $results->name;
					}
				}

			$oneItem->district = !empty($textValue) ? implode(', ', $textValue) : $oneItem->district;

			}

			if (isset($oneItem->role)) {
				$values = explode(',', $oneItem->role);

				$textValue = array();
				foreach ($values as $value){
					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query
							->select($db->quoteName('name'))
							->from('`#__clubmanager_role`')
							->where($db->quoteName('id') . ' = '. $db->quote($db->escape($value)));
					$db->setQuery($query);
					$results = $db->loadObject();
					if ($results) {
						$textValue[] = $results->name;
					}
				}

			$oneItem->role = !empty($textValue) ? implode(', ', $textValue) : $oneItem->role;

			}
		}
        return $items;
    }

}
