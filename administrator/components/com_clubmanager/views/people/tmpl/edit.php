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
      js('input:hidden.salutation').each
      (
        function()
        {
          var name = js(this).attr('name');
          if(name.indexOf('salutationhidden'))
          {
            js('#jform_salutation option[value="'+js(this).val()+'"]').attr('selected',true);
          }
        }
      );
      js("#jform_salutation").trigger("liszt:updated");
      js('input:hidden.gender').each
      (
        function()
        {
          var name = js(this).attr('name');
          if(name.indexOf('genderhidden'))
          {
            js('#jform_gender option[value="'+js(this).val()+'"]').attr('selected',true);
          }
        }
      );
      js("#jform_gender").trigger("liszt:updated");
      js('input:hidden.memberclub').each
      (
        function()
        {
          var name = js(this).attr('name');
          if(name.indexOf('memberclubhidden'))
          {
            js('#jform_memberclub option[value="'+js(this).val()+'"]').attr('selected',true);
          }
        }
      );
      js("#jform_memberclub").trigger("liszt:updated");
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
      js('input:hidden.role').each
      (
        function()
        {
          var name = js(this).attr('name');
          if(name.indexOf('rolehidden'))
          {
            js('#jform_role option[value="'+js(this).val()+'"]').attr('selected',true);
          }
        }
      );
      js("#jform_role").trigger("liszt:updated");
    }
  );

  Joomla.submitbutton = function(task)
  {
    if (task == 'people.cancel')
    {
      Joomla.submitform(task, document.getElementById('people-form'));
    }
    else 
    {
      js = jQuery.noConflict();
      if(js('#jform_picture').val() != '')
      {
        js('#jform_picture_hidden').val(js('#jform_picture').val());
      }
      if (task != 'people.cancel' && document.formvalidator.isValid(document.id('people-form'))) 
      {
        Joomla.submitform(task, document.getElementById('people-form'));
      }
      else 
      {
        alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
      }
    }
  }
</script>

