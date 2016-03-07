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

JHtml::_('behavior.keepalive');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');

//Load admin language file
$lang = JFactory::getLanguage();
$lang->load('com_clubmanager', JPATH_ADMINISTRATOR);
$doc = JFactory::getDocument();
$doc->addScript(JUri::base() . '/components/com_clubmanager/assets/js/form.js');


if($this->item->state == 1){
	$state_string = 'Publish';
	$state_value = 1;
} else {
	$state_string = 'Unpublish';
	$state_value = 0;
}
$canState = JFactory::getUser()->authorise('core.edit.state','com_clubmanager');
?>
</style>
<script type="text/javascript">
    if (jQuery === 'undefined') {
        document.addEventListener("DOMContentLoaded", function(event) { 
            jQuery('#form-role').submit(function(event) {
                
            });

            
        });
    } else {
        jQuery(document).ready(function() {
            jQuery('#form-role').submit(function(event) {
                
            });

            
        });
    }
</script>

<div class="role-edit front-end-edit">
    <?php if (!empty($this->item->id)): ?>
        <h1>Edit <?php echo $this->item->id; ?></h1>
    <?php else: ?>
        <h1>Add</h1>
    <?php endif; ?>

    <form id="form-role" action="<?php echo JRoute::_('index.php?option=com_clubmanager&task=role.save'); ?>" method="post" class="form-validate form-horizontal" enctype="multipart/form-data">
        
	<input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>" />

	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('name'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('name'); ?></div>
	</div>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('shortname'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('shortname'); ?></div>
	</div>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('default'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('default'); ?></div>
	</div>
	<div class="control-group">
		<?php if(!$canState): ?>
			<div class="control-label"><?php echo $this->form->getLabel('state'); ?></div>
			<div class="controls"><?php echo $state_string; ?></div>
			<input type="hidden" name="jform[state]" value="<?php echo $state_value; ?>" />
		<?php else: ?>
			<div class="control-label"><?php echo $this->form->getLabel('state'); ?></div>
			<div class="controls"><?php echo $this->form->getInput('state'); ?></div>
		<?php endif; ?>
	</div>

	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('comment'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('comment'); ?></div>
	</div>
	<input type="hidden" name="jform[checked_out]" value="<?php echo $this->item->checked_out; ?>" />

	<input type="hidden" name="jform[checked_out_time]" value="<?php echo $this->item->checked_out_time; ?>" />

	<?php if(empty($this->item->created_by)): ?>
		<input type="hidden" name="jform[created_by]" value="<?php echo JFactory::getUser()->id; ?>" />
	<?php else: ?>
		<input type="hidden" name="jform[created_by]" value="<?php echo $this->item->created_by; ?>" />
	<?php endif; ?>
        <div class="control-group">
            <div class="controls">
                <button type="submit" class="validate btn btn-primary"><?php echo JText::_('JSUBMIT'); ?></button>
                <a class="btn" href="<?php echo JRoute::_('index.php?option=com_clubmanager&task=roleform.cancel'); ?>" title="<?php echo JText::_('JCANCEL'); ?>"><?php echo JText::_('JCANCEL'); ?></a>
            </div>
        </div>
        
        <input type="hidden" name="option" value="com_clubmanager" />
        <input type="hidden" name="task" value="roleform.save" />
        <?php echo JHtml::_('form.token'); ?>
    </form>
</div>
