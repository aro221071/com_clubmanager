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
    $saveOrderingUrl = 'index.php?option=com_clubmanager&task=emailnewsletters.saveOrderAjax&tmpl=component';
    JHtml::_('sortablelist.sortable', 'emailnewsletterList', 'adminForm', strtolower($listDirn), $saveOrderingUrl);
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

<form action="<?php echo JRoute::_('index.php?option=com_clubmanager&view=emailnewsletters'); ?>" method="post" name="adminForm" id="adminForm">
  <?php 
    if(!empty($this->sidebar)): ?>
      <div id="j-sidebar-container" class="span2">
        <?php echo $this->sidebar; ?>
      </div>
      <div id="j-main-container" class="span10">
   <?php else : ?>
      <div id="j-main-container">
   <?php endif;?>

    <?php
      $db = JFactory::getDBO();
      
      /* ALLE */ 
      $ownclub = " is null OR c.ownclub IN (null, 0, 1)";
      /* NUR EIGENE*/
      $ownclub = "  = 1";
      /* NUR FREMDE */
      $ownclub = "is null OR c.ownclub = 0 ";
      
      $query = "SELECT p.email1 as email
                  FROM #__clubmanager_people p 
                       LEFT JOIN #__clubmanager_club c ON p.memberclub = c.id 
                 WHERE c.ownclub " . $ownclub . "
                   AND p.email1 is not null AND p.email1 <> ''
                   AND p.state > 0
                   AND c.state > 0
                   AND p.newsletter > 0
                 UNION 
                SELECT c.email1
                  FROM #__clubmanager_club c
                 WHERE c.ownclub " . $ownclub . "
                   AND c.email1 is not null AND c.email1 <> ''
                   AND c.state > 0
                 UNION 
                SELECT p.email2
                  FROM #__clubmanager_people p 
                       LEFT JOIN #__clubmanager_club c ON p.memberclub = c.id 
                 WHERE c.ownclub " . $ownclub . "
                   AND p.email2 is not null AND p.email2 <> ''
                   AND p.state > 0
                   AND c.state > 0
                   AND p.newsletter > 0
                 UNION 
                SELECT c.email2
                  FROM #__clubmanager_club c
                 WHERE c.ownclub " . $ownclub . "
                   AND c.email2 is not null AND c.email2 <> ''
                   AND c.state > 0
                 UNION 
                SELECT p.email3
                  FROM #__clubmanager_people p 
                       LEFT JOIN #__clubmanager_club c ON p.memberclub = c.id 
                 WHERE c.ownclub " . $ownclub . "
                   AND p.email3 is not null AND p.email3 <> ''
                   AND p.state > 0
                   AND c.state > 0
                   AND p.newsletter > 0
                 UNION 
                SELECT c.email3 
                  FROM #__clubmanager_club c
                 WHERE c.ownclub " . $ownclub . "
                   AND c.email3 is not null AND c.email3 <> ''
                   AND c.state > 0
                 ORDER BY 1";
      
      $db->setQuery($query);  
      $items = $db->loadObjectlist();
      $out = "";
      $cnt = 0;
      $step = 1;
      $block = 5;
      $blockGrp = 100;
      $blockNo = 1;
      $cntBlock = 0;
      
      // Build the field options.
      $out = $out ."\nBlock $blockNo \n";
      if (!empty($items))
      {
        foreach ($items as $item)
        {
          if (strlen(trim($item->email)) > 0)
          {
            $out=$out.trim($item->email).";";
            $cnt=$cnt +1;
            if ($step == $block)
            {
              $out = $out."\n";
              $step = 1;
            }
            else
            {
              $step = $step +1;
            }
            $cntBlock = $cntBlock +1;
            if ($cntBlock == $blockGrp)
            {
              $blockNo = $blockNo + 1;
              $out = $out ."\nBlock $blockNo \n";
              $cntBlock = 0;
            }
          }
          
        }
      }
      // $out = str_replace(" ", "", $out);
      $out = str_replace("&nbsp;", "", $out);
      $out = trim($out);
    ?>
    
    <textarea rows="37" style="width:100%;">
       <?php 
         echo $out;
       ?>
    </textarea>
    <div>
      <?php echo "Es wurden " . $cnt . " E-Mail Adressen gefunden. (Anzeige = " . $block . " E-Mail Adressen pro Zeile!)" ?>
    </div>
  </div>
</form>