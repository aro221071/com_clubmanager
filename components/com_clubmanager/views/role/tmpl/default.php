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

$canEdit = JFactory::getUser()->authorise('core.edit', 'com_clubmanager');
if (!$canEdit && JFactory::getUser()->authorise('core.edit.own', 'com_clubmanager')) {
	$canEdit = JFactory::getUser()->id == $this->item->created_by;
}
?>
<?php if ($this->item) : ?>

    <div class="item_fields">
        <table class="table">
            <tr>
			<th><?php echo JText::_('COM_CLUBMANAGER_FORM_LBL_ROLE_ID'); ?></th>
			<td><?php echo $this->item->id; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_CLUBMANAGER_FORM_LBL_ROLE_NAME'); ?></th>
			<td><?php echo $this->item->name; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_CLUBMANAGER_FORM_LBL_ROLE_SHORTNAME'); ?></th>
			<td><?php echo $this->item->shortname; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_CLUBMANAGER_FORM_LBL_ROLE_DEFAULT'); ?></th>
			<td><?php echo $this->item->default; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_CLUBMANAGER_FORM_LBL_ROLE_STATE'); ?></th>
			<td>
			<i class="icon-<?php echo ($this->item->state == 1) ? 'publish' : 'unpublish'; ?>"></i></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_CLUBMANAGER_FORM_LBL_ROLE_COMMENT'); ?></th>
			<td><?php echo $this->item->comment; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_CLUBMANAGER_FORM_LBL_ROLE_CREATED_BY'); ?></th>
			<td><?php echo $this->item->created_by_name; ?></td>
</tr>

        </table>
    </div>
    <?php if($canEdit && $this->item->checked_out == 0): ?>
		<a class="btn" href="<?php echo JRoute::_('index.php?option=com_clubmanager&task=role.edit&id='.$this->item->id); ?>"><?php echo JText::_("COM_CLUBMANAGER_EDIT_ITEM"); ?></a>
	<?php endif; ?>
								<?php if(JFactory::getUser()->authorise('core.delete','com_clubmanager')):?>
									<a class="btn" href="<?php echo JRoute::_('index.php?option=com_clubmanager&task=role.remove&id=' . $this->item->id, false, 2); ?>"><?php echo JText::_("COM_CLUBMANAGER_DELETE_ITEM"); ?></a>
								<?php endif; ?>
    <?php
else:
    echo JText::_('COM_CLUBMANAGER_ITEM_NOT_LOADED');
endif;
?>
