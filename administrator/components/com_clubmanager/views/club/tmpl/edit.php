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
  js(document).ready
  (
    function()
    {
      js('input:hidden.union').each
      (
        function()
        {
          var name = js(this).attr('name');
          if(name.indexOf('unionhidden'))
          {
            js('#jform_union option[value="'+js(this).val()+'"]').attr('selected',true);
          }
        }
      );
      js("#jform_union").trigger("liszt:updated");
      js('input:hidden.postalcode').each
      (
        function()
        {
          var name = js(this).attr('name');
          if(name.indexOf('postalcodehidden'))
          {
            js('#jform_postalcode option[value="'+js(this).val()+'"]').attr('selected',true);
          }
        }
      );
      js("#jform_postalcode").trigger("liszt:updated");
      js('input:hidden.city').each
      (
        function()
        {
          var name = js(this).attr('name');
          if(name.indexOf('cityhidden'))
          {
            js('#jform_city option[value="'+js(this).val()+'"]').attr('selected',true);
          }
        }
      );
      js("#jform_city").trigger("liszt:updated");
      js('input:hidden.country').each
      (
        function()
        {
          var name = js(this).attr('name');
          if(name.indexOf('countryhidden'))
          {
            js('#jform_country option[value="'+js(this).val()+'"]').attr('selected',true);
          }
        }
      );
      js("#jform_country").trigger("liszt:updated");
      js('input:hidden.county').each
      (
        function()
        {
          var name = js(this).attr('name');
          if(name.indexOf('countyhidden'))
          {
            js('#jform_county option[value="'+js(this).val()+'"]').attr('selected',true);
          }
        }
      );
      js("#jform_county").trigger("liszt:updated");
      js('input:hidden.district').each
      (
        function()
        {
          var name = js(this).attr('name');
          if(name.indexOf('districthidden'))
          {
            js('#jform_district option[value="'+js(this).val()+'"]').attr('selected',true);
          }
        }
      );
      js("#jform_district").trigger("liszt:updated");
      js('input:hidden.unioncountry').each
      (
        function()
        {
          var name = js(this).attr('name');
          if(name.indexOf('unioncountryhidden'))
          {
            js('#jform_unioncountry option[value="'+js(this).val()+'"]').attr('selected',true);
          }
        }
      );
      js("#jform_unioncountry").trigger("liszt:updated");
      js('input:hidden.unioncounty').each
      (
        function()
        {
          var name = js(this).attr('name');
          if(name.indexOf('unioncountyhidden'))
          {
            js('#jform_unioncounty option[value="'+js(this).val()+'"]').attr('selected',true);
          }
        }
      );

      js("#jform_unioncounty").trigger("liszt:updated");
      js('input:hidden.uniondistrict').each
      (
        function()
        {
          var name = js(this).attr('fullname');
          if(name.indexOf('uniondistricthidden'))
          {
            js('#jform_uniondistrict option[value="'+js(this).val()+'"]').attr('selected',true);
          }
        }
      );
      js("#jform_uniondistrict").trigger("liszt:updated");
    }
  );

  Joomla.submitbutton = function(task)
  {
    if (task == 'club.cancel')
    {
      Joomla.submitform(task, document.getElementById('club-form'));
    }
    else
    {
      if (task != 'club.cancel' && document.formvalidator.isValid(document.id('club-form'))) 
      {
        Joomla.submitform(task, document.getElementById('club-form'));
      }
      else
      {
        alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
      }
    }
  }
</script>

