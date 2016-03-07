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
            <tr>
			<th><?php echo JText::_('COM_CLUBMANAGER_FORM_LBL_UNION_ID'); ?></th>
			<td><?php echo $this->item->id; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_CLUBMANAGER_FORM_LBL_UNION_SHORTNAME'); ?></th>
			<td><?php echo $this->item->shortname; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_CLUBMANAGER_FORM_LBL_UNION_NAME'); ?></th>
			<td><?php echo $this->item->name; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_CLUBMANAGER_FORM_LBL_UNION_WEBSITE'); ?></th>
			<td><?php echo $this->item->website; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_CLUBMANAGER_FORM_LBL_UNION_STATE'); ?></th>
			<td>
			<i class="icon-<?php echo ($this->item->state == 1) ? 'publish' : 'unpublish'; ?>"></i></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_CLUBMANAGER_FORM_LBL_UNION_COMMENT'); ?></th>
			<td><?php echo $this->item->comment; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_CLUBMANAGER_FORM_LBL_UNION_CREATED_BY'); ?></th>
			<td><?php echo $this->item->created_by_name; ?></td>
</tr>

        </table>
    </div>
    
    <?php
else:
    echo JText::_('COM_CLUBMANAGER_ITEM_NOT_LOADED');
endif;
?>
