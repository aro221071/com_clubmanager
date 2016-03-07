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
class ClubmanagerModelClubs extends JModelList {

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
     */
    protected function populateState($ordering = null, $direction = null) {
        // Initialise variables.
        $app = JFactory::getApplication('administrator');

        // Load the filter state.
        $search = $app->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
        $this->setState('filter.search', $search);

        $published = $app->getUserStateFromRequest($this->context . '.filter.state', 'filter_published', '', 'string');
        $this->setState('filter.state', $published);

        
		//Filtering union
		$this->setState('filter.union', $app->getUserStateFromRequest($this->context.'.filter.union', 'filter_union', '', 'string'));

		//Filtering country
		$this->setState('filter.country', $app->getUserStateFromRequest($this->context.'.filter.country', 'filter_country', '', 'string'));

		//Filtering county
		$this->setState('filter.county', $app->getUserStateFromRequest($this->context.'.filter.county', 'filter_county', '', 'string'));

		//Filtering district
		$this->setState('filter.district', $app->getUserStateFromRequest($this->context.'.filter.district', 'filter_district', '', 'string'));

		//Filtering unioncountry
		$this->setState('filter.unioncountry', $app->getUserStateFromRequest($this->context.'.filter.unioncountry', 'filter_unioncountry', '', 'string'));

		//Filtering unioncounty
		$this->setState('filter.unioncounty', $app->getUserStateFromRequest($this->context.'.filter.unioncounty', 'filter_unioncounty', '', 'string'));

		//Filtering uniondistrict
		$this->setState('filter.uniondistrict', $app->getUserStateFromRequest($this->context.'.filter.uniondistrict', 'filter_uniondistrict', '', 'string'));


        // Load the parameters.
        $params = JComponentHelper::getParams('com_clubmanager');
        $this->setState('params', $params);

        // List state information.
        parent::populateState('a.praefix', 'asc');
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
        $query->from('`#__clubmanager_club` AS a');

        
		// Join over the users for the checked out user
		$query->select("uc.name AS editor");
		$query->join("LEFT", "#__users AS uc ON uc.id=a.checked_out");
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
		$query->select('#__clubmanager_uniondistrict_1861760.fullname AS uniondistricts_fullname_1861760');
		$query->join('LEFT', '#__clubmanager_uniondistrict AS #__clubmanager_uniondistrict_1861760 ON #__clubmanager_uniondistrict_1861760.id = a.uniondistrict');
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
                $query->where('( a.praefix LIKE '.$search.'  OR  a.union LIKE '.$search.'  OR  a.name LIKE '.$search.'  OR  a.street LIKE '.$search.'  OR  a.postalcode LIKE '.$search.'  OR  a.city LIKE '.$search.'  OR  a.country LIKE '.$search.'  OR  a.county LIKE '.$search.'  OR  a.district LIKE '.$search.'  OR  a.ownclub LIKE '.$search.'  OR  a.zvrno LIKE '.$search.'  OR  a.website LIKE '.$search.'  OR  a.phone1 LIKE '.$search.'  OR  a.phone2 LIKE '.$search.'  OR  a.phone3 LIKE '.$search.'  OR  a.email1 LIKE '.$search.'  OR  a.email2 LIKE '.$search.'  OR  a.email3 LIKE '.$search.'  OR  a.location LIKE '.$search.'  OR  a.distance LIKE '.$search.'  OR  a.unioncountry LIKE '.$search.'  OR  a.unioncounty LIKE '.$search.'  OR  a.uniondistrict LIKE '.$search.'  OR  a.uniondistrictno LIKE '.$search.'  OR  a.default LIKE '.$search.'  OR  a.comment LIKE '.$search.' )');
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

			if (isset($oneItem->union)) {
				$values = explode(',', $oneItem->union);

				$textValue = array();
				foreach ($values as $value){
					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query
							->select($db->quoteName('shortname'))
							->from('`#__clubmanager_union`')
							->where($db->quoteName('id') . ' = '. $db->quote($db->escape($value)));
					$db->setQuery($query);
					$results = $db->loadObject();
					if ($results) {
						$textValue[] = $results->shortname;
					}
				}

			$oneItem->union = !empty($textValue) ? implode(', ', $textValue) : $oneItem->union;

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
							->where($db->quoteName('id') . ' = '. $db->quote($db->escape($value)));
					$db->setQuery($query);
					$results = $db->loadObject();
					if ($results) {
						$textValue[] = $results->name;
					}
				}

			$oneItem->city = !empty($textValue) ? implode(', ', $textValue) : $oneItem->city;

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

			if (isset($oneItem->unioncountry)) {
				$values = explode(',', $oneItem->unioncountry);

				$textValue = array();
				foreach ($values as $value){
					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query
							->select($db->quoteName('name'))
							->from('`#__clubmanager_unioncountry`')
							->where($db->quoteName('id') . ' = '. $db->quote($db->escape($value)));
					$db->setQuery($query);
					$results = $db->loadObject();
					if ($results) {
						$textValue[] = $results->name;
					}
				}

			$oneItem->unioncountry = !empty($textValue) ? implode(', ', $textValue) : $oneItem->unioncountry;

			}

			if (isset($oneItem->unioncounty)) {
				$values = explode(',', $oneItem->unioncounty);

				$textValue = array();
				foreach ($values as $value){
					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query
							->select($db->quoteName('name'))
							->from('`#__clubmanager_unioncounty`')
							->where($db->quoteName('id') . ' = '. $db->quote($db->escape($value)));
					$db->setQuery($query);
					$results = $db->loadObject();
					if ($results) {
						$textValue[] = $results->name;
					}
				}

			$oneItem->unioncounty = !empty($textValue) ? implode(', ', $textValue) : $oneItem->unioncounty;

			}

			if (isset($oneItem->uniondistrict)) {
				$values = explode(',', $oneItem->uniondistrict);

				$textValue = array();
				foreach ($values as $value){
					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query
							->select($db->quoteName('fullname'))
							->from('`#__clubmanager_uniondistrict`')
							->where($db->quoteName('id') . ' = '. $db->quote($db->escape($value)));
					$db->setQuery($query);
					$results = $db->loadObject();
					if ($results) {
						$textValue[] = $results->fullname;
					}
				}

			$oneItem->uniondistrict = !empty($textValue) ? implode(', ', $textValue) : $oneItem->uniondistrict;

			}
		}
        return $items;
    }

}
