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

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('formbehavior.chosen', 'select');

$user = JFactory::getUser();
$userId = $user->get('id');
$listOrder = $this->state->get('list.ordering');
$listDirn = $this->state->get('list.direction');
$canCreate = $user->authorise('core.create', 'com_clubmanager');
$canEdit = $user->authorise('core.edit', 'com_clubmanager');
$canCheckin = $user->authorise('core.manage', 'com_clubmanager');
$canChange = $user->authorise('core.edit.state', 'com_clubmanager');
$canDelete = $user->authorise('core.delete', 'com_clubmanager');
?>

<form action="<?php echo JRoute::_('index.php?option=com_clubmanager&view=peoples'); ?>" method="post" name="adminForm" id="adminForm">

    <?php echo JLayoutHelper::render('default_filter', array('view' => $this), dirname(__FILE__)); ?>
    <table class="table table-striped" id = "peopleList" >
        <thead >
            <tr >
                <?php if (isset($this->items[0]->state)): ?>
        <th width="1%" class="nowrap center">
            <?php echo JHtml::_('grid.sort', 'JSTATUS', 'a.state', $listDirn, $listOrder); ?>
        </th>
    <?php endif; ?>

    				<th class='left'>
				<?php echo JHtml::_('grid.sort',  'COM_CLUBMANAGER_PEOPLES_FULLNAME', 'a.fullname', $listDirn, $listOrder); ?>
				</th>
				<th class='left'>
				<?php echo JHtml::_('grid.sort',  'COM_CLUBMANAGER_PEOPLES_FIRSTNAME', 'a.firstname', $listDirn, $listOrder); ?>
				</th>
				<th class='left'>
				<?php echo JHtml::_('grid.sort',  'COM_CLUBMANAGER_PEOPLES_LASTNAME', 'a.lastname', $listDirn, $listOrder); ?>
				</th>
				<th class='left'>
				<?php echo JHtml::_('grid.sort',  'COM_CLUBMANAGER_PEOPLES_SALUTATION', 'a.salutation', $listDirn, $listOrder); ?>
				</th>
				<th class='left'>
				<?php echo JHtml::_('grid.sort',  'COM_CLUBMANAGER_PEOPLES_GENDER', 'a.gender', $listDirn, $listOrder); ?>
				</th>
				<th class='left'>
				<?php echo JHtml::_('grid.sort',  'COM_CLUBMANAGER_PEOPLES_NICKNAME', 'a.nickname', $listDirn, $listOrder); ?>
				</th>
				<th class='left'>
				<?php echo JHtml::_('grid.sort',  'COM_CLUBMANAGER_PEOPLES_BIRTHDATE', 'a.birthdate', $listDirn, $listOrder); ?>
				</th>
				<th class='left'>
				<?php echo JHtml::_('grid.sort',  'COM_CLUBMANAGER_PEOPLES_MEMBERCLUB', 'a.memberclub', $listDirn, $listOrder); ?>
				</th>
				<th class='left'>
				<?php echo JHtml::_('grid.sort',  'COM_CLUBMANAGER_PEOPLES_MEMBERNO', 'a.memberno', $listDirn, $listOrder); ?>
				</th>
				<th class='left'>
				<?php echo JHtml::_('grid.sort',  'COM_CLUBMANAGER_PEOPLES_PHONE1', 'a.phone1', $listDirn, $listOrder); ?>
				</th>
				<th class='left'>
				<?php echo JHtml::_('grid.sort',  'COM_CLUBMANAGER_PEOPLES_EMAIL1', 'a.email1', $listDirn, $listOrder); ?>
				</th>
				<th class='left'>
				<?php echo JHtml::_('grid.sort',  'COM_CLUBMANAGER_PEOPLES_STREET', 'a.street', $listDirn, $listOrder); ?>
				</th>
				<th class='left'>
				<?php echo JHtml::_('grid.sort',  'COM_CLUBMANAGER_PEOPLES_POSTALCODE', 'a.postalcode', $listDirn, $listOrder); ?>
				</th>
				<th class='left'>
				<?php echo JHtml::_('grid.sort',  'COM_CLUBMANAGER_PEOPLES_CITY', 'a.city', $listDirn, $listOrder); ?>
				</th>
				<th class='left'>
				<?php echo JHtml::_('grid.sort',  'COM_CLUBMANAGER_PEOPLES_ROLE', 'a.role', $listDirn, $listOrder); ?>
				</th>
				<th class='left'>
				<?php echo JHtml::_('grid.sort',  'COM_CLUBMANAGER_PEOPLES_NEWSLETTER', 'a.newsletter', $listDirn, $listOrder); ?>
				</th>
				<th class='left'>
				<?php echo JHtml::_('grid.sort',  'COM_CLUBMANAGER_PEOPLES_IBAN', 'a.iban', $listDirn, $listOrder); ?>
				</th>
				<th class='left'>
				<?php echo JHtml::_('grid.sort',  'COM_CLUBMANAGER_PEOPLES_BIC', 'a.bic', $listDirn, $listOrder); ?>
				</th>
				<th class='left'>
				<?php echo JHtml::_('grid.sort',  'COM_CLUBMANAGER_PEOPLES_PICTURE', 'a.picture', $listDirn, $listOrder); ?>
				</th>
				<th class='left'>
				<?php echo JHtml::_('grid.sort',  'COM_CLUBMANAGER_PEOPLES_COMMENT', 'a.comment', $listDirn, $listOrder); ?>
				</th>


    <?php if (isset($this->items[0]->id)): ?>
        <th width="1%" class="nowrap center hidden-phone">
            <?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ID', 'a.id', $listDirn, $listOrder); ?>
        </th>
    <?php endif; ?>

    				<?php if ($canEdit || $canDelete): ?>
					<th class="center">
				<?php echo JText::_('COM_CLUBMANAGER_PEOPLES_ACTIONS'); ?>
				</th>
				<?php endif; ?>

    </tr>
    </thead>
    <tfoot>
    <tr>
        <td colspan="<?php echo isset($this->items[0]) ? count(get_object_vars($this->items[0])) : 10; ?>">
            <?php echo $this->pagination->getListFooter(); ?>
        </td>
    </tr>
    </tfoot>
    <tbody>
    <?php foreach ($this->items as $i => $item) : ?>
        <?php $canEdit = $user->authorise('core.edit', 'com_clubmanager'); ?>

        
        <tr class="row<?php echo $i % 2; ?>">

            <?php if (isset($this->items[0]->state)): ?>
                <?php $class = ($canEdit || $canChange) ? 'active' : 'disabled'; ?>
                <td class="center">
                    <a class="btn btn-micro <?php echo $class; ?>"
                       href="<?php echo ($canEdit || $canChange) ? JRoute::_('index.php?option=com_clubmanager&task=people.publish&id=' . $item->id . '&state=' . (($item->state + 1) % 2), false, 2) : '#'; ?>">
                        <?php if ($item->state == 1): ?>
                            <i class="icon-publish"></i>
                        <?php else: ?>
                            <i class="icon-unpublish"></i>
                        <?php endif; ?>
                    </a>
                </td>
            <?php endif; ?>

            				<td>
				<?php if (isset($item->checked_out) && $item->checked_out) : ?>
					<?php echo JHtml::_('jgrid.checkedout', $i, $item->editor, $item->checked_out_time, 'peoples.', $canCheckin); ?>
				<?php endif; ?>
				<a href="<?php echo JRoute::_('index.php?option=com_clubmanager&view=people&id='.(int) $item->id); ?>">
				<?php echo $this->escape($item->fullname); ?></a>
				</td>
				<td>

					<?php echo $item->firstname; ?>
				</td>
				<td>

					<?php echo $item->lastname; ?>
				</td>
				<td>

					<?php echo $item->salutation; ?>
				</td>
				<td>

					<?php echo $item->gender; ?>
				</td>
				<td>

					<?php echo $item->nickname; ?>
				</td>
				<td>

					<?php echo $item->birthdate; ?>
				</td>
				<td>

					<?php echo $item->memberclub; ?>
				</td>
				<td>

					<?php echo $item->memberno; ?>
				</td>
				<td>

					<?php echo $item->phone1; ?>
				</td>
				<td>

					<?php echo $item->email1; ?>
				</td>
				<td>

					<?php echo $item->street; ?>
				</td>
				<td>

					<?php echo $item->postalcode; ?>
				</td>
				<td>

					<?php echo $item->city; ?>
				</td>
				<td>

					<?php echo $item->role; ?>
				</td>
				<td>

					<?php echo $item->newsletter; ?>
				</td>
				<td>

					<?php echo $item->iban; ?>
				</td>
				<td>

					<?php echo $item->bic; ?>
				</td>
				<td>

					<?php
						if (!empty($item->picture)):
							$uploadPath = 'administrator' . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_clubmanager' . DIRECTORY_SEPARATOR . 'images/phocagallery/_contact' .DIRECTORY_SEPARATOR . $item->picture;
							echo '<a href="' . JRoute::_(JUri::base() . $uploadPath, false) . '" target="_blank" title="See the picture">' . $item->picture . '</a>';
						else:
							echo $item->picture;
						endif; ?>				</td>
				<td>

					<?php echo $item->comment; ?>
				</td>


            <?php if (isset($this->items[0]->id)): ?>
                <td class="center hidden-phone">
                    <?php echo (int)$item->id; ?>
                </td>
            <?php endif; ?>

            				<?php if ($canEdit || $canDelete): ?>
					<td class="center">
					</td>
				<?php endif; ?>

        </tr>
    <?php endforeach; ?>
    </tbody>
    </table>

    <?php if ($canCreate): ?>
        <a href="<?php echo JRoute::_('index.php?option=com_clubmanager&task=peopleform.edit&id=0', false, 2); ?>"
           class="btn btn-success btn-small"><i
                class="icon-plus"></i> <?php echo JText::_('COM_CLUBMANAGER_ADD_ITEM'); ?></a>
    <?php endif; ?>

    <input type="hidden" name="task" value=""/>
    <input type="hidden" name="boxchecked" value="0"/>
    <input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>"/>
    <input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>"/>
    <?php echo JHtml::_('form.token'); ?>
</form>

<script type="text/javascript">

    jQuery(document).ready(function () {
        jQuery('.delete-button').click(deleteItem);
    });

    function deleteItem() {
        var item_id = jQuery(this).attr('data-item-id');
        if (confirm("<?php echo JText::_('COM_CLUBMANAGER_DELETE_MESSAGE'); ?>")) {
            window.location.href = '<?php echo JRoute::_('index.php?option=com_clubmanager&task=peopleform.remove&id=', false, 2) ?>' + item_id;
        }
    }
</script>


