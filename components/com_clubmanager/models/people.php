<?php

/**
 * @version     1.0.0
 * @package     com_clubmanager
 * @copyright   Copyright (C) 2015. Alle Rechte vorbehalten.
 * @license     GNU General Public License Version 2 oder später; siehe LICENSE.txt
 * @author      Roman Artelsmair <roman@artelsmair.at> - http://www.artelsmair.at
 */
// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.modelitem');
jimport('joomla.event.dispatcher');

/**
 * Clubmanager model.
 */
class ClubmanagerModelPeople extends JModelItem {

    /**
     * Method to auto-populate the model state.
     *
     * Note. Calling getState in this method will result in recursion.
     *
     * @since	1.6
     */
    protected function populateState() {
        $app = JFactory::getApplication('com_clubmanager');

        // Load state from the request userState on edit or from the passed variable on default
        if (JFactory::getApplication()->input->get('layout') == 'edit') {
            $id = JFactory::getApplication()->getUserState('com_clubmanager.edit.people.id');
        } else {
            $id = JFactory::getApplication()->input->get('id');
            JFactory::getApplication()->setUserState('com_clubmanager.edit.people.id', $id);
        }
        $this->setState('people.id', $id);

        // Load the parameters.
        $params = $app->getParams();
        $params_array = $params->toArray();
        if (isset($params_array['item_id'])) {
            $this->setState('people.id', $params_array['item_id']);
        }
        $this->setState('params', $params);
    }

    /**
     * Method to get an ojbect.
     *
     * @param	integer	The id of the object to get.
     *
     * @return	mixed	Object on success, false on failure.
     */
    public function &getData($id = null) {
        if ($this->_item === null) {
            $this->_item = false;

            if (empty($id)) {
                $id = $this->getState('people.id');
            }

            // Get a level row instance.
            $table = $this->getTable();

            // Attempt to load the row.
            if ($table->load($id)) {
                // Check published state.
                if ($published = $this->getState('filter.published')) {
                    if ($table->state != $published) {
                        return $this->_item;
                    }
                }

                // Convert the JTable to a clean JObject.
                $properties = $table->getProperties(1);
                $this->_item = JArrayHelper::toObject($properties, 'JObject');
            } elseif ($error = $table->getError()) {
                $this->setError($error);
            }
        }

        

			if (isset($this->_item->salutation) && $this->_item->salutation != '') {
				if(is_object($this->_item->salutation)){
					$this->_item->salutation = JArrayHelper::fromObject($this->_item->salutation);
				}
				$values = (is_array($this->_item->salutation)) ? $this->_item->salutation : explode(',',$this->_item->salutation);

				$textValue = array();
				foreach ($values as $value){
					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query
							->select('name')
							->from('`#__clubmanager_salutation`')
							->where('id = ' . $db->quote($db->escape($value)));
					$db->setQuery($query);
					$results = $db->loadObject();
					if ($results) {
						$textValue[] = $results->name;
					}
				}

			$this->_item->salutation = !empty($textValue) ? implode(', ', $textValue) : $this->_item->salutation;

			}

			if (isset($this->_item->gender) && $this->_item->gender != '') {
				if(is_object($this->_item->gender)){
					$this->_item->gender = JArrayHelper::fromObject($this->_item->gender);
				}
				$values = (is_array($this->_item->gender)) ? $this->_item->gender : explode(',',$this->_item->gender);

				$textValue = array();
				foreach ($values as $value){
					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query
							->select('name')
							->from('`#__clubmanager_gender`')
							->where('id = ' . $db->quote($db->escape($value)));
					$db->setQuery($query);
					$results = $db->loadObject();
					if ($results) {
						$textValue[] = $results->name;
					}
				}

			$this->_item->gender = !empty($textValue) ? implode(', ', $textValue) : $this->_item->gender;

			}

			if (isset($this->_item->memberclub) && $this->_item->memberclub != '') {
				if(is_object($this->_item->memberclub)){
					$this->_item->memberclub = JArrayHelper::fromObject($this->_item->memberclub);
				}
				$values = (is_array($this->_item->memberclub)) ? $this->_item->memberclub : explode(',',$this->_item->memberclub);

				$textValue = array();
				foreach ($values as $value){
					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query
							->select('name')
							->from('`#__clubmanager_club`')
							->where('id = ' . $db->quote($db->escape($value)));
					$db->setQuery($query);
					$results = $db->loadObject();
					if ($results) {
						$textValue[] = $results->name;
					}
				}

			$this->_item->memberclub = !empty($textValue) ? implode(', ', $textValue) : $this->_item->memberclub;

			}

			if (isset($this->_item->postalcode) && $this->_item->postalcode != '') {
				if(is_object($this->_item->postalcode)){
					$this->_item->postalcode = JArrayHelper::fromObject($this->_item->postalcode);
				}
				$values = (is_array($this->_item->postalcode)) ? $this->_item->postalcode : explode(',',$this->_item->postalcode);

				$textValue = array();
				foreach ($values as $value){
					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query
							->select('postalcode')
							->from('`#__clubmanager_city`')
							->where('id = ' . $db->quote($db->escape($value)));
					$db->setQuery($query);
					$results = $db->loadObject();
					if ($results) {
						$textValue[] = $results->postalcode;
					}
				}

			$this->_item->postalcode = !empty($textValue) ? implode(', ', $textValue) : $this->_item->postalcode;

			}

			if (isset($this->_item->city) && $this->_item->city != '') {
				if(is_object($this->_item->city)){
					$this->_item->city = JArrayHelper::fromObject($this->_item->city);
				}
				$values = (is_array($this->_item->city)) ? $this->_item->city : explode(',',$this->_item->city);

				$textValue = array();
				foreach ($values as $value){
					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query
							->select('name')
							->from('`#__clubmanager_city`')
							->where('name = ' . $db->quote($db->escape($value)));
					$db->setQuery($query);
					$results = $db->loadObject();
					if ($results) {
						$textValue[] = $results->name;
					}
				}

			$this->_item->city = !empty($textValue) ? implode(', ', $textValue) : $this->_item->city;

			}

			if (isset($this->_item->county) && $this->_item->county != '') {
				if(is_object($this->_item->county)){
					$this->_item->county = JArrayHelper::fromObject($this->_item->county);
				}
				$values = (is_array($this->_item->county)) ? $this->_item->county : explode(',',$this->_item->county);

				$textValue = array();
				foreach ($values as $value){
					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query
							->select('name')
							->from('`#__clubmanager_county`')
							->where('id = ' . $db->quote($db->escape($value)));
					$db->setQuery($query);
					$results = $db->loadObject();
					if ($results) {
						$textValue[] = $results->name;
					}
				}

			$this->_item->county = !empty($textValue) ? implode(', ', $textValue) : $this->_item->county;

			}

			if (isset($this->_item->country) && $this->_item->country != '') {
				if(is_object($this->_item->country)){
					$this->_item->country = JArrayHelper::fromObject($this->_item->country);
				}
				$values = (is_array($this->_item->country)) ? $this->_item->country : explode(',',$this->_item->country);

				$textValue = array();
				foreach ($values as $value){
					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query
							->select('name')
							->from('`#__clubmanager_country`')
							->where('id = ' . $db->quote($db->escape($value)));
					$db->setQuery($query);
					$results = $db->loadObject();
					if ($results) {
						$textValue[] = $results->name;
					}
				}

			$this->_item->country = !empty($textValue) ? implode(', ', $textValue) : $this->_item->country;

			}

			if (isset($this->_item->district) && $this->_item->district != '') {
				if(is_object($this->_item->district)){
					$this->_item->district = JArrayHelper::fromObject($this->_item->district);
				}
				$values = (is_array($this->_item->district)) ? $this->_item->district : explode(',',$this->_item->district);

				$textValue = array();
				foreach ($values as $value){
					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query
							->select('name')
							->from('`#__clubmanager_district`')
							->where('id = ' . $db->quote($db->escape($value)));
					$db->setQuery($query);
					$results = $db->loadObject();
					if ($results) {
						$textValue[] = $results->name;
					}
				}

			$this->_item->district = !empty($textValue) ? implode(', ', $textValue) : $this->_item->district;

			}

			if (isset($this->_item->role) && $this->_item->role != '') {
				if(is_object($this->_item->role)){
					$this->_item->role = JArrayHelper::fromObject($this->_item->role);
				}
				$values = (is_array($this->_item->role)) ? $this->_item->role : explode(',',$this->_item->role);

				$textValue = array();
				foreach ($values as $value){
					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query
							->select('name')
							->from('`#__clubmanager_role`')
							->where('id = ' . $db->quote($db->escape($value)));
					$db->setQuery($query);
					$results = $db->loadObject();
					if ($results) {
						$textValue[] = $results->name;
					}
				}

			$this->_item->role = !empty($textValue) ? implode(', ', $textValue) : $this->_item->role;

			}
		if ( isset($this->_item->created_by) ) {
			$this->_item->created_by_name = JFactory::getUser($this->_item->created_by)->name;
		}

        return $this->_item;
    }

