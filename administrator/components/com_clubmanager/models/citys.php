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
class ClubmanagerModelCitys extends JModelList {

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
     */
    protected function populateState($ordering = null, $direction = null) {
        // Initialise variables.
        $app = JFactory::getApplication('administrator');

        // Load the filter state.
        $search = $app->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
        $this->setState('filter.search', $search);

        $published = $app->getUserStateFromRequest($this->context . '.filter.state', 'filter_published', '', 'string');
        $this->setState('filter.state', $published);

        
		//Filtering district
		$this->setState('filter.district', $app->getUserStateFromRequest($this->context.'.filter.district', 'filter_district', '', 'string'));

		//Filtering county
		$this->setState('filter.county', $app->getUserStateFromRequest($this->context.'.filter.county', 'filter_county', '', 'string'));

		//Filtering country
		$this->setState('filter.country', $app->getUserStateFromRequest($this->context.'.filter.country', 'filter_country', '', 'string'));


        // Load the parameters.
        $params = JComponentHelper::getParams('com_clubmanager');
        $this->setState('params', $params);

        // List state information.
        parent::populateState('a.name', 'asc');
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
        $query->from('`#__clubmanager_city` AS a');

        
		// Join over the users for the checked out user
		$query->select("uc.name AS editor");
		$query->join("LEFT", "#__users AS uc ON uc.id=a.checked_out");
		// Join over the foreign key 'district'
		$query->select('#__clubmanager_district_1861772.name AS districts_name_1861772');
		$query->join('LEFT', '#__clubmanager_district AS #__clubmanager_district_1861772 ON #__clubmanager_district_1861772.id = a.district');
		// Join over the foreign key 'county'
		$query->select('#__clubmanager_county_1861773.name AS counties_name_1861773');
		$query->join('LEFT', '#__clubmanager_county AS #__clubmanager_county_1861773 ON #__clubmanager_county_1861773.id = a.county');
		// Join over the foreign key 'country'
		$query->select('#__clubmanager_country_1861774.name AS countries_name_1861774');
		$query->join('LEFT', '#__clubmanager_country AS #__clubmanager_country_1861774 ON #__clubmanager_country_1861774.id = a.country');
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
                $query->where('( a.name LIKE '.$search.'  OR  a.postalcode LIKE '.$search.'  OR  a.district LIKE '.$search.'  OR  a.county LIKE '.$search.'  OR  a.country LIKE '.$search.'  OR  a.default LIKE '.$search.'  OR  a.comment LIKE '.$search.' )');
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
		}
        return $items;
    }

}