<form action="<?php echo JRoute::_('index.php?option=com_clubmanager&layout=edit&id=' . (int) $this->item->id); ?>" method="post" enctype="multipart/form-data" name="adminForm" id="people-form" class="form-validate">

  <div class="form-horizontal">
    <?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'tab1')); ?>

    <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'tab1', JText::_('COM_CLUBMANAGER_TITLE_PEOPLE', true)); ?>
      <div class="row-fluid">
        <div class="span10 form-horizontal">

        <input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>" />

        <div class="control-group">
          <div class="control-label"><?php echo $this->form->getLabel('fullname'); ?></div>
          <div class="controls"     ><?php echo $this->form->getInput('fullname'); ?></div>
        </div>

        <div class="control-group">
          <div class="control-label"><?php echo $this->form->getLabel('firstname'); ?></div>
          <div class="controls"     ><?php echo $this->form->getInput('firstname'); ?></div>
        </div>

        <div class="control-group">
          <div class="control-label"><?php echo $this->form->getLabel('lastname'); ?></div>
          <div class="controls"     ><?php echo $this->form->getInput('lastname'); ?></div>
        </div>

        <div class="control-group">
          <div class="control-label"><?php echo $this->form->getLabel('salutation'); ?></div>
          <div class="controls"     ><?php echo $this->form->getInput('salutation'); ?></div>
        </div>
        <?php
          foreach((array)$this->item->salutation as $value): 
            if(!is_array($value)):
              echo '<input type="hidden" class="salutation" name="jform[salutationhidden]['.$value.']" value="'.$value.'" />';
            endif;
          endforeach;
        ?>

        <div class="control-group">
          <div class="control-label"><?php echo $this->form->getLabel('gender'); ?></div>
          <div class="controls"     ><?php echo $this->form->getInput('gender'); ?></div>
        </div>
        <?php
          foreach((array)$this->item->gender as $value): 
            if(!is_array($value)):
              echo '<input type="hidden" class="gender" name="jform[genderhidden]['.$value.']" value="'.$value.'" />';
            endif;
          endforeach;
        ?>

        <div class="control-group">
          <div class="control-label"><?php echo $this->form->getLabel('nickname'); ?></div>
          <div class="controls"     ><?php echo $this->form->getInput('nickname'); ?></div>
        </div>

        <div class="control-group">
          <div class="control-label"><?php echo $this->form->getLabel('birthdate'); ?></div>
          <div class="controls"     >
            <?php 
              echo $this->form->getInput('birthdate'); 
            ?>
          </div>
        </div>

        <div class="control-group">
          <div class="control-label"><?php echo $this->form->getLabel('phone1'); ?></div>
          <div class="controls"     ><?php echo $this->form->getInput('phone1'); ?></div>
        </div>

        <div class="control-group">
          <div class="control-label"><?php echo $this->form->getLabel('phone2'); ?></div>
          <div class="controls"     ><?php echo $this->form->getInput('phone2'); ?></div>
        </div>

        <div class="control-group">
          <div class="control-label"><?php echo $this->form->getLabel('phone3'); ?></div>
          <div class="controls"     ><?php echo $this->form->getInput('phone3'); ?></div>
        </div>

        <div class="control-group">
          <div class="control-label"><?php echo $this->form->getLabel('email1'); ?></div>
          <div class="controls"     ><?php echo $this->form->getInput('email1'); ?></div>
        </div>

        <div class="control-group">
          <div class="control-label"><?php echo $this->form->getLabel('email2'); ?></div>
          <div class="controls"     ><?php echo $this->form->getInput('email2'); ?></div>
        </div>

        <div class="control-group">
          <div class="control-label"><?php echo $this->form->getLabel('email3'); ?></div>
          <div class="controls"     ><?php echo $this->form->getInput('email3'); ?></div>
        </div>

        <div class="control-group">
          <div class="control-label"><?php echo $this->form->getLabel('website'); ?></div>
          <div class="controls"     ><?php echo $this->form->getInput('website'); ?></div>
        </div>

        <div class="control-group">
          <div class="control-label"><?php echo $this->form->getLabel('died'); ?></div>
          <div class="controls"     >
            <?php 
              echo $this->form->getInput('died');
            ?>
          </div>
        </div>

        <?php
          if (strlen($this->item->picture) > 0)
          {
            $imgPath = '/administrator/components/com_clubmanager/images/people/'.$this->item->picture;
        ?>
            <img src="<?php echo $imgPath; ?>" 
                 alt="<?php echo $imgPath; ?>" height="450" width="150" style="position:absolute; left:530px; top:180px;"/>
        <?php
          }
          else
          {
            $imgPath = "";            
          }
        ?>
        
        
        <div class="control-group">
          <div class="control-label"><?php echo $this->form->getLabel('picture'); ?></div>
          <div class="controls"     ><?php echo $this->form->getInput('picture'); ?></div>
        </div>
            
        <input type="hidden" name="jform[picture]" id="jform_picture_hidden" value="<?php echo $this->item->picture ?>" style="position:absolute; left:530px; top:650px;"/>

<!-- Tab wechsel Start ----------------------------------------------------------------------------->
      </div>
    </div>

    <?php echo JHtml::_('bootstrap.endTab'); ?>

    <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'tab2', JText::_('Adressdaten', true)); ?>
      <div class="row-fluid">
        <div class="span10 form-horizontal">

