<?php
/**
 * @version     1.0.0
 * @package     com_clubmanager
 * @copyright   Copyright (C) 2015. Alle Rechte vorbehalten.
 * @license     GNU General Public License Version 2 oder später; siehe LICENSE.txt
 * @author      Roman Artelsmair <roman@artelsmair.at> - http://www.artelsmair.at
 */

defined('_JEXEC') or die;

// Include dependancies
jimport('joomla.application.component.controller');

// Execute the task.
$controller	= JControllerLegacy::getInstance('Clubmanager');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
