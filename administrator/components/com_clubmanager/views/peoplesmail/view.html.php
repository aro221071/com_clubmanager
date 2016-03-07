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

jimport('joomla.application.component.view');

/**
 * View class for a list of Clubmanager.
 */
class ClubmanagerViewPeoplesmail extends JViewLegacy {

    protected $items;
    protected $pagination;
    protected $state;

    /**
     * Display the view
     */
    public function display($tpl = null) {
        $this->state = $this->get('State');
        $this->items = $this->get('Items');
        $this->pagination = $this->get('Pagination');

        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            throw new Exception(implode("\n", $errors));
        }

        ClubmanagerHelper::addSubmenu('peoples');

        $this->addToolbar();

        $this->sidebar = JHtmlSidebar::render();
        parent::display($tpl);
    }

    /**
     * Add the page title and toolbar.
     *
     * @since	1.6
     */
    protected function addToolbar() {
        require_once JPATH_COMPONENT . '/helpers/clubmanager.php';

        $state = $this->get('State');
        $canDo = ClubmanagerHelper::getActions($state->get('filter.category_id'));

        JToolBarHelper::title(JText::_('COM_CLUBMANAGER_TITLE_PEOPLESMAIL'), 'peoples.png');

        //Check if the form exists before showing the add/edit buttons
        $formPath = JPATH_COMPONENT_ADMINISTRATOR . '/views/people';
        if (file_exists($formPath)) {

            if ($canDo->get('core.create')) {
                JToolBarHelper::addNew('people.add', 'JTOOLBAR_NEW');
            }

            if ($canDo->get('core.edit') && isset($this->items[0])) {
                JToolBarHelper::editList('people.edit', 'JTOOLBAR_EDIT');
            }
        }

        if ($canDo->get('core.edit.state')) {

            if (isset($this->items[0]->state)) {
                JToolBarHelper::divider();
                JToolBarHelper::custom('peoples.publish', 'publish.png', 'publish_f2.png', 'JTOOLBAR_PUBLISH', true);
                JToolBarHelper::custom('peoples.unpublish', 'unpublish.png', 'unpublish_f2.png', 'JTOOLBAR_UNPUBLISH', true);
            } else if (isset($this->items[0])) {
                //If this component does not use state then show a direct delete button as we can not trash
                JToolBarHelper::deleteList('', 'peoples.delete', 'JTOOLBAR_DELETE');
            }

            if (isset($this->items[0]->state)) {
                JToolBarHelper::divider();
                JToolBarHelper::archiveList('peoples.archive', 'JTOOLBAR_ARCHIVE');
            }
            if (isset($this->items[0]->checked_out)) {
                JToolBarHelper::custom('peoples.checkin', 'checkin.png', 'checkin_f2.png', 'JTOOLBAR_CHECKIN', true);
            }
        }

        //Show trash and delete for components that uses the state field
        if (isset($this->items[0]->state)) {
            if ($state->get('filter.state') == -2 && $canDo->get('core.delete')) {
                JToolBarHelper::deleteList('', 'peoples.delete', 'JTOOLBAR_EMPTY_TRASH');
                JToolBarHelper::divider();
            } else if ($canDo->get('core.edit.state')) {
                JToolBarHelper::trash('peoples.trash', 'JTOOLBAR_TRASH');
                JToolBarHelper::divider();
            }
        }

        if ($canDo->get('core.admin')) {
            JToolBarHelper::preferences('com_clubmanager');
        }

        //Set sidebar action - New in 3.0
        JHtmlSidebar::setAction('index.php?option=com_clubmanager&view=peoples');

        $this->extra_sidebar = '';
                                                        
        //Filter for the field gender;
        jimport('joomla.form.form');
        $options = array();
        JForm::addFormPath(JPATH_COMPONENT . '/models/forms');
        $form = JForm::getInstance('com_clubmanager.people', 'people');

        $field = $form->getField('gender');

        $query = $form->getFieldAttribute('filter_gender','query');
        $translate = $form->getFieldAttribute('filter_gender','translate');
        $key = $form->getFieldAttribute('filter_gender','key_field');
        $value = $form->getFieldAttribute('filter_gender','value_field');

        // Get the database object.
        $db = JFactory::getDBO();

        // Set the query and get the result list.
        $db->setQuery($query);
        $items = $db->loadObjectlist();

        // Build the field options.
        if (!empty($items))
        {
            foreach ($items as $item)
            {
                if ($translate == true)
                {
                    $options[] = JHtml::_('select.option', $item->$key, JText::_($item->$value));
                }
                else
                {
                    $options[] = JHtml::_('select.option', $item->$key, $item->$value);
                }
            }
        }

        JHtmlSidebar::addFilter(
            '$Gender',
            'filter_gender',
            JHtml::_('select.options', $options, "value", "text", $this->state->get('filter.gender')),
            true
        );                                                
        //Filter for the field memberclub;
        jimport('joomla.form.form');
        $options = array();
        JForm::addFormPath(JPATH_COMPONENT . '/models/forms');
        $form = JForm::getInstance('com_clubmanager.people', 'people');

        $field = $form->getField('memberclub');

        $query = $form->getFieldAttribute('filter_memberclub','query');
        $translate = $form->getFieldAttribute('filter_memberclub','translate');
        $key = $form->getFieldAttribute('filter_memberclub','key_field');
        $value = $form->getFieldAttribute('filter_memberclub','value_field');

        // Get the database object.
        $db = JFactory::getDBO();

        // Set the query and get the result list.
        $db->setQuery($query);
        $items = $db->loadObjectlist();

        // Build the field options.
        if (!empty($items))
        {
            foreach ($items as $item)
            {
                if ($translate == true)
                {
                    $options[] = JHtml::_('select.option', $item->$key, JText::_($item->$value));
                }
                else
                {
                    $options[] = JHtml::_('select.option', $item->$key, $item->$value);
                }
            }
        }

        JHtmlSidebar::addFilter(
            '$Memberclub',
            'filter_memberclub',
            JHtml::_('select.options', $options, "value", "text", $this->state->get('filter.memberclub')),
            true
        );                                                
        //Filter for the field postalcode;
        jimport('joomla.form.form');
        $options = array();
        JForm::addFormPath(JPATH_COMPONENT . '/models/forms');
        $form = JForm::getInstance('com_clubmanager.people', 'people');

        $field = $form->getField('postalcode');

        $query = $form->getFieldAttribute('filter_postalcode','query');
        $translate = $form->getFieldAttribute('filter_postalcode','translate');
        $key = $form->getFieldAttribute('filter_postalcode','key_field');
        $value = $form->getFieldAttribute('filter_postalcode','value_field');

        // Get the database object.
        $db = JFactory::getDBO();

        // Set the query and get the result list.
        $db->setQuery($query);
        $items = $db->loadObjectlist();

        // Build the field options.
        if (!empty($items))
        {
            foreach ($items as $item)
            {
                if ($translate == true)
                {
                    $options[] = JHtml::_('select.option', $item->$key, JText::_($item->$value));
                }
                else
                {
                    $options[] = JHtml::_('select.option', $item->$key, $item->$value);
                }
            }
        }

        JHtmlSidebar::addFilter(
            '$Postalcode',
            'filter_postalcode',
            JHtml::_('select.options', $options, "value", "text", $this->state->get('filter.postalcode')),
            true
        );                                                
        //Filter for the field city;
        jimport('joomla.form.form');
        $options = array();
        JForm::addFormPath(JPATH_COMPONENT . '/models/forms');
        $form = JForm::getInstance('com_clubmanager.people', 'people');

        $field = $form->getField('city');

        $query = $form->getFieldAttribute('filter_city','query');
        $translate = $form->getFieldAttribute('filter_city','translate');
        $key = $form->getFieldAttribute('filter_city','key_field');
        $value = $form->getFieldAttribute('filter_city','value_field');

        // Get the database object.
        $db = JFactory::getDBO();

        // Set the query and get the result list.
        $db->setQuery($query);
        $items = $db->loadObjectlist();

        // Build the field options.
        if (!empty($items))
        {
            foreach ($items as $item)
            {
                if ($translate == true)
                {
                    $options[] = JHtml::_('select.option', $item->$key, JText::_($item->$value));
                }
                else
                {
                    $options[] = JHtml::_('select.option', $item->$key, $item->$value);
                }
            }
        }

        JHtmlSidebar::addFilter(
            '$City',
            'filter_city',
            JHtml::_('select.options', $options, "value", "text", $this->state->get('filter.city')),
            true
        );                                                
        //Filter for the field role;
        jimport('joomla.form.form');
        $options = array();
        JForm::addFormPath(JPATH_COMPONENT . '/models/forms');
        $form = JForm::getInstance('com_clubmanager.people', 'people');

        $field = $form->getField('role');

        $query = $form->getFieldAttribute('filter_role','query');
        $translate = $form->getFieldAttribute('filter_role','translate');
        $key = $form->getFieldAttribute('filter_role','key_field');
        $value = $form->getFieldAttribute('filter_role','value_field');

        // Get the database object.
        $db = JFactory::getDBO();

        // Set the query and get the result list.
        $db->setQuery($query);
        $items = $db->loadObjectlist();

        // Build the field options.
        if (!empty($items))
        {
            foreach ($items as $item)
            {
                if ($translate == true)
                {
                    $options[] = JHtml::_('select.option', $item->$key, JText::_($item->$value));
                }
                else
                {
                    $options[] = JHtml::_('select.option', $item->$key, $item->$value);
                }
            }
        }

        JHtmlSidebar::addFilter(
            '$Role',
            'filter_role',
            JHtml::_('select.options', $options, "value", "text", $this->state->get('filter.role')),
            true
        );
		JHtmlSidebar::addFilter(

			JText::_('JOPTION_SELECT_PUBLISHED'),

			'filter_published',

			JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), "value", "text", $this->state->get('filter.state'), true)

		);

    }

	protected function getSortFields()
	{
		return array(
		'a.id' => JText::_('JGRID_HEADING_ID'),
		'a.fullname' => JText::_('COM_CLUBMANAGER_PEOPLES_FULLNAME'),
		'a.firstname' => JText::_('COM_CLUBMANAGER_PEOPLES_FIRSTNAME'),
		'a.lastname' => JText::_('COM_CLUBMANAGER_PEOPLES_LASTNAME'),
		'a.salutation' => JText::_('COM_CLUBMANAGER_PEOPLES_SALUTATION'),
		'a.gender' => JText::_('COM_CLUBMANAGER_PEOPLES_GENDER'),
		'a.nickname' => JText::_('COM_CLUBMANAGER_PEOPLES_NICKNAME'),
		'a.birthdate' => JText::_('COM_CLUBMANAGER_PEOPLES_BIRTHDATE'),
		'a.memberclub' => JText::_('COM_CLUBMANAGER_PEOPLES_MEMBERCLUB'),
		'a.memberno' => JText::_('COM_CLUBMANAGER_PEOPLES_MEMBERNO'),
		'a.phone1' => JText::_('COM_CLUBMANAGER_PEOPLES_PHONE1'),
		'a.email1' => JText::_('COM_CLUBMANAGER_PEOPLES_EMAIL1'),
		'a.street' => JText::_('COM_CLUBMANAGER_PEOPLES_STREET'),
		'a.postalcode' => JText::_('COM_CLUBMANAGER_PEOPLES_POSTALCODE'),
		'a.city' => JText::_('COM_CLUBMANAGER_PEOPLES_CITY'),
		'a.role' => JText::_('COM_CLUBMANAGER_PEOPLES_ROLE'),
		'a.newsletter' => JText::_('COM_CLUBMANAGER_PEOPLES_NEWSLETTER'),
		'a.iban' => JText::_('COM_CLUBMANAGER_PEOPLES_IBAN'),
		'a.bic' => JText::_('COM_CLUBMANAGER_PEOPLES_BIC'),
		'a.picture' => JText::_('COM_CLUBMANAGER_PEOPLES_PICTURE'),
		'a.ordering' => JText::_('JGRID_HEADING_ORDERING'),
		'a.state' => JText::_('JSTATUS'),
		'a.comment' => JText::_('COM_CLUBMANAGER_PEOPLES_COMMENT'),
		);
	}

}
