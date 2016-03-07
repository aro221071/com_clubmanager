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


?>
<?php if ($this->item) : ?>

    <div class="item_fields">
        <table class="table">
            
        </table>
    </div>
    
    <?php
else:
    echo JText::_('COM_CLUBMANAGER_ITEM_NOT_LOADED');
endif;
?>
