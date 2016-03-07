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
 * Clubmanager helper.
 */
class ClubmanagerHelper 
{

  /**
   * Configure the Linkbar.
  */

  public static function addSubmenu($vName = '') 
  {
    JHtmlSidebar::addEntry( JText::_('COM_CLUBMANAGER_TITLE_PEOPLES'), 'index.php?option=com_clubmanager&view=peoples',	$vName == 'peoples'	);    
    JHtmlSidebar::addEntry( JText::_('COM_CLUBMANAGER_TITLE_PEOPLES_MAIL'), 'index.php?option=com_clubmanager&view=peoplesmail',	$vName == 'peoplesmail'	);
    JHtmlSidebar::addEntry( JText::_('COM_CLUBMANAGER_TITLE_PEOPLES_PHONE'), 'index.php?option=com_clubmanager&view=peoplesphone',	$vName == 'peoplesphone'	);
    JHtmlSidebar::addEntry( JText::_('COM_CLUBMANAGER_TITLE_EMAILNEWSLETTERS'), 'index.php?option=com_clubmanager&view=emailnewsletters', $vName == 'emailnewsletters' );
    JHtmlSidebar::addEntry( JText::_('COM_CLUBMANAGER_TITLE_POSTNEWSLETTERS'), 'index.php?option=com_clubmanager&view=postnewsletters',	$vName == 'postnewsletters'	);
    JHtmlSidebar::addEntry( JText::_('COM_CLUBMANAGER_TITLE_CLUBS'), 'index.php?option=com_clubmanager&view=clubs', $vName == 'clubs' );
    JHtmlSidebar::addEntry( JText::_('COM_CLUBMANAGER_TITLE_UNIONS'), 'index.php?option=com_clubmanager&view=unions', $vName == 'unions' );
    JHtmlSidebar::addEntry( JText::_('COM_CLUBMANAGER_TITLE_UNIONDISTRICTS'), 'index.php?option=com_clubmanager&view=uniondistricts',	$vName == 'uniondistricts' );
    JHtmlSidebar::addEntry( JText::_('COM_CLUBMANAGER_TITLE_UNIONCOUNTIES'), 'index.php?option=com_clubmanager&view=unioncounties', $vName == 'unioncounties'	);
    JHtmlSidebar::addEntry( JText::_('COM_CLUBMANAGER_TITLE_UNIONCOUNTRYS'), 'index.php?option=com_clubmanager&view=unioncountrys', $vName == 'unioncountrys' );
    JHtmlSidebar::addEntry( JText::_('COM_CLUBMANAGER_TITLE_UNIONSINTERNATIONAL'), 'index.php?option=com_clubmanager&view=unionsinternational', $vName == 'unionsinternational' );
    JHtmlSidebar::addEntry( JText::_('COM_CLUBMANAGER_TITLE_CITYS'), 'index.php?option=com_clubmanager&view=citys', $vName == 'citys' );
    JHtmlSidebar::addEntry( JText::_('COM_CLUBMANAGER_TITLE_DISTRICTS'), 'index.php?option=com_clubmanager&view=districts', $vName == 'districts'	);
    JHtmlSidebar::addEntry( JText::_('COM_CLUBMANAGER_TITLE_COUNTIES'), 'index.php?option=com_clubmanager&view=counties', $vName == 'counties' );
    JHtmlSidebar::addEntry( JText::_('COM_CLUBMANAGER_TITLE_COUNTRIES'), 'index.php?option=com_clubmanager&view=countries', $vName == 'countries' );
    JHtmlSidebar::addEntry( JText::_('COM_CLUBMANAGER_TITLE_ROLES'), 'index.php?option=com_clubmanager&view=roles', $vName == 'roles'	);
    JHtmlSidebar::addEntry( JText::_('COM_CLUBMANAGER_TITLE_PEOPLEGROUPS'), 'index.php?option=com_clubmanager&view=peoplegroups', $vName == 'peoplegroups' );
    JHtmlSidebar::addEntry( JText::_('COM_CLUBMANAGER_TITLE_GENDERS'), 'index.php?option=com_clubmanager&view=genders', $vName == 'genders'	);
    JHtmlSidebar::addEntry( JText::_('COM_CLUBMANAGER_TITLE_SALUTATIONS'), 'index.php?option=com_clubmanager&view=salutations', $vName == 'salutations' );
    JHtmlSidebar::addEntry( JText::_('COM_CLUBMANAGER_TITLE_SETTINGS'), 'index.php?option=com_clubmanager&view=settings', $vName == 'settings' );
    JHtmlSidebar::addEntry( JText::_('COM_CLUBMANAGER_TITLE_CHANGELOGS'), 'index.php?option=com_clubmanager&view=changelogs', $vName == 'changelogs' );
  }

  /**
   * Gets a list of the actions that can be performed.
   *
   * @return	JObject
   * @since	1.6
  */
  public static function getActions() 
  {
    $user = JFactory::getUser();
    $result = new JObject;
    $assetName = 'com_clubmanager';
    $actions = array
    (
      'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.own', 'core.edit.state', 'core.delete'
    );

    foreach ($actions as $action) 
    {
      $result->set($action, $user->authorise($action, $assetName));
    }

    return $result;
  }

  public static function aroFormatDate($date)
  {
    $bd = $date;
    $dt = date_create($bd);
    $bo = date_timestamp_get($dt);
    $bo = date('d.m.Y', $bo);
    return $bo;
  }
}