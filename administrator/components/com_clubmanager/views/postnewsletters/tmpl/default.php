<?php
  /**
   * @version     1.0.0
   * @package     com_clubmanager
   * @copyright   Copyright (C) 2015. Alle Rechte vorbehalten.
   * @license     GNU General Public License Version 2 oder später; siehe LICENSE.txt
   * @author      Roman Artelsmair <roman@artelsmair.at> - http://www.artelsmair.at
   */
  
  // no direct access
  defined('_JEXEC') or die;
  
  JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
  JHtml::_('bootstrap.tooltip');
  JHtml::_('behavior.multiselect');
  JHtml::_('formbehavior.chosen', 'select');
  
  // Import CSS
  $document = JFactory::getDocument();
  $document->addStyleSheet('components/com_clubmanager/assets/css/clubmanager.css');
  
  $user  = JFactory::getUser();
  $userId  = $user->get('id');
  $listOrder  = $this->state->get('list.ordering');
  $listDirn  = $this->state->get('list.direction');
  $canOrder  = $user->authorise('core.edit.state', 'com_clubmanager');
  $saveOrder  = $listOrder == 'a.ordering';
  if ($saveOrder)
  {
    $saveOrderingUrl = 'index.php?option=com_clubmanager&task=postnewsletters.saveOrderAjax&tmpl=component';
    JHtml::_('sortablelist.sortable', 'postnewsletterList', 'adminForm', strtolower($listDirn), $saveOrderingUrl);
  }
  $sortFields = $this->getSortFields();
?>

<script type="text/javascript">
  Joomla.orderTable = function() {
    table = document.getElementById("sortTable");
    direction = document.getElementById("directionTable");
    order = table.options[table.selectedIndex].value;
    if (order != '<?php echo $listOrder; ?>') 
    {
      dirn = 'asc';
    }
    else
    {
      dirn = direction.options[direction.selectedIndex].value;
    }
    Joomla.tableOrdering(order, dirn, '');
  }

  jQuery(document).ready(function () {
    jQuery('#clear-search-button').on('click', function () {
      jQuery('#filter_search').val('');
      jQuery('#adminForm').submit();
    });
  });
</script>

<?php
  //Joomla Component Creator code to allow adding non select list filters
  if (!empty($this->extra_sidebar)) 
  {
    $this->sidebar .= $this->extra_sidebar;
  }
?>

<form action="<?php echo JRoute::_('index.php?option=com_clubmanager&view=postnewsletters'); ?>" method="post" name="adminForm" id="adminForm">
  <?php 
    if(!empty($this->sidebar)): ?>
      <div id="j-sidebar-container" class="span2">
        <?php echo $this->sidebar; ?>
      </div>
      <div id="j-main-container" class="span10">
   <?php else : ?>
      <div id="j-main-container">
   <?php endif;?>

    <textarea rows="30" cols="300" style="width:800px;height:500px;">
        <?php
          $db = JFactory::getDBO();
          
          /* NUR EIGENE*/
          $ownclub = "  = 1";
          /* NUR FREMDE */
          $ownclub = "is null OR c.ownclub = 0 ";
          /* ALLE */ 
          $ownclub = " is null OR c.ownclub IN (null, 0, 1)";
          
             
          $query = "SELECT p.fullname as name, p.street, s.postalcode, s.name as city
                      FROM #__clubmanager_people p 
                           LEFT OUTER JOIN #__clubmanager_club c ON c.id = p.memberclub
                           LEFT JOIN #__clubmanager_city s ON s.id = p.city 
                     WHERE c.ownclub " . $ownclub . "
                       AND p.fullname is not null AND p.fullname <> '' AND p.fullname <> '<unbekannt>'
                       AND p.street is not null AND p.street <> ''
                       AND p.postalcode is not null AND p.postalcode <> ''
                       AND p.city is not null AND p.city <> ''
                       AND p.newsletter > 0
                     UNION 
                    SELECT c.fullname as name, c.street, s.postalcode, s.name as city
                      FROM #__clubmanager_club c
                           LEFT JOIN #__clubmanager_city s ON s.id = c.city 
                     WHERE c.ownclub " . $ownclub . "
                       AND c.fullname is not null AND c.fullname <> '' AND c.fullname <> '<unbekannt>'
                       AND c.street is not null AND c.street <> ''
                       AND s.postalcode is not null AND s.postalcode <> ''
                       AND s.name is not null AND s.name <> ''
                     ORDER BY 1";
          $db->setQuery($query);  
          $items = $db->loadObjectlist();
          $out = "";
          $cnt = 0;
          // Build the field options.
          if (!empty($items))
          {
            foreach ($items as $item)
            { 
              if (strlen(trim($item->name))       > 0 AND
                  strlen(trim($item->street))     > 0 AND
                  strlen(trim($item->postalcode)) > 0 AND
                  strlen(trim($item->city))       > 0
                 )
              {
                $out = $out . $item->name . "\n";
                $out = $out . $item->street . "\n";
                $out = $out . $item->postalcode . " " . $item->city . "\n";
                $out = $out . "\n";
                $cnt++;
              }
            }
          }
          echo $out;
        ?>            
    </textarea>
    <div>
      <?php echo "Es wurden " . $cnt . " Post Adressen gefunden." ?>
    </div>
  </div>
    
</form>        

    