    public function getTable($type = 'People', $prefix = 'ClubmanagerTable', $config = array()) {
        $this->addTablePath(JPATH_COMPONENT_ADMINISTRATOR . '/tables');
        return JTable::getInstance($type, $prefix, $config);
    }

    /**
     * Method to check in an item.
     *
     * @param	integer		The id of the row to check out.
     * @return	boolean		True on success, false on failure.
     * @since	1.6
     */
    public function checkin($id = null) {
        // Get the id.
        $id = (!empty($id)) ? $id : (int) $this->getState('people.id');

        if ($id) {

            // Initialise the table
            $table = $this->getTable();

            // Attempt to check the row in.
            if (method_exists($table, 'checkin')) {
                if (!$table->checkin($id)) {
                    $this->setError($table->getError());
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Method to check out an item for editing.
     *
     * @param	integer		The id of the row to check out.
     * @return	boolean		True on success, false on failure.
     * @since	1.6
     */
    public function checkout($id = null) {
        // Get the user id.
        $id = (!empty($id)) ? $id : (int) $this->getState('people.id');

        if ($id) {

            // Initialise the table
            $table = $this->getTable();

            // Get the current user object.
            $user = JFactory::getUser();

            // Attempt to check the row out.
            if (method_exists($table, 'checkout')) {
                if (!$table->checkout($user->get('id'), $id)) {
                    $this->setError($table->getError());
                    return false;
                }
            }
        }

        return true;
    }

    public function getCategoryName($id) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query
                ->select('title')
                ->from('#__categories')
                ->where('id = ' . $id);
        $db->setQuery($query);
        return $db->loadObject();
    }

    public function publish($id, $state) {
        $table = $this->getTable();
        $table->load($id);
        $table->state = $state;
        return $table->store();
    }

    public function delete($id) {
        $table = $this->getTable();
        return $table->delete($id);
    }

}
