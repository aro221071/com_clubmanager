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
class ClubmanagerModelUniondistricts extends JModelList {

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
                'shortname', 'a.shortname',
                'name', 'a.name',
                'unioncountry', 'a.unioncountry',
                'unioncounty', 'a.unioncounty',
                'website', 'a.website',
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

        
		//Filtering unioncountry
		$this->setState('filter.unioncountry', $app->getUserStateFromRequest($this->context.'.filter.unioncountry', 'filter_unioncountry', '', 'string'));

		//Filtering unioncounty
		$this->setState('filter.unioncounty', $app->getUserStateFromRequest($this->context.'.filter.unioncounty', 'filter_unioncounty', '', 'string'));


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
        $query->from('`#__clubmanager_uniondistrict` AS a');

        
		// Join over the users for the checked out user
		$query->select("uc.name AS editor");
		$query->join("LEFT", "#__users AS uc ON uc.id=a.checked_out");

		// Join over the foreign key 'unioncountry'
		$query->select('#__clubmanager_unioncountry_1861640.name AS unioncountrys_name_1861640');
		$query->join('LEFT', '#__clubmanager_unioncountry AS #__clubmanager_unioncountry_1861640 ON #__clubmanager_unioncountry_1861640.id = a.unioncountry');

		// Join over the foreign key 'unioncounty'
		$query->select('#__clubmanager_unioncounty_1861667.name AS unioncounties_name_1861667');
		$query->join('LEFT', '#__clubmanager_unioncounty AS #__clubmanager_unioncounty_1861667 ON #__clubmanager_unioncounty_1861667.id = a.unioncounty');

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
                $query->where('( a.fullname LIKE '.$search.'  OR  a.shortname LIKE '.$search.'  OR  a.name LIKE '.$search.'  OR  a.unioncountry LIKE '.$search.'  OR  a.unioncounty LIKE '.$search.'  OR  a.website LIKE '.$search.'  OR  a.default LIKE '.$search.'  OR  a.comment LIKE '.$search.' )');
            }
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
		}
        return $items;
    }

}
