<?php

/**
 * @version     1.0.0
 * @package     com_clubmanager
 * @copyright   Copyright (C) 2015. Alle Rechte vorbehalten.
 * @license     GNU General Public License Version 2 oder später; siehe LICENSE.txt
 * @author      Roman Artelsmair <roman@artelsmair.at> - http://www.artelsmair.at
 */
// No direct access
defined('_JEXEC') or die;

/**
 * people Table class
 */
class ClubmanagerTablepeople extends JTable
{

	/**
	 * Constructor
	 *
	 * @param JDatabase A database connector object
	 */
	public function __construct(&$db)
	{
		parent::__construct('#__clubmanager_people', 'id', $db);
	}

	/**
	 * Overloaded bind function to pre-process the params.
	 *
	 * @param    array        Named array
	 *
	 * @return    null|string    null is operation was satisfactory, otherwise returns an error
	 * @see        JTable:bind
	 * @since      1.5
	 */
	public function bind($array, $ignore = '')
	{

		

		//Support for multiple or not foreign key field: salutation
			if(!empty($array['salutation'])){
				if(is_array($array['salutation'])){
					$array['salutation'] = implode(',',$array['salutation']);
				}
				else if(strrpos($array['salutation'], ',') != false){
					$array['salutation'] = explode(',',$array['salutation']);
				}
			}
			else {
				$array['salutation'] = '';
			}

		//Support for multiple or not foreign key field: gender
			if(!empty($array['gender'])){
				if(is_array($array['gender'])){
					$array['gender'] = implode(',',$array['gender']);
				}
				else if(strrpos($array['gender'], ',') != false){
					$array['gender'] = explode(',',$array['gender']);
				}
			}
			else {
				$array['gender'] = '';
			}

		//Support for multiple or not foreign key field: memberclub
			if(!empty($array['memberclub'])){
				if(is_array($array['memberclub'])){
					$array['memberclub'] = implode(',',$array['memberclub']);
				}
				else if(strrpos($array['memberclub'], ',') != false){
					$array['memberclub'] = explode(',',$array['memberclub']);
				}
			}
			else {
				$array['memberclub'] = '';
			}

		//Support for multiple or not foreign key field: postalcode
			if(!empty($array['postalcode'])){
				if(is_array($array['postalcode'])){
					$array['postalcode'] = implode(',',$array['postalcode']);
				}
				else if(strrpos($array['postalcode'], ',') != false){
					$array['postalcode'] = explode(',',$array['postalcode']);
				}
			}
			else {
				$array['postalcode'] = '';
			}

		//Support for multiple or not foreign key field: city
			if(!empty($array['city'])){
				if(is_array($array['city'])){
					$array['city'] = implode(',',$array['city']);
				}
				else if(strrpos($array['city'], ',') != false){
					$array['city'] = explode(',',$array['city']);
				}
			}
			else {
				$array['city'] = '';
			}

		//Support for multiple or not foreign key field: county
			if(!empty($array['county'])){
				if(is_array($array['county'])){
					$array['county'] = implode(',',$array['county']);
				}
				else if(strrpos($array['county'], ',') != false){
					$array['county'] = explode(',',$array['county']);
				}
			}
			else {
				$array['county'] = '';
			}

		//Support for multiple or not foreign key field: country
			if(!empty($array['country'])){
				if(is_array($array['country'])){
					$array['country'] = implode(',',$array['country']);
				}
				else if(strrpos($array['country'], ',') != false){
					$array['country'] = explode(',',$array['country']);
				}
			}
			else {
				$array['country'] = '';
			}

		//Support for multiple or not foreign key field: district
			if(!empty($array['district'])){
				if(is_array($array['district'])){
					$array['district'] = implode(',',$array['district']);
				}
				else if(strrpos($array['district'], ',') != false){
					$array['district'] = explode(',',$array['district']);
				}
			}
			else {
				$array['district'] = '';
			}

		//Support for multiple or not foreign key field: role
			if(!empty($array['role'])){
				if(is_array($array['role'])){
					$array['role'] = implode(',',$array['role']);
				}
				else if(strrpos($array['role'], ',') != false){
					$array['role'] = explode(',',$array['role']);
				}
			}
			else {
				$array['role'] = '';
			}

		//Support for checkbox field: newsletter
		if (!isset($array['newsletter'])){
			$array['newsletter'] = 0;
		}

				//Support for file field: picture
				$input = JFactory::getApplication()->input;
				$files = $input->files->get('jform');
				if(!empty($files['picture'])){
					jimport('joomla.filesystem.file');
					$file = $files['picture'];

					//Check if the server found any error.
					$fileError = $file['error'];
					$message = '';
					if($fileError > 0 && $fileError != 4) {
						switch ($fileError) {
							case 1:
								$message = JText::_( 'File size exceeds allowed by the server');
								break;
							case 2:
								$message = JText::_( 'File size exceeds allowed by the html form');
								break;
							case 3:
								$message = JText::_( 'Partial upload error');
								break;
						}
						if($message != '') {
							JError::raiseWarning(500, $message);
							return false;
						}
					}
					else if($fileError == 4){
						if(isset($array['picture_hidden'])){
							$array['picture'] = $array['picture_hidden'];
						}
					}
					else{

						//Check for filesize
						$fileSize = $file['size'];
						if($fileSize > 10485760){
							JError::raiseWarning(500, 'File bigger than 10MB' );
							return false;
						}

						//Check for filetype
						$okMIMETypes = 'image/jpeg,image/jpg,image/png,image/bmp,image/gif';
						$validMIMEArray = explode(',', $okMIMETypes);
						$fileMime = $file['type'];
            /* ARO Test um den Mime Type zu erhalten $array['phone3'] = $fileMime; */
            if(!in_array($fileMime, $validMIMEArray)){
							JError::raiseWarning(500, 'This filetype is not allowed');
							return false;
						}
            
						//Replace any special characters in the filename
						$filename = explode('.', $file['name']);
						$filename[0] = preg_replace("/[^A-Za-z0-9]/i", "-", $filename[0]);

						//Add Timestamp MD5 to avoid overwriting
						$filename = md5(time()) . '-' . implode('.',$filename);
						$uploadPath = JPATH_ADMINISTRATOR . '/components/com_clubmanager/images/people/' . $filename;
						$fileTemp = $file['tmp_name'];
						if(!JFile::exists($uploadPath)){
							if (!JFile::upload($fileTemp, $uploadPath)){
								JError::raiseWarning(500, 'Error moving file');
								return false;
							}
						}
						$array['picture'] = $filename;
					}
				}
		$input = JFactory::getApplication()->input;
		$task = $input->getString('task', '');
		if(($task == 'save' || $task == 'apply') && (!JFactory::getUser()->authorise('core.edit.state','com_clubmanager') && $array['state'] == 1)){
			$array['state'] = 0;
		}
		if($array['id'] == 0){
			$array['created_by'] = JFactory::getUser()->id;
		}

		if (isset($array['params']) && is_array($array['params']))
		{
			$registry = new JRegistry();
			$registry->loadArray($array['params']);
			$array['params'] = (string) $registry;
		}

		if (isset($array['metadata']) && is_array($array['metadata']))
		{
			$registry = new JRegistry();
			$registry->loadArray($array['metadata']);
			$array['metadata'] = (string) $registry;
		}
		if (!JFactory::getUser()->authorise('core.admin', 'com_clubmanager.people.' . $array['id']))
		{
			$actions         = JFactory::getACL()->getActions('com_clubmanager', 'people');
			$default_actions = JFactory::getACL()->getAssetRules('com_clubmanager.people.' . $array['id'])->getData();
			$array_jaccess   = array();
			foreach ($actions as $action)
			{
				$array_jaccess[$action->name] = $default_actions[$action->name];
			}
			$array['rules'] = $this->JAccessRulestoArray($array_jaccess);
		}
		//Bind the rules for ACL where supported.
		if (isset($array['rules']) && is_array($array['rules']))
		{
			$this->setRules($array['rules']);
		}

		return parent::bind($array, $ignore);
	}

