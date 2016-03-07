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
			<th><?php echo JText::_('COM_CLUBMANAGER_FORM_LBL_PEOPLE_ID'); ?></th>
			<td><?php echo $this->item->id; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_CLUBMANAGER_FORM_LBL_PEOPLE_FULLNAME'); ?></th>
			<td><?php echo $this->item->fullname; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_CLUBMANAGER_FORM_LBL_PEOPLE_FIRSTNAME'); ?></th>
			<td><?php echo $this->item->firstname; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_CLUBMANAGER_FORM_LBL_PEOPLE_LASTNAME'); ?></th>
			<td><?php echo $this->item->lastname; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_CLUBMANAGER_FORM_LBL_PEOPLE_SALUTATION'); ?></th>
			<td><?php echo $this->item->salutation; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_CLUBMANAGER_FORM_LBL_PEOPLE_GENDER'); ?></th>
			<td><?php echo $this->item->gender; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_CLUBMANAGER_FORM_LBL_PEOPLE_NICKNAME'); ?></th>
			<td><?php echo $this->item->nickname; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_CLUBMANAGER_FORM_LBL_PEOPLE_BIRTHDATE'); ?></th>
			<td><?php echo $this->item->birthdate; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_CLUBMANAGER_FORM_LBL_PEOPLE_MEMBERCLUB'); ?></th>
			<td><?php echo $this->item->memberclub; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_CLUBMANAGER_FORM_LBL_PEOPLE_MEMBERNO'); ?></th>
			<td><?php echo $this->item->memberno; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_CLUBMANAGER_FORM_LBL_PEOPLE_PHONE1'); ?></th>
			<td><?php echo $this->item->phone1; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_CLUBMANAGER_FORM_LBL_PEOPLE_PHONE2'); ?></th>
			<td><?php echo $this->item->phone2; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_CLUBMANAGER_FORM_LBL_PEOPLE_PHONE3'); ?></th>
			<td><?php echo $this->item->phone3; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_CLUBMANAGER_FORM_LBL_PEOPLE_EMAIL1'); ?></th>
			<td><?php echo $this->item->email1; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_CLUBMANAGER_FORM_LBL_PEOPLE_EMAIL2'); ?></th>
			<td><?php echo $this->item->email2; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_CLUBMANAGER_FORM_LBL_PEOPLE_EMAIL3'); ?></th>
			<td><?php echo $this->item->email3; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_CLUBMANAGER_FORM_LBL_PEOPLE_STREET'); ?></th>
			<td><?php echo $this->item->street; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_CLUBMANAGER_FORM_LBL_PEOPLE_POSTALCODE'); ?></th>
			<td><?php echo $this->item->postalcode; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_CLUBMANAGER_FORM_LBL_PEOPLE_CITY'); ?></th>
			<td><?php echo $this->item->city; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_CLUBMANAGER_FORM_LBL_PEOPLE_COUNTY'); ?></th>
			<td><?php echo $this->item->county; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_CLUBMANAGER_FORM_LBL_PEOPLE_COUNTRY'); ?></th>
			<td><?php echo $this->item->country; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_CLUBMANAGER_FORM_LBL_PEOPLE_DISTRICT'); ?></th>
			<td><?php echo $this->item->district; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_CLUBMANAGER_FORM_LBL_PEOPLE_WEBSITE'); ?></th>
			<td><?php echo $this->item->website; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_CLUBMANAGER_FORM_LBL_PEOPLE_FUNCTION'); ?></th>
			<td><?php echo $this->item->function; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_CLUBMANAGER_FORM_LBL_PEOPLE_ROLE'); ?></th>
			<td><?php echo $this->item->role; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_CLUBMANAGER_FORM_LBL_PEOPLE_NEWSLETTER'); ?></th>
			<td><?php echo $this->item->newsletter; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_CLUBMANAGER_FORM_LBL_PEOPLE_IBAN'); ?></th>
			<td><?php echo $this->item->iban; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_CLUBMANAGER_FORM_LBL_PEOPLE_BIC'); ?></th>
			<td><?php echo $this->item->bic; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_CLUBMANAGER_FORM_LBL_PEOPLE_PICTURE'); ?></th>
			<td>
			<?php $uploadPath = 'administrator' . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_clubmanager' . DIRECTORY_SEPARATOR . 'images/phocagallery/_contact' . DIRECTORY_SEPARATOR . $this->item->picture; ?>
			<a href="<?php echo JRoute::_(JUri::base() . $uploadPath, false); ?>" target="_blank"><?php echo $this->item->picture; ?></a></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_CLUBMANAGER_FORM_LBL_PEOPLE_DIED'); ?></th>
			<td><?php echo $this->item->died; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_CLUBMANAGER_FORM_LBL_PEOPLE_STATE'); ?></th>
			<td>
			<i class="icon-<?php echo ($this->item->state == 1) ? 'publish' : 'unpublish'; ?>"></i></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_CLUBMANAGER_FORM_LBL_PEOPLE_COMMENT'); ?></th>
			<td><?php echo $this->item->comment; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_CLUBMANAGER_FORM_LBL_PEOPLE_CREATED_BY'); ?></th>
			<td><?php echo $this->item->created_by_name; ?></td>
</tr>

        </table>
    </div>
    
    <?php
else:
    echo JText::_('COM_CLUBMANAGER_ITEM_NOT_LOADED');
endif;
?>
