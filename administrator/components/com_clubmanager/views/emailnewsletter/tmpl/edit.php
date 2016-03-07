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
        
	js('input:hidden.salutation').each(function(){
		var name = js(this).attr('name');
		if(name.indexOf('salutationhidden')){
			js('#jform_salutation option[value="'+js(this).val()+'"]').attr('selected',true);
		}
	});
	js("#jform_salutation").trigger("liszt:updated");
	js('input:hidden.gender').each(function(){
		var name = js(this).attr('name');
		if(name.indexOf('genderhidden')){
			js('#jform_gender option[value="'+js(this).val()+'"]').attr('selected',true);
		}
	});
	js("#jform_gender").trigger("liszt:updated");
	js('input:hidden.memberclub').each(function(){
		var name = js(this).attr('name');
		if(name.indexOf('memberclubhidden')){
			js('#jform_memberclub option[value="'+js(this).val()+'"]').attr('selected',true);
		}
	});
	js("#jform_memberclub").trigger("liszt:updated");
	js('input:hidden.postalcode').each(function(){
		var name = js(this).attr('name');
		if(name.indexOf('postalcodehidden')){
			js('#jform_postalcode option[value="'+js(this).val()+'"]').attr('selected',true);
		}
	});
	js("#jform_postalcode").trigger("liszt:updated");
	js('input:hidden.city').each(function(){
		var name = js(this).attr('name');
		if(name.indexOf('cityhidden')){
			js('#jform_city option[value="'+js(this).val()+'"]').attr('selected',true);
		}
	});
	js("#jform_city").trigger("liszt:updated");
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
	js('input:hidden.district').each(function(){
		var name = js(this).attr('name');
		if(name.indexOf('districthidden')){
			js('#jform_district option[value="'+js(this).val()+'"]').attr('selected',true);
		}
	});
	js("#jform_district").trigger("liszt:updated");
	js('input:hidden.role').each(function(){
		var name = js(this).attr('name');
		if(name.indexOf('rolehidden')){
			js('#jform_role option[value="'+js(this).val()+'"]').attr('selected',true);
		}
	});
	js("#jform_role").trigger("liszt:updated");
    });

    Joomla.submitbutton = function(task)
    {
        if (task == 'emailnewsletter.cancel') {
            Joomla.submitform(task, document.getElementById('emailnewsletter-form'));
        }
        else {
            
				js = jQuery.noConflict();
				if(js('#jform_picture').val() != ''){
					js('#jform_picture_hidden').val(js('#jform_picture').val());
				}
            if (task != 'emailnewsletter.cancel' && document.formvalidator.isValid(document.id('emailnewsletter-form'))) {
                
                Joomla.submitform(task, document.getElementById('emailnewsletter-form'));
            }
            else {
                alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
            }
        }
    }
</script>

<form action="<?php echo JRoute::_('index.php?option=com_clubmanager&layout=edit&id=' . (int) $this->item->id); ?>" method="post" enctype="multipart/form-data" name="adminForm" id="emailnewsletter-form" class="form-validate">

    <div class="form-horizontal">
        
        
        <?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general')); ?>

        <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'general', JText::_('COM_CLUBMANAGER_TITLE_EMAILNEWSLETTER', true)); ?>
        <div class="row-fluid">
            <div class="span10 form-horizontal">
                <fieldset class="adminform">

        <?php
            $sql = "SELECT email1 as email 
           FROM #__clubmanager_people
          WHERE newsletter > 0
            AND email1 IS NOT NULL
            AND email1 != ''
            AND state > 0
          UNION 
          SELECT email2
           FROM #__clubmanager_people
          WHERE newsletter > 0
            AND email2 IS NOT NULL
            AND email2 != ''
            AND state > 0
          UNION 
          SELECT email3
           FROM #__clubmanager_people
          WHERE newsletter > 0
            AND email3 IS NOT NULL
            AND email3 != ''
            AND state > 0
          ";
        
        $list = "";  
        $db= JFactory::getDBO();
        $db->setQuery($sql);
        $items = $db->loadObjectList();   
        if ($items) 
        {
          foreach ($items as $item) 
          {
            $adress = $item[1];
            if (strlen($list) > 0)
            {
              $list = $list + ";";
            }
            $list = $list + $adress;
          }
        }
        
        echo $list;
        
      ?>
                    

                </fieldset>
            </div>
        </div>
        <?php echo JHtml::_('bootstrap.endTab'); ?>
        
        

        <?php echo JHtml::_('bootstrap.endTabSet'); ?>

        <input type="hidden" name="task" value="" />
        <?php echo JHtml::_('form.token'); ?>

    </div>
</form>