	/**
	 * This function convert an array of JAccessRule objects into an rules array.
	 *
	 * @param type $jaccessrules an arrao of JAccessRule objects.
	 */
	private function JAccessRulestoArray($jaccessrules)
	{
		$rules = array();
		foreach ($jaccessrules as $action => $jaccess)
		{
			$actions = array();
			foreach ($jaccess->getData() as $group => $allow)
			{
				$actions[$group] = ((bool) $allow);
			}
			$rules[$action] = $actions;
		}

		return $rules;
	}

	/**
	 * Overloaded check function
	 */
	public function check()
	{

		//If there is an ordering column and this is a new row then get the next ordering value
		if (property_exists($this, 'ordering') && $this->id == 0)
		{
			$this->ordering = self::getNextOrder();
		}

		return parent::check();
	}

	/**
	 * Method to set the publishing state for a row or list of rows in the database
	 * table.  The method respects checked out rows by other users and will attempt
	 * to checkin rows that it can after adjustments are made.
	 *
	 * @param    mixed    An optional array of primary key values to update.  If not
	 *                    set the instance property value is used.
	 * @param    integer  The publishing state. eg. [0 = unpublished, 1 = published]
	 * @param    integer  The user id of the user performing the operation.
	 *
	 * @return    boolean    True on success.
	 * @since    1.0.4
	 */
	public function publish($pks = null, $state = 1, $userId = 0)
	{
		// Initialise variables.
		$k = $this->_tbl_key;

		// Sanitize input.
		JArrayHelper::toInteger($pks);
		$userId = (int) $userId;
		$state  = (int) $state;

		// If there are no primary keys set check to see if the instance key is set.
		if (empty($pks))
		{
			if ($this->$k)
			{
				$pks = array($this->$k);
			}
			// Nothing to set publishing state on, return false.
			else
			{
				$this->setError(JText::_('JLIB_DATABASE_ERROR_NO_ROWS_SELECTED'));

				return false;
			}
		}

		// Build the WHERE clause for the primary keys.
		$where = $k . '=' . implode(' OR ' . $k . '=', $pks);

		// Determine if there is checkin support for the table.
		if (!property_exists($this, 'checked_out') || !property_exists($this, 'checked_out_time'))
		{
			$checkin = '';
		}
		else
		{
			$checkin = ' AND (checked_out = 0 OR checked_out = ' . (int) $userId . ')';
		}

		// Update the publishing state for rows with the given primary keys.
		$this->_db->setQuery(
			'UPDATE `' . $this->_tbl . '`' .
			' SET `state` = ' . (int) $state .
			' WHERE (' . $where . ')' .
			$checkin
		);
		$this->_db->execute();

		// If checkin is supported and all rows were adjusted, check them in.
		if ($checkin && (count($pks) == $this->_db->getAffectedRows()))
		{
			// Checkin each row.
			foreach ($pks as $pk)
			{
				$this->checkin($pk);
			}
		}

		// If the JTable instance value is in the list of primary keys that were set, set the instance.
		if (in_array($this->$k, $pks))
		{
			$this->state = $state;
		}

		$this->setError('');

		return true;
	}

