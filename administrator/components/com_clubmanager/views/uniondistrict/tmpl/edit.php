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
        
	js('input:hidden.unioncountry').each(function(){
		var name = js(this).attr('name');
		if(name.indexOf('unioncountryhidden')){
			js('#jform_unioncountry option[value="'+js(this).val()+'"]').attr('selected',true);
		}
	});
	js("#jform_unioncountry").trigger("liszt:updated");
	js('input:hidden.unioncounty').each(function(){
		var name = js(this).attr('name');
		if(name.indexOf('unioncountyhidden')){
			js('#jform_unioncounty option[value="'+js(this).val()+'"]').attr('selected',true);
		}
	});
	js("#jform_unioncounty").trigger("liszt:updated");
    });

    Joomla.submitbutton = function(task)
    {
        if (task == 'uniondistrict.cancel') {
            Joomla.submitform(task, document.getElementById('uniondistrict-form'));
        }
        else {
            
            if (task != 'uniondistrict.cancel' && document.formvalidator.isValid(document.id('uniondistrict-form'))) {
                
                Joomla.submitform(task, document.getElementById('uniondistrict-form'));
            }
            else {
                alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
            }
        }
    }
</script>

<form action="<?php echo JRoute::_('index.php?option=com_clubmanager&layout=edit&id=' . (int) $this->item->id); ?>" method="post" enctype="multipart/form-data" name="adminForm" id="uniondistrict-form" class="form-validate">

    <div class="form-horizontal">
        <?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general')); ?>

        <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'general', JText::_('COM_CLUBMANAGER_TITLE_UNIONDISTRICT', true)); ?>
        <div class="row-fluid">
            <div class="span10 form-horizontal">
                <fieldset class="adminform">

                    				<input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>" />
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('fullname'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('fullname'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('shortname'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('shortname'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('name'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('name'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('unioncountry'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('unioncountry'); ?></div>
			</div>

			<?php
				foreach((array)$this->item->unioncountry as $value): 
					if(!is_array($value)):
						echo '<input type="hidden" class="unioncountry" name="jform[unioncountryhidden]['.$value.']" value="'.$value.'" />';
					endif;
				endforeach;
			?>			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('unioncounty'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('unioncounty'); ?></div>
			</div>

			<?php
				foreach((array)$this->item->unioncounty as $value): 
					if(!is_array($value)):
						echo '<input type="hidden" class="unioncounty" name="jform[unioncountyhidden]['.$value.']" value="'.$value.'" />';
					endif;
				endforeach;
			?>			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('website'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('website'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('default'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('default'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('state'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('state'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('comment'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('comment'); ?></div>
			</div>
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