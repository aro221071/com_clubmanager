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
class ClubmanagerViewClubs extends JViewLegacy {

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

        ClubmanagerHelper::addSubmenu('clubs');

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

        JToolBarHelper::title(JText::_('COM_CLUBMANAGER_TITLE_CLUBS'), 'clubs.png');

        //Check if the form exists before showing the add/edit buttons
        $formPath = JPATH_COMPONENT_ADMINISTRATOR . '/views/club';
        if (file_exists($formPath)) {

            if ($canDo->get('core.create')) {
                JToolBarHelper::addNew('club.add', 'JTOOLBAR_NEW');
            }

            if ($canDo->get('core.edit') && isset($this->items[0])) {
                JToolBarHelper::editList('club.edit', 'JTOOLBAR_EDIT');
            }
        }

        if ($canDo->get('core.edit.state')) {

            if (isset($this->items[0]->state)) {
                JToolBarHelper::divider();
                JToolBarHelper::custom('clubs.publish', 'publish.png', 'publish_f2.png', 'JTOOLBAR_PUBLISH', true);
                JToolBarHelper::custom('clubs.unpublish', 'unpublish.png', 'unpublish_f2.png', 'JTOOLBAR_UNPUBLISH', true);
            } else if (isset($this->items[0])) {
                //If this component does not use state then show a direct delete button as we can not trash
                JToolBarHelper::deleteList('', 'clubs.delete', 'JTOOLBAR_DELETE');
            }

            if (isset($this->items[0]->state)) {
                JToolBarHelper::divider();
                JToolBarHelper::archiveList('clubs.archive', 'JTOOLBAR_ARCHIVE');
            }
            if (isset($this->items[0]->checked_out)) {
                JToolBarHelper::custom('clubs.checkin', 'checkin.png', 'checkin_f2.png', 'JTOOLBAR_CHECKIN', true);
            }
        }

        //Show trash and delete for components that uses the state field
        if (isset($this->items[0]->state)) {
            if ($state->get('filter.state') == -2 && $canDo->get('core.delete')) {
                JToolBarHelper::deleteList('', 'clubs.delete', 'JTOOLBAR_EMPTY_TRASH');
                JToolBarHelper::divider();
            } else if ($canDo->get('core.edit.state')) {
                JToolBarHelper::trash('clubs.trash', 'JTOOLBAR_TRASH');
                JToolBarHelper::divider();
            }
        }

        if ($canDo->get('core.admin')) {
            JToolBarHelper::preferences('com_clubmanager');
        }

        //Set sidebar action - New in 3.0
        JHtmlSidebar::setAction('index.php?option=com_clubmanager&view=clubs');

        $this->extra_sidebar = '';
                                                        
        //Filter for the field union;
        jimport('joomla.form.form');
        $options = array();
        JForm::addFormPath(JPATH_COMPONENT . '/models/forms');
        $form = JForm::getInstance('com_clubmanager.club', 'club');

        $field = $form->getField('union');

