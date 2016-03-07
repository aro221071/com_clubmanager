<?php
/**
 * @version     1.0.0
 * @package     com_clubmanager
 * @copyright   Copyright (C) 2015. Alle Rechte vorbehalten.
 * @license     GNU General Public License Version 2 oder später; siehe LICENSE.txt
 * @author      Roman Artelsmair <roman@artelsmair.at> - http://www.artelsmair.at
 */

defined('_JEXEC') or die;
defined('JPATH_BASE') or die;

jimport('joomla.html.html');
jimport('joomla.form.formfield');
jimport('joomla.form.helper');
/**
 * Supports an HTML select list of categories
 */

JFormHelper::loadFieldClass('calendar');

class JFormFieldAroCalendar extends JFormFieldCalendar
{
    public $type = 'AroCalendar';
    protected function getInput()
    {

        $this->value = date('d.m.Y');

        return parent::getInput();
    }
}
?>