<form action="<?php echo JRoute::_('index.php?option=com_clubmanager&layout=edit&id=' . (int) $this->item->id); ?>" method="post" enctype="multipart/form-data" name="adminForm" id="club-form" class="form-validate">

  <div class="form-horizontal">
        
    <?php echo JHtml::_('bootstrap.startTabSet', 'myTabSet', array('active' => 'myTab1')); ?>

      <?php echo JHtml::_('bootstrap.addTab', 'myTabSet', 'myTab1', JText::_('COM_CLUBMANAGER_TITLE_CLUB', true)); ?>
       
        <div class="row-fluid">
          <div class="span10 form-horizontal">
            <fieldset class="adminform">

              <input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>" />

              <!-- fullname: readonly or disabled -->

              <div class="control-group">
                <div class="control-label" id="lbl_fullname"><?php echo $this->form->getLabel('fullname'); ?></div>
                <div class="controls"      id="inp_fullname"><?php echo $this->form->getInput('fullname'); ?></div>
              </div>
              <div class="control-group">
                <div class="control-label" id="lbl_praefix"><?php echo $this->form->getLabel('praefix'); ?></div>
                <div class="controls"      id="inp_praefix"><?php echo $this->form->getInput('praefix'); ?></div>
              </div>
              <div class="control-group">
                <div class="control-label" id="lbl_union"><?php echo $this->form->getLabel('union'); ?></div>
                <div class="controls"      id="inp_union"><?php echo $this->form->getInput('union'); ?></div>
              </div>

              <?php
                foreach((array)$this->item->union as $value): 
                  if(!is_array($value)):
                    echo '<input type="hidden" class="union" name="jform[unionhidden]['.$value.']" value="'.$value.'" />';
                  endif;
                endforeach;
              ?>
              <div class="control-group">
                <div class="control-label" id="lbl_name"><?php echo $this->form->getLabel('name'); ?></div>
                <div class="controls"      id="inp_name"><?php echo $this->form->getInput('name'); ?></div>
              </div>
              <div class="control-group">
                <div class="control-label" id="lbl_street"><?php echo $this->form->getLabel('street'); ?></div>
                <div class="controls"      id="inp_street"><?php echo $this->form->getInput('street'); ?></div>
              </div>
              <div class="control-group">
                <div class="control-label" id="lbl_postalcode"><?php echo $this->form->getLabel('postalcode'); ?></div>
                <div class="controls"      id="inp_postalcode"><?php echo $this->form->getInput('postalcode'); ?></div>
              </div>

              <?php
                foreach((array)$this->item->postalcode as $value): 
                  if(!is_array($value)):
                    echo '<input type="hidden" class="postalcode" name="jform[postalcodehidden]['.$value.']" value="'.$value.'" />';
                  endif;
                endforeach;
              ?>

              <div class="control-group">
                <div class="control-label" id="lbl_city"><?php echo $this->form->getLabel('city'); ?></div>
                <div class="controls"      id="inp_city"><?php echo $this->form->getInput('city'); ?></div>
              </div>

              <?php
                foreach((array)$this->item->city as $value): 
                  if(!is_array($value)):
                    echo '<input type="hidden" class="city" name="jform[cityhidden]['.$value.']" value="'.$value.'" />';
                  endif;
                endforeach;
              ?>

              <div class="control-group">
                <div class="control-label" id="lbl_country"><?php echo $this->form->getLabel('country'); ?></div>
                <div class="controls"      id="inp_country"><?php echo $this->form->getInput('country'); ?></div>
              </div>

              <?php
                foreach((array)$this->item->country as $value): 
                  if(!is_array($value)):
                    echo '<input type="hidden" class="country" name="jform[countryhidden]['.$value.']" value="'.$value.'" />';
                  endif;
                endforeach;
              ?>

              <div class="control-group">
                <div class="control-label" id="lbl_county"><?php echo $this->form->getLabel('county'); ?></div>
                <div class="controls"      id="inp_county"><?php echo $this->form->getInput('county'); ?></div>
              </div>

              <?php
                foreach((array)$this->item->county as $value): 
                  if(!is_array($value)):
                    echo '<input type="hidden" class="county" name="jform[countyhidden]['.$value.']" value="'.$value.'" />';
                  endif;   
                endforeach;
              ?>

              <div class="control-group">
                <div class="control-label" id="lbl_district"><?php echo $this->form->getLabel('district'); ?></div>
                <div class="controls"      id="inp_district"><?php echo $this->form->getInput('district'); ?></div>
              </div>

              <?php
                foreach((array)$this->item->district as $value): 
                  if(!is_array($value)):
                    echo '<input type="hidden" class="district" name="jform[districthidden]['.$value.']" value="'.$value.'" />';
                  endif;
                endforeach;
              ?>

              <div class="control-group">
                <div class="control-label" id="lbl_email1"><?php echo $this->form->getLabel('email1'); ?></div>
                <div class="controls"      id="inp_email1"><?php echo $this->form->getInput('email1'); ?></div>
              </div>
              <div class="control-group">
                <div class="control-label" id="lbl_email2"><?php echo $this->form->getLabel('email2'); ?></div>
                <div class="controls"      id="inp_email2"><?php echo $this->form->getInput('email2'); ?></div>
              </div>
              <div class="control-group">
                <div class="control-label" id="lbl_email3"><?php echo $this->form->getLabel('email3'); ?></div>
                <div class="controls"      id="inp_email3"><?php echo $this->form->getInput('email3'); ?></div>
              </div>
              <div class="control-group">
                <div class="control-label" id="lbl_phone1"><?php echo $this->form->getLabel('phone1'); ?></div>
                <div class="controls"      id="inp_phone1"><?php echo $this->form->getInput('phone1'); ?></div>
              </div>
              <div class="control-group">
                <div class="control-label" id="lbl_phone2"><?php echo $this->form->getLabel('phone2'); ?></div>
                <div class="controls"      id="inp_phone2"><?php echo $this->form->getInput('phone2'); ?></div>
              </div>
              <div class="control-group">
                <div class="control-label" id="lbl_phone3"><?php echo $this->form->getLabel('phone3'); ?></div>
                <div class="controls"      id="inp_phone3"><?php echo $this->form->getInput('phone3'); ?></div>
              </div>
              <div class="control-group">
                <div class="control-label" id="lbl_website"><?php echo $this->form->getLabel('website'); ?></div>
                <div class="controls"      id="inp_website"><?php echo $this->form->getInput('website'); ?></div>
              </div>
              <div class="control-group">
                <div class="control-label" id="lbl_comment"><?php echo $this->form->getLabel('comment'); ?></div>
                <div class="controls"      id="inp_comment"><?php echo $this->form->getInput('comment'); ?></div>
              </div>


          </fieldset>
        </div>
      </div>

    <?php echo JHtml::_('bootstrap.endTab'); ?>

    <?php echo JHtml::_('bootstrap.addTab', 'myTabSet', 'myTab2', JText::_('Vereinsdaten', true)); ?>

        <div class="row-fluid">
          <div class="span10 form-horizontal">
            <fieldset class="adminform">

              <div class="control-group">
                <div class="control-label" id="lbl_fullname"><?php echo $this->form->getLabel('fullname'); ?></div>
                <div class="controls"      id="inp_fullname"><?php echo $this->form->getInput('fullname'); ?></div>
              </div>

              <div class="control-group">
                <div class="control-label" id="lbl_ownclub"><?php echo $this->form->getLabel('ownclub'); ?></div>
                <div class="controls"      id="inp_ownclub"><?php echo $this->form->getInput('ownclub'); ?></div>
              </div>
              <div class="control-group">
                <div class="control-label" id="lbl_zvrno"><?php echo $this->form->getLabel('zvrno'); ?></div>
                <div class="controls"      id="inp_zvrno"><?php echo $this->form->getInput('zvrno'); ?></div>
              </div>
              <div class="control-group">
                <div class="control-label" id="lbl_location"><?php echo $this->form->getLabel('location'); ?></div>
                <div class="controls"      id="inp_location"><?php echo $this->form->getInput('location'); ?></div>
              </div>
              <div class="control-group">
                <div class="control-label" id="lbl_distance"><?php echo $this->form->getLabel('distance'); ?></div>
                <div class="controls"      id="inp_distance"><?php echo $this->form->getInput('distance'); ?>&nbsp;&nbsp;km</div>
              </div>
              <div class="control-group">
                <div class="control-label" id="lbl_unioncountry"><?php echo $this->form->getLabel('unioncountry'); ?></div>
                <div class="controls"      id="inp_unioncountry"><?php echo $this->form->getInput('unioncountry'); ?></div>
              </div>

              <?php
                foreach((array)$this->item->unioncountry as $value): 
                  if(!is_array($value)):
                    echo '<input type="hidden" class="unioncountry" name="jform[unioncountryhidden]['.$value.']" value="'.$value.'" />';
                  endif;
                endforeach;
              ?>

              <div class="control-group">
                <div class="control-label" id="lbl_unioncounty"><?php echo $this->form->getLabel('unioncounty'); ?></div>
                <div class="controls"      id="inp_unioncounty"><?php echo $this->form->getInput('unioncounty'); ?></div>
              </div>

              <?php
                foreach((array)$this->item->unioncounty as $value): 
                  if(!is_array($value)):
                    echo '<input type="hidden" class="unioncounty" name="jform[unioncountyhidden]['.$value.']" value="'.$value.'" />';
                  endif;
                endforeach;
              ?>
              
              <div class="control-group">
                <div class="control-label" id="lbl_uniondistrict"><?php echo $this->form->getLabel('uniondistrict'); ?></div>
                <div class="controls"      id="inp_uniondistrict"><?php echo $this->form->getInput('uniondistrict'); ?></div>
              </div>

              <?php
                foreach((array)$this->item->uniondistrict as $value): 
                  if(!is_array($value)):
                    echo '<input type="hidden" class="uniondistrict" name="jform[uniondistricthidden]['.$value.']" value="'.$value.'" />';
                  endif;
                endforeach;
              ?>

              <div class="control-group">
                <div class="control-label" id="lbl_uniondistrictno"><?php echo $this->form->getLabel('uniondistrictno'); ?></div>
                <div class="controls"      id="inp_uniondistrictno"><?php echo $this->form->getInput('uniondistrictno'); ?></div>
              </div>
              <div class="control-group">
                <div class="control-label" id="lbl_default"><?php echo $this->form->getLabel('default'); ?></div>
                <div class="controls"      id="inp_default"><?php echo $this->form->getInput('default'); ?></div>
              </div>
              <div class="control-group">
                <div class="control-label" id="lbl_state"><?php echo $this->form->getLabel('state'); ?></div>
                <div class="controls"      id="inp_state"><?php echo $this->form->getInput('state'); ?></div>
              </div>

              <input type="hidden" name="jform[checked_out]"      value="<?php echo $this->item->checked_out;      ?>" />
              <input type="hidden" name="jform[checked_out_time]" value="<?php echo $this->item->checked_out_time; ?>" />

              <?php 
                if(empty($this->item->created_by))
                { 
              ?>
                  <input type="hidden" name="jform[created_by]" value="<?php echo JFactory::getUser()->id; ?>" />
              <?php
                }
                else
                {
              ?>
                  <input type="hidden" name="jform[created_by]" value="<?php echo $this->item->created_by; ?>" />
              <?php
                }
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