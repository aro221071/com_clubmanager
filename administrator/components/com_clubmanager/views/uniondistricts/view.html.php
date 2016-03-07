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
class ClubmanagerViewUniondistricts extends JViewLegacy {

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

        ClubmanagerHelper::addSubmenu('uniondistricts');

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

        JToolBarHelper::title(JText::_('COM_CLUBMANAGER_TITLE_UNIONDISTRICTS'), 'uniondistricts.png');

        //Check if the form exists before showing the add/edit buttons
        $formPath = JPATH_COMPONENT_ADMINISTRATOR . '/views/uniondistrict';
        if (file_exists($formPath)) {

            if ($canDo->get('core.create')) {
                JToolBarHelper::addNew('uniondistrict.add', 'JTOOLBAR_NEW');
            }

            if ($canDo->get('core.edit') && isset($this->items[0])) {
                JToolBarHelper::editList('uniondistrict.edit', 'JTOOLBAR_EDIT');
            }
        }

        if ($canDo->get('core.edit.state')) {

            if (isset($this->items[0]->state)) {
                JToolBarHelper::divider();
                JToolBarHelper::custom('uniondistricts.publish', 'publish.png', 'publish_f2.png', 'JTOOLBAR_PUBLISH', true);
                JToolBarHelper::custom('uniondistricts.unpublish', 'unpublish.png', 'unpublish_f2.png', 'JTOOLBAR_UNPUBLISH', true);
            } else if (isset($this->items[0])) {
                //If this component does not use state then show a direct delete button as we can not trash
                JToolBarHelper::deleteList('', 'uniondistricts.delete', 'JTOOLBAR_DELETE');
            }

            if (isset($this->items[0]->state)) {
                JToolBarHelper::divider();
                JToolBarHelper::archiveList('uniondistricts.archive', 'JTOOLBAR_ARCHIVE');
            }
            if (isset($this->items[0]->checked_out)) {
                JToolBarHelper::custom('uniondistricts.checkin', 'checkin.png', 'checkin_f2.png', 'JTOOLBAR_CHECKIN', true);
            }
        }

        //Show trash and delete for components that uses the state field
        if (isset($this->items[0]->state)) {
            if ($state->get('filter.state') == -2 && $canDo->get('core.delete')) {
                JToolBarHelper::deleteList('', 'uniondistricts.delete', 'JTOOLBAR_EMPTY_TRASH');
                JToolBarHelper::divider();
            } else if ($canDo->get('core.edit.state')) {
                JToolBarHelper::trash('uniondistricts.trash', 'JTOOLBAR_TRASH');
                JToolBarHelper::divider();
            }
        }

        if ($canDo->get('core.admin')) {
            JToolBarHelper::preferences('com_clubmanager');
        }

        //Set sidebar action - New in 3.0
        JHtmlSidebar::setAction('index.php?option=com_clubmanager&view=uniondistricts');

        $this->extra_sidebar = '';
                                                        
        //Filter for the field unioncountry;
        jimport('joomla.form.form');
        $options = array();
        JForm::addFormPath(JPATH_COMPONENT . '/models/forms');
        $form = JForm::getInstance('com_clubmanager.uniondistrict', 'uniondistrict');

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
        $form = JForm::getInstance('com_clubmanager.uniondistrict', 'uniondistrict');

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
		'a.fullname' => JText::_('COM_CLUBMANAGER_UNIONDISTRICTS_FULLNAME'),
		'a.shortname' => JText::_('COM_CLUBMANAGER_UNIONDISTRICTS_SHORTNAME'),
		'a.name' => JText::_('COM_CLUBMANAGER_UNIONDISTRICTS_NAME'),
		'a.unioncountry' => JText::_('COM_CLUBMANAGER_UNIONDISTRICTS_UNIONCOUNTRY'),
		'a.unioncounty' => JText::_('COM_CLUBMANAGER_UNIONDISTRICTS_UNIONCOUNTY'),
		'a.website' => JText::_('COM_CLUBMANAGER_UNIONDISTRICTS_WEBSITE'),
		'a.default' => JText::_('COM_CLUBMANAGER_UNIONDISTRICTS_DEFAULT'),
		'a.ordering' => JText::_('JGRID_HEADING_ORDERING'),
		'a.state' => JText::_('JSTATUS'),
		'a.comment' => JText::_('COM_CLUBMANAGER_UNIONDISTRICTS_COMMENT'),
		);
	}

}