        $query = $form->getFieldAttribute('filter_union','query');
        $translate = $form->getFieldAttribute('filter_union','translate');
        $key = $form->getFieldAttribute('filter_union','key_field');
        $value = $form->getFieldAttribute('filter_union','value_field');

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
            '$Union',
            'filter_union',
            JHtml::_('select.options', $options, "value", "text", $this->state->get('filter.union')),
            true
        );                                                
        //Filter for the field country;
        jimport('joomla.form.form');
        $options = array();
        JForm::addFormPath(JPATH_COMPONENT . '/models/forms');
        $form = JForm::getInstance('com_clubmanager.club', 'club');

        $field = $form->getField('country');

        $query = $form->getFieldAttribute('filter_country','query');
        $translate = $form->getFieldAttribute('filter_country','translate');
        $key = $form->getFieldAttribute('filter_country','key_field');
        $value = $form->getFieldAttribute('filter_country','value_field');

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
            '$Country',
            'filter_country',
            JHtml::_('select.options', $options, "value", "text", $this->state->get('filter.country')),
            true
        );                                                
        //Filter for the field county;
        jimport('joomla.form.form');
        $options = array();
        JForm::addFormPath(JPATH_COMPONENT . '/models/forms');
        $form = JForm::getInstance('com_clubmanager.club', 'club');

        $field = $form->getField('county');

        $query = $form->getFieldAttribute('filter_county','query');
        $translate = $form->getFieldAttribute('filter_county','translate');
        $key = $form->getFieldAttribute('filter_county','key_field');
        $value = $form->getFieldAttribute('filter_county','value_field');

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
            '$County',
            'filter_county',
            JHtml::_('select.options', $options, "value", "text", $this->state->get('filter.county')),
            true
        );                                                
        //Filter for the field district;
        jimport('joomla.form.form');
        $options = array();
        JForm::addFormPath(JPATH_COMPONENT . '/models/forms');
        $form = JForm::getInstance('com_clubmanager.club', 'club');

        $field = $form->getField('district');

        $query = $form->getFieldAttribute('filter_district','query');
        $translate = $form->getFieldAttribute('filter_district','translate');
        $key = $form->getFieldAttribute('filter_district','key_field');
        $value = $form->getFieldAttribute('filter_district','value_field');

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
            '$District',
            'filter_district',
            JHtml::_('select.options', $options, "value", "text", $this->state->get('filter.district')),
            true
        );                                                
        //Filter for the field unioncountry;
        jimport('joomla.form.form');
        $options = array();
        JForm::addFormPath(JPATH_COMPONENT . '/models/forms');
        $form = JForm::getInstance('com_clubmanager.club', 'club');

        $field = $form->getField('unioncountry');

        $query = $form->getFieldAttribute('filter_unioncountry','query');
        $translate = $form->getFieldAttribute('filter_unioncountry','translate');
        $key = $form->getFieldAttribute('filter_unioncountry','key_field');
        $value = $form->getFieldAttribute('filter_unioncountry','value_field');

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
            '$Unioncountry',
            'filter_unioncountry',
            JHtml::_('select.options', $options, "value", "text", $this->state->get('filter.unioncountry')),
            true
        );                                                
        //Filter for the field unioncounty;
        jimport('joomla.form.form');
        $options = array();
        JForm::addFormPath(JPATH_COMPONENT . '/models/forms');
        $form = JForm::getInstance('com_clubmanager.club', 'club');

        $field = $form->getField('unioncounty');

        $query = $form->getFieldAttribute('filter_unioncounty','query');
        $translate = $form->getFieldAttribute('filter_unioncounty','translate');
        $key = $form->getFieldAttribute('filter_unioncounty','key_field');
        $value = $form->getFieldAttribute('filter_unioncounty','value_field');

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
            '$Unioncounty',
            'filter_unioncounty',
            JHtml::_('select.options', $options, "value", "text", $this->state->get('filter.unioncounty')),
            true
        );                                                
        //Filter for the field uniondistrict;
        jimport('joomla.form.form');
        $options = array();
        JForm::addFormPath(JPATH_COMPONENT . '/models/forms');
        $form = JForm::getInstance('com_clubmanager.club', 'club');

        $field = $form->getField('uniondistrict');

        $query = $form->getFieldAttribute('filter_uniondistrict','query');
        $translate = $form->getFieldAttribute('filter_uniondistrict','translate');
        $key = $form->getFieldAttribute('filter_uniondistrict','key_field');
        $value = $form->getFieldAttribute('filter_uniondistrict','value_field');

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
            '$Uniondistrict',
            'filter_uniondistrict',
            JHtml::_('select.options', $options, "value", "text", $this->state->get('filter.uniondistrict')),
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
		'a.fullname' => JText::_('COM_CLUBMANAGER_CLUBS_FULLNAME'),
		'a.praefix' => JText::_('COM_CLUBMANAGER_CLUBS_PRAEFIX'),
		'a.union' => JText::_('COM_CLUBMANAGER_CLUBS_UNION'),
		'a.name' => JText::_('COM_CLUBMANAGER_CLUBS_NAME'),
		'a.street' => JText::_('COM_CLUBMANAGER_CLUBS_STREET'),
		'a.postalcode' => JText::_('COM_CLUBMANAGER_CLUBS_POSTALCODE'),
		'a.city' => JText::_('COM_CLUBMANAGER_CLUBS_CITY'),
		'a.country' => JText::_('COM_CLUBMANAGER_CLUBS_COUNTRY'),
		'a.county' => JText::_('COM_CLUBMANAGER_CLUBS_COUNTY'),
		'a.district' => JText::_('COM_CLUBMANAGER_CLUBS_DISTRICT'),
		'a.ownclub' => JText::_('COM_CLUBMANAGER_CLUBS_OWNCLUB'),
		'a.zvrno' => JText::_('COM_CLUBMANAGER_CLUBS_ZVRNO'),
		'a.website' => JText::_('COM_CLUBMANAGER_CLUBS_WEBSITE'),
		'a.phone1' => JText::_('COM_CLUBMANAGER_CLUBS_PHONE1'),
		'a.phone2' => JText::_('COM_CLUBMANAGER_CLUBS_PHONE2'),
		'a.phone3' => JText::_('COM_CLUBMANAGER_CLUBS_PHONE3'),
		'a.email1' => JText::_('COM_CLUBMANAGER_CLUBS_EMAIL1'),
		'a.email2' => JText::_('COM_CLUBMANAGER_CLUBS_EMAIL2'),
		'a.email3' => JText::_('COM_CLUBMANAGER_CLUBS_EMAIL3'),
		'a.location' => JText::_('COM_CLUBMANAGER_CLUBS_LOCATION'),
		'a.distance' => JText::_('COM_CLUBMANAGER_CLUBS_DISTANCE'),
		'a.ordering' => JText::_('JGRID_HEADING_ORDERING'),
		'a.unioncountry' => JText::_('COM_CLUBMANAGER_CLUBS_UNIONCOUNTRY'),
		'a.unioncounty' => JText::_('COM_CLUBMANAGER_CLUBS_UNIONCOUNTY'),
		'a.uniondistrict' => JText::_('COM_CLUBMANAGER_CLUBS_UNIONDISTRICT'),
		'a.uniondistrictno' => JText::_('COM_CLUBMANAGER_CLUBS_UNIONDISTRICTNO'),
		'a.default' => JText::_('COM_CLUBMANAGER_CLUBS_DEFAULT'),
		'a.state' => JText::_('JSTATUS'),
		'a.comment' => JText::_('COM_CLUBMANAGER_CLUBS_COMMENT'),
		);
	}

}
