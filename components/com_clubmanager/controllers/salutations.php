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

require_once JPATH_COMPONENT.'/controller.php';

/**
 * Salutations list controller class.
 */
class ClubmanagerControllerSalutations extends ClubmanagerController
{
	/**
	 * Proxy for getModel.
	 * @since	1.6
	 */
	public function &getModel($name = 'Salutations', $prefix = 'ClubmanagerModel', $config = array())
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));
		return $model;
	}
}