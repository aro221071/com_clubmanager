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

<form action="<?php echo JRoute::_('index.php?option=com_clubmanager&view=clubs'); ?>" method="post" name="adminForm" id="adminForm">

    <?php echo JLayoutHelper::render('default_filter', array('view' => $this), dirname(__FILE__)); ?>
    <table class="table table-striped" id = "clubList" >
        <thead >
            <tr >
                <?php if (isset($this->items[0]->state)): ?>
        <th width="1%" class="nowrap center">
            <?php echo JHtml::_('grid.sort', 'JSTATUS', 'a.state', $listDirn, $listOrder); ?>
        </th>
    <?php endif; ?>

    				<th class='left'>
				<?php echo JHtml::_('grid.sort',  'COM_CLUBMANAGER_CLUBS_FULLNAME', 'a.fullname', $listDirn, $listOrder); ?>
				</th>
				<th class='left'>
				<?php echo JHtml::_('grid.sort',  'COM_CLUBMANAGER_CLUBS_PRAEFIX', 'a.praefix', $listDirn, $listOrder); ?>
				</th>
				<th class='left'>
				<?php echo JHtml::_('grid.sort',  'COM_CLUBMANAGER_CLUBS_UNION', 'a.union', $listDirn, $listOrder); ?>
				</th>
				<th class='left'>
				<?php echo JHtml::_('grid.sort',  'COM_CLUBMANAGER_CLUBS_NAME', 'a.name', $listDirn, $listOrder); ?>
				</th>
				<th class='left'>
				<?php echo JHtml::_('grid.sort',  'COM_CLUBMANAGER_CLUBS_STREET', 'a.street', $listDirn, $listOrder); ?>
				</th>
				<th class='left'>
				<?php echo JHtml::_('grid.sort',  'COM_CLUBMANAGER_CLUBS_POSTALCODE', 'a.postalcode', $listDirn, $listOrder); ?>
				</th>
				<th class='left'>
				<?php echo JHtml::_('grid.sort',  'COM_CLUBMANAGER_CLUBS_CITY', 'a.city', $listDirn, $listOrder); ?>
				</th>
				<th class='left'>
				<?php echo JHtml::_('grid.sort',  'COM_CLUBMANAGER_CLUBS_COUNTRY', 'a.country', $listDirn, $listOrder); ?>
				</th>
				<th class='left'>
				<?php echo JHtml::_('grid.sort',  'COM_CLUBMANAGER_CLUBS_COUNTY', 'a.county', $listDirn, $listOrder); ?>
				</th>
				<th class='left'>
				<?php echo JHtml::_('grid.sort',  'COM_CLUBMANAGER_CLUBS_DISTRICT', 'a.district', $listDirn, $listOrder); ?>
				</th>
				<th class='left'>
				<?php echo JHtml::_('grid.sort',  'COM_CLUBMANAGER_CLUBS_OWNCLUB', 'a.ownclub', $listDirn, $listOrder); ?>
				</th>
				<th class='left'>
				<?php echo JHtml::_('grid.sort',  'COM_CLUBMANAGER_CLUBS_ZVRNO', 'a.zvrno', $listDirn, $listOrder); ?>
				</th>
				<th class='left'>
				<?php echo JHtml::_('grid.sort',  'COM_CLUBMANAGER_CLUBS_WEBSITE', 'a.website', $listDirn, $listOrder); ?>
				</th>
				<th class='left'>
				<?php echo JHtml::_('grid.sort',  'COM_CLUBMANAGER_CLUBS_PHONE1', 'a.phone1', $listDirn, $listOrder); ?>
				</th>
				<th class='left'>
				<?php echo JHtml::_('grid.sort',  'COM_CLUBMANAGER_CLUBS_PHONE2', 'a.phone2', $listDirn, $listOrder); ?>
				</th>
				<th class='left'>
				<?php echo JHtml::_('grid.sort',  'COM_CLUBMANAGER_CLUBS_PHONE3', 'a.phone3', $listDirn, $listOrder); ?>
				</th>
				<th class='left'>
				<?php echo JHtml::_('grid.sort',  'COM_CLUBMANAGER_CLUBS_EMAIL1', 'a.email1', $listDirn, $listOrder); ?>
				</th>
				<th class='left'>
				<?php echo JHtml::_('grid.sort',  'COM_CLUBMANAGER_CLUBS_EMAIL2', 'a.email2', $listDirn, $listOrder); ?>
				</th>
				<th class='left'>
				<?php echo JHtml::_('grid.sort',  'COM_CLUBMANAGER_CLUBS_EMAIL3', 'a.email3', $listDirn, $listOrder); ?>
				</th>
				<th class='left'>
				<?php echo JHtml::_('grid.sort',  'COM_CLUBMANAGER_CLUBS_LOCATION', 'a.location', $listDirn, $listOrder); ?>
				</th>
				<th class='left'>
				<?php echo JHtml::_('grid.sort',  'COM_CLUBMANAGER_CLUBS_DISTANCE', 'a.distance', $listDirn, $listOrder); ?>
				</th>
				<th class='left'>
				<?php echo JHtml::_('grid.sort',  'COM_CLUBMANAGER_CLUBS_UNIONCOUNTRY', 'a.unioncountry', $listDirn, $listOrder); ?>
				</th>
				<th class='left'>
				<?php echo JHtml::_('grid.sort',  'COM_CLUBMANAGER_CLUBS_UNIONCOUNTY', 'a.unioncounty', $listDirn, $listOrder); ?>
				</th>
				<th class='left'>
				<?php echo JHtml::_('grid.sort',  'COM_CLUBMANAGER_CLUBS_UNIONDISTRICT', 'a.uniondistrict', $listDirn, $listOrder); ?>
				</th>
				<th class='left'>
				<?php echo JHtml::_('grid.sort',  'COM_CLUBMANAGER_CLUBS_UNIONDISTRICTNO', 'a.uniondistrictno', $listDirn, $listOrder); ?>
				</th>
				<th class='left'>
				<?php echo JHtml::_('grid.sort',  'COM_CLUBMANAGER_CLUBS_DEFAULT', 'a.default', $listDirn, $listOrder); ?>
				</th>
				<th class='left'>
				<?php echo JHtml::_('grid.sort',  'COM_CLUBMANAGER_CLUBS_COMMENT', 'a.comment', $listDirn, $listOrder); ?>
				</th>


    <?php if (isset($this->items[0]->id)): ?>
        <th width="1%" class="nowrap center hidden-phone">
            <?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ID', 'a.id', $listDirn, $listOrder); ?>
        </th>
    <?php endif; ?>

    				<?php if ($canEdit || $canDelete): ?>
					<th class="center">
				<?php echo JText::_('COM_CLUBMANAGER_CLUBS_ACTIONS'); ?>
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
                       href="<?php echo ($canEdit || $canChange) ? JRoute::_('index.php?option=com_clubmanager&task=club.publish&id=' . $item->id . '&state=' . (($item->state + 1) % 2), false, 2) : '#'; ?>">
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
					<?php echo JHtml::_('jgrid.checkedout', $i, $item->editor, $item->checked_out_time, 'clubs.', $canCheckin); ?>
				<?php endif; ?>
				<a href="<?php echo JRoute::_('index.php?option=com_clubmanager&view=club&id='.(int) $item->id); ?>">
				<?php echo $this->escape($item->fullname); ?></a>
				</td>
				<td>

					<?php echo $item->praefix; ?>
				</td>
				<td>

					<?php echo $item->union; ?>
				</td>
				<td>

					<?php echo $item->name; ?>
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

					<?php echo $item->country; ?>
				</td>
				<td>

					<?php echo $item->county; ?>
				</td>
				<td>

					<?php echo $item->district; ?>
				</td>
				<td>

					<?php echo $item->ownclub; ?>
				</td>
				<td>

					<?php echo $item->zvrno; ?>
				</td>
				<td>

					<?php echo $item->website; ?>
				</td>
				<td>

					<?php echo $item->phone1; ?>
				</td>
				<td>

					<?php echo $item->phone2; ?>
				</td>
				<td>

					<?php echo $item->phone3; ?>
				</td>
				<td>

					<?php echo $item->email1; ?>
				</td>
				<td>

					<?php echo $item->email2; ?>
				</td>
				<td>

					<?php echo $item->email3; ?>
				</td>
				<td>

					<?php echo $item->location; ?>
				</td>
				<td>

					<?php echo $item->distance; ?>
				</td>
				<td>

					<?php echo $item->unioncountry; ?>
				</td>
				<td>

					<?php echo $item->unioncounty; ?>
				</td>
				<td>

					<?php echo $item->uniondistrict; ?>
				</td>
				<td>

					<?php echo $item->uniondistrictno; ?>
				</td>
				<td>

					<?php echo $item->default; ?>
				</td>
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
        <a href="<?php echo JRoute::_('index.php?option=com_clubmanager&task=clubform.edit&id=0', false, 2); ?>"
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
            window.location.href = '<?php echo JRoute::_('index.php?option=com_clubmanager&task=clubform.remove&id=', false, 2) ?>' + item_id;
        }
    }
</script>


