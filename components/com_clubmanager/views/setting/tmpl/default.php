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
			<th><?php echo JText::_('COM_CLUBMANAGER_FORM_LBL_SETTING_ID'); ?></th>
			<td><?php echo $this->item->id; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_CLUBMANAGER_FORM_LBL_SETTING_NAME'); ?></th>
			<td><?php echo $this->item->name; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_CLUBMANAGER_FORM_LBL_SETTING_KEY'); ?></th>
			<td><?php echo $this->item->key; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_CLUBMANAGER_FORM_LBL_SETTING_DATATYPE'); ?></th>
			<td><?php echo $this->item->datatype; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_CLUBMANAGER_FORM_LBL_SETTING_VALUE_NUMERIC'); ?></th>
			<td><?php echo $this->item->value_numeric; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_CLUBMANAGER_FORM_LBL_SETTING_VALUE_TEXT'); ?></th>
			<td><?php echo $this->item->value_text; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_CLUBMANAGER_FORM_LBL_SETTING_VALUE_DATE'); ?></th>
			<td><?php echo $this->item->value_date; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_CLUBMANAGER_FORM_LBL_SETTING_STATE'); ?></th>
			<td>
			<i class="icon-<?php echo ($this->item->state == 1) ? 'publish' : 'unpublish'; ?>"></i></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_CLUBMANAGER_FORM_LBL_SETTING_COMMENT'); ?></th>
			<td><?php echo $this->item->comment; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_CLUBMANAGER_FORM_LBL_SETTING_CREATED_BY'); ?></th>
			<td><?php echo $this->item->created_by_name; ?></td>
</tr>

        </table>
    </div>
    
    <?php
else:
    echo JText::_('COM_CLUBMANAGER_ITEM_NOT_LOADED');
endif;
?>
