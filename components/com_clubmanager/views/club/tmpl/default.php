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
			<th><?php echo JText::_('COM_CLUBMANAGER_FORM_LBL_CLUB_ID'); ?></th>
			<td><?php echo $this->item->id; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_CLUBMANAGER_FORM_LBL_CLUB_FULLNAME'); ?></th>
			<td><?php echo $this->item->fullname; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_CLUBMANAGER_FORM_LBL_CLUB_PRAEFIX'); ?></th>
			<td><?php echo $this->item->praefix; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_CLUBMANAGER_FORM_LBL_CLUB_UNION'); ?></th>
			<td><?php echo $this->item->union; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_CLUBMANAGER_FORM_LBL_CLUB_NAME'); ?></th>
			<td><?php echo $this->item->name; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_CLUBMANAGER_FORM_LBL_CLUB_STREET'); ?></th>
			<td><?php echo $this->item->street; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_CLUBMANAGER_FORM_LBL_CLUB_POSTALCODE'); ?></th>
			<td><?php echo $this->item->postalcode; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_CLUBMANAGER_FORM_LBL_CLUB_CITY'); ?></th>
			<td><?php echo $this->item->city; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_CLUBMANAGER_FORM_LBL_CLUB_COUNTRY'); ?></th>
			<td><?php echo $this->item->country; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_CLUBMANAGER_FORM_LBL_CLUB_COUNTY'); ?></th>
			<td><?php echo $this->item->county; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_CLUBMANAGER_FORM_LBL_CLUB_DISTRICT'); ?></th>
			<td><?php echo $this->item->district; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_CLUBMANAGER_FORM_LBL_CLUB_OWNCLUB'); ?></th>
			<td><?php echo $this->item->ownclub; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_CLUBMANAGER_FORM_LBL_CLUB_ZVRNO'); ?></th>
			<td><?php echo $this->item->zvrno; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_CLUBMANAGER_FORM_LBL_CLUB_WEBSITE'); ?></th>
			<td><?php echo $this->item->website; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_CLUBMANAGER_FORM_LBL_CLUB_PHONE1'); ?></th>
			<td><?php echo $this->item->phone1; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_CLUBMANAGER_FORM_LBL_CLUB_PHONE2'); ?></th>
			<td><?php echo $this->item->phone2; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_CLUBMANAGER_FORM_LBL_CLUB_PHONE3'); ?></th>
			<td><?php echo $this->item->phone3; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_CLUBMANAGER_FORM_LBL_CLUB_EMAIL1'); ?></th>
			<td><?php echo $this->item->email1; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_CLUBMANAGER_FORM_LBL_CLUB_EMAIL2'); ?></th>
			<td><?php echo $this->item->email2; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_CLUBMANAGER_FORM_LBL_CLUB_EMAIL3'); ?></th>
			<td><?php echo $this->item->email3; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_CLUBMANAGER_FORM_LBL_CLUB_LOCATION'); ?></th>
			<td><?php echo $this->item->location; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_CLUBMANAGER_FORM_LBL_CLUB_DISTANCE'); ?></th>
			<td><?php echo $this->item->distance; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_CLUBMANAGER_FORM_LBL_CLUB_UNIONCOUNTRY'); ?></th>
			<td><?php echo $this->item->unioncountry; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_CLUBMANAGER_FORM_LBL_CLUB_UNIONCOUNTY'); ?></th>
			<td><?php echo $this->item->unioncounty; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_CLUBMANAGER_FORM_LBL_CLUB_UNIONDISTRICT'); ?></th>
			<td><?php echo $this->item->uniondistrict; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_CLUBMANAGER_FORM_LBL_CLUB_UNIONDISTRICTNO'); ?></th>
			<td><?php echo $this->item->uniondistrictno; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_CLUBMANAGER_FORM_LBL_CLUB_DEFAULT'); ?></th>
			<td><?php echo $this->item->default; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_CLUBMANAGER_FORM_LBL_CLUB_STATE'); ?></th>
			<td>
			<i class="icon-<?php echo ($this->item->state == 1) ? 'publish' : 'unpublish'; ?>"></i></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_CLUBMANAGER_FORM_LBL_CLUB_COMMENT'); ?></th>
			<td><?php echo $this->item->comment; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_CLUBMANAGER_FORM_LBL_CLUB_CREATED_BY'); ?></th>
			<td><?php echo $this->item->created_by_name; ?></td>
</tr>

        </table>
    </div>
    
    <?php
else:
    echo JText::_('COM_CLUBMANAGER_ITEM_NOT_LOADED');
endif;
?>