<!-- Tab wechsel Ende ------------------------------------------------------------------------------>

        <div class="control-group">
          <div class="control-label"><?php echo $this->form->getLabel('street'); ?></div>
          <div class="controls"     ><?php echo $this->form->getInput('street'); ?></div>
        </div>

        <div class="control-group">
          <div class="control-label"><?php echo $this->form->getLabel('postalcode'); ?></div>
          <div class="controls"     ><?php echo $this->form->getInput('postalcode'); ?></div>
        </div>
        <?php
          foreach((array)$this->item->postalcode as $value): 
            if(!is_array($value)):
              echo '<input type="hidden" class="postalcode" name="jform[postalcodehidden]['.$value.']" value="'.$value.'" />';
            endif;
          endforeach;
        ?>

        <div class="control-group">
          <div class="control-label"><?php echo $this->form->getLabel('city'); ?></div>
          <div class="controls"     ><?php echo $this->form->getInput('city'); ?></div>
        </div>
        <?php
          foreach((array)$this->item->city as $value): 
            if(!is_array($value)):
              echo '<input type="hidden" class="city" name="jform[cityhidden]['.$value.']" value="'.$value.'" />';
            endif;
          endforeach;
        ?>

        <div class="control-group">
          <div class="control-label"><?php echo $this->form->getLabel('district'); ?></div>
          <div class="controls"     ><?php echo $this->form->getInput('district'); ?></div>
        </div>
        <?php
          foreach((array)$this->item->district as $value): 
            if(!is_array($value)):
              echo '<input type="hidden" class="district" name="jform[districthidden]['.$value.']" value="'.$value.'" />';
            endif;
          endforeach;
        ?>

        <div class="control-group">
          <div class="control-label"><?php echo $this->form->getLabel('county'); ?></div>
          <div class="controls"     ><?php echo $this->form->getInput('county'); ?></div>
        </div>
        <?php
          foreach((array)$this->item->county as $value): 
            if(!is_array($value)):
              echo '<input type="hidden" class="county" name="jform[countyhidden]['.$value.']" value="'.$value.'" />';
            endif;
          endforeach;
        ?>

        <div class="control-group">
          <div class="control-label"><?php echo $this->form->getLabel('country'); ?></div>
          <div class="controls"     ><?php echo $this->form->getInput('country'); ?></div>
        </div>
        <?php
          foreach((array)$this->item->country as $value): 
            if(!is_array($value)):
              echo '<input type="hidden" class="country" name="jform[countryhidden]['.$value.']" value="'.$value.'" />';
            endif;
          endforeach;
        ?>

<!-- Tab wechsel Start ----------------------------------------------------------------------------->
      </div>
    </div>

    <?php echo JHtml::_('bootstrap.endTab'); ?>

    <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'tab3', JText::_('Vereinsdaten', true)); ?>
      <div class="row-fluid">
        <div class="span10 form-horizontal">

<!-- Tab wechsel Ende ------------------------------------------------------------------------------>

        <div class="control-group">
          <div class="control-label"><?php echo $this->form->getLabel('memberclub'); ?></div>
          <div class="controls"     ><?php echo $this->form->getInput('memberclub'); ?></div>
        </div>
        <?php
          foreach((array)$this->item->memberclub as $value): 
            if(!is_array($value)):
              echo '<input type="hidden" class="memberclub" name="jform[memberclubhidden]['.$value.']" value="'.$value.'" />';
            endif;
          endforeach;
        ?>

        <div class="control-group">
          <div class="control-label"><?php echo $this->form->getLabel('role'); ?></div>
          <div class="controls"     ><?php echo $this->form->getInput('role'); ?></div>
        </div>
        <?php
          foreach((array)$this->item->role as $value): 
            if(!is_array($value)):
              echo '<input type="hidden" class="role" name="jform[rolehidden]['.$value.']" value="'.$value.'" />';
            endif;
          endforeach;
        ?>

        <div class="control-group">
          <div class="control-label"><?php echo $this->form->getLabel('function'); ?></div>
          <div class="controls"     ><?php echo $this->form->getInput('function'); ?></div>
        </div>

        <div class="control-group">
          <div class="control-label"><?php echo $this->form->getLabel('memberno'); ?></div>
          <div class="controls"     ><?php echo $this->form->getInput('memberno'); ?></div>
        </div>

        <div class="control-group">
          <div class="control-label"><?php echo $this->form->getLabel('newsletter'); ?></div>
          <div class="controls"     ><?php echo $this->form->getInput('newsletter'); ?></div>
        </div>

        <div class="control-group">
          <div class="control-label"><?php echo $this->form->getLabel('iban'); ?></div>
          <div class="controls"     ><?php echo $this->form->getInput('iban'); ?></div>
        </div>

        <div class="control-group">
          <div class="control-label"><?php echo $this->form->getLabel('bic'); ?></div>
          <div class="controls"     ><?php echo $this->form->getInput('bic'); ?></div>
        </div>

        <div class="control-group">
          <div class="control-label"><?php echo $this->form->getLabel('comment'); ?></div>
          <div class="controls"     ><?php echo $this->form->getInput('comment'); ?></div>
        </div>

        <div class="control-group">
          <div class="control-label"><?php echo $this->form->getLabel('state'); ?></div>
          <div class="controls"     ><?php echo $this->form->getInput('state'); ?></div>
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