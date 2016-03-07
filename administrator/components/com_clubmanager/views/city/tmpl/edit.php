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
        
	js('input:hidden.district').each(function(){
		var name = js(this).attr('name');
		if(name.indexOf('districthidden')){
			js('#jform_district option[value="'+js(this).val()+'"]').attr('selected',true);
		}
	});
	js("#jform_district").trigger("liszt:updated");
	js('input:hidden.county').each(function(){
		var name = js(this).attr('name');
		if(name.indexOf('countyhidden')){
			js('#jform_county option[value="'+js(this).val()+'"]').attr('selected',true);
		}
	});
	js("#jform_county").trigger("liszt:updated");
	js('input:hidden.country').each(function(){
		var name = js(this).attr('name');
		if(name.indexOf('countryhidden')){
			js('#jform_country option[value="'+js(this).val()+'"]').attr('selected',true);
		}
	});
	js("#jform_country").trigger("liszt:updated");
    });

    Joomla.submitbutton = function(task)
    {
        if (task == 'city.cancel') {
            Joomla.submitform(task, document.getElementById('city-form'));
        }
        else {
            
            if (task != 'city.cancel' && document.formvalidator.isValid(document.id('city-form'))) {
                
                Joomla.submitform(task, document.getElementById('city-form'));
            }
            else {
                alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
            }
        }
    }
</script>

<form action="<?php echo JRoute::_('index.php?option=com_clubmanager&layout=edit&id=' . (int) $this->item->id); ?>" method="post" enctype="multipart/form-data" name="adminForm" id="city-form" class="form-validate">

    <div class="form-horizontal">
        <?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general')); ?>

        <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'general', JText::_('COM_CLUBMANAGER_TITLE_CITY', true)); ?>
        <div class="row-fluid">
            <div class="span10 form-horizontal">
                <fieldset class="adminform">

                    				<input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>" />
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('name'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('name'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('postalcode'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('postalcode'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('district'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('district'); ?></div>
			</div>

			<?php
				foreach((array)$this->item->district as $value): 
					if(!is_array($value)):
						echo '<input type="hidden" class="district" name="jform[districthidden]['.$value.']" value="'.$value.'" />';
					endif;
				endforeach;
			?>			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('county'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('county'); ?></div>
			</div>

			<?php
				foreach((array)$this->item->county as $value): 
					if(!is_array($value)):
						echo '<input type="hidden" class="county" name="jform[countyhidden]['.$value.']" value="'.$value.'" />';
					endif;
				endforeach;
			?>			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('country'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('country'); ?></div>
			</div>

			<?php
				foreach((array)$this->item->country as $value): 
					if(!is_array($value)):
						echo '<input type="hidden" class="country" name="jform[countryhidden]['.$value.']" value="'.$value.'" />';
					endif;
				endforeach;
			?>			<div class="control-group">
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