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
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');
JHtml::_('behavior.keepalive');

// Import CSS
$document = JFactory::getDocument();
$document->addStyleSheet('components/com_clubmanager/assets/css/clubmanager.css');
?>
<script type="text/javascript">
    js = jQuery.noConflict();
    js(document).ready(function() {
        
    });

    Joomla.submitbutton = function(task)
    {
        if (task == 'changelog.cancel') {
            Joomla.submitform(task, document.getElementById('changelog-form'));
        }
        else {
            
            if (task != 'changelog.cancel' && document.formvalidator.isValid(document.id('changelog-form'))) {
                
                Joomla.submitform(task, document.getElementById('changelog-form'));
            }
            else {
                alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
            }
        }
    }
</script>

<form action="<?php echo JRoute::_('index.php?option=com_clubmanager&layout=edit&id=' . (int) $this->item->id); ?>" method="post" enctype="multipart/form-data" name="adminForm" id="changelog-form" class="form-validate">

    <div class="form-horizontal">
        <?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general')); ?>

        <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'general', JText::_('COM_CLUBMANAGER_TITLE_CHANGELOG', true)); ?>
        <div class="row-fluid">
            <div class="span10 form-horizontal">
                <fieldset class="adminform">

                    				<input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>" />
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('tablename'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('tablename'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('columnname'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('columnname'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('recordid'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('recordid'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('valueold'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('valueold'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('valuenew'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('valuenew'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('created'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('created'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('comment'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('comment'); ?></div>
			</div>
				<input type="hidden" name="jform[ordering]" value="<?php echo $this->item->ordering; ?>" />
				<input type="hidden" name="jform[state]" value="<?php echo $this->item->state; ?>" />
				<input type="hidden" name="jform[checked_out]" value="<?php echo $this->item->checked_out; ?>" />
				<input type="hidden" name="jform[checked_out_time]" value="<?php echo $this->item->checked_out_time; ?>" />

				<?php if(empty($this->item->created_by)){ ?>
					<input type="hidden" name="jform[created_by]" value="<?php echo JFactory::getUser()->id; ?>" />

				<?php } 
				else{ ?>
					<input type="hidden" name="jform[created_by]" value="<?php echo $this->item->created_by; ?>" />

				<?php } ?>

                </fieldset>
            </div>
        </div>
        <?php echo JHtml::_('bootstrap.endTab'); ?>
        
        

        <?php echo JHtml::_('bootstrap.endTabSet'); ?>

        <input type="hidden" name="task" value="" />
        <?php echo JHtml::_('form.token'); ?>

    </div>
</form>