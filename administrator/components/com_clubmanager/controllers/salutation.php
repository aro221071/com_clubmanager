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

jimport('joomla.application.component.controllerform');

/**
 * Salutation controller class.
 */
class ClubmanagerControllerSalutation extends JControllerForm
{

    function __construct() {
        $this->view_list = 'salutations';
        parent::__construct();
    }

}