	/**
	 * Define a namespaced asset name for inclusion in the #__assets table
	 * @return string The asset name
	 *
	 * @see JTable::_getAssetName
	 */
	protected function _getAssetName()
	{
		$k = $this->_tbl_key;

		return 'com_clubmanager.people.' . (int) $this->$k;
	}

	/**
	 * Returns the parent asset's id. If you have a tree structure, retrieve the parent's id using the external key field
	 *
	 * @see JTable::_getAssetParentId
	 */
	protected function _getAssetParentId(JTable $table = null, $id = null)
	{
		// We will retrieve the parent-asset from the Asset-table
		$assetParent = JTable::getInstance('Asset');
		// Default: if no asset-parent can be found we take the global asset
		$assetParentId = $assetParent->getRootId();
		// The item has the component as asset-parent
		$assetParent->loadByName('com_clubmanager');
		// Return the found asset-parent-id
		if ($assetParent->id)
		{
			$assetParentId = $assetParent->id;
		}

		return $assetParentId;
	}

	public function delete($pk = null)
	{
		$this->load($pk);
		$result = parent::delete($pk);
		if ($result)
		{

			
	jimport('joomla.filesystem.file');
	$result = JFile::delete(JPATH_ADMINISTRATOR . '/components/com_clubmanager/images/people/' . $this->picture);
		}

		return $result;
	}

}
