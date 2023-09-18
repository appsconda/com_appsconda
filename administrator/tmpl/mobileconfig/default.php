<?php
/**
 * @package     com_appsconda
 * @version     1.0.0
 * @copyright   Copyright (C) 2023. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      AppsConda ApS <support@appsconda.com> - https://appsconda.com
 */

// No direct access
defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\CMS\HTML\HTMLHelper;

/** @var \Joomla\Component\Appsconda\Administrator\View\Mobileconfig\HtmlView $this */

/** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
$wa = $this->document->getWebAssetManager();
$wa->getRegistry()->addExtensionRegistryFile('com_contenthistory');
$wa->useScript('keepalive')
   ->useScript('form.validate')
   ->useScript('com_contenthistory.admin-history-versions');
?>
<form action="<?php echo Route::_('index.php?option=com_appsconda&layout=edit&id=' . $this->item->id); ?>" method="post" enctype="multipart/form-data" name="adminForm" id="adminForm" class="form-validate">
	
	<div class="tab-container">
    <div class="tab active" onclick="openTab(event, 'tab1')">Page Title</div>
    <div class="tab" onclick="openTab(event, 'tab2')">My Account</div>
	<div class="tab" onclick="openTab(event, 'tab3')">Back Button</div>
	<div class="tab" onclick="openTab(event, 'tab4')">Events</div>
	<div class="tab" onclick="openTab(event, 'tab5')">Font Size and Button Color</div>
	<div class="tab" onclick="openTab(event, 'tab6')">Show / Hide</div>
	<div class="tab" onclick="openTab(event, 'tab7')">Push</div>
  </div>

  <div id="tab1" class="tab-content">
	  
    <div class="row">
				<div class="col-12 col-lg-4">
                    <fieldset id="fieldset-publishingdata" class="options-form">
                        <legend><?php echo $this->form->getLabel('titlebgcolor'); ?></legend>
				<div class="control-group" style="display:none;">
					<div class="control-label">
						<?php echo $this->form->getLabel('id'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('id'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<?php echo $this->form->getInput('titlebgcolor'); ?>
					</div>
				</div>
				</fieldset>
                </div>
                
                <div class="col-12 col-lg-4">
                    <fieldset id="fieldset-publishingdata" class="options-form">
                        <legend><?php echo $this->form->getLabel('titleonlaunch'); ?></legend>
				<div class="control-group">
					<div class="controls">
						<?php echo $this->form->getInput('titleonlaunch'); ?>
					</div>
				</div>
				</fieldset>
                </div>
                
                <div class="col-12 col-lg-4">
                    <fieldset id="fieldset-publishingdata" class="options-form">
                        <legend><?php echo $this->form->getLabel('titletextcolor'); ?></legend>
				<div class="control-group">
					<div class="controls">
						<?php echo $this->form->getInput('titletextcolor'); ?>
					</div>
				</div>
				</fieldset>
		</div>     
    </div>
	  
	  <div class="row">
				<div class="col-12 col-lg-4">
                    <fieldset id="fieldset-publishingdata" class="options-form">
                        <legend><?php echo $this->form->getLabel('hamburgercolor'); ?></legend>
				<div class="control-group">
					<div class="controls">
						<?php echo $this->form->getInput('hamburgercolor'); ?>
					</div>
				</div>
				</fieldset>
                </div>
                
                
    
    </div>
	  
	  
  </div>

  <div id="tab2" class="tab-content">
	  
    <div class="row">
				<div class="col-12 col-lg-4">
                    <fieldset id="fieldset-publishingdata" class="options-form">
                        <legend>My Profile</legend>
				<div class="control-group">
					<div class="controls">
						<?php echo $this->form->getLabel('myprofileicon'); ?>
						<?php echo $this->form->getInput('myprofileicon'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<?php echo $this->form->getLabel('myprofilelabel'); ?>
						<?php echo $this->form->getInput('myprofilelabel'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<?php echo $this->form->getLabel('myprofilecolor'); ?>
						<?php echo $this->form->getInput('myprofilecolor'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<?php echo $this->form->getLabel('myprofileshow'); ?>
						<?php echo $this->form->getInput('myprofileshow'); ?>
					</div>
				</div>

				</fieldset>
                </div>
                
                <div class="col-12 col-lg-4">
                    <fieldset id="fieldset-publishingdata" class="options-form">
                        <legend>My Events</legend>
				<div class="control-group">
					<div class="controls">
						<?php echo $this->form->getLabel('myeventicon'); ?>
						<?php echo $this->form->getInput('myeventicon'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<?php echo $this->form->getLabel('myeventlabel'); ?>
						<?php echo $this->form->getInput('myeventlabel'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<?php echo $this->form->getLabel('myeventcolor'); ?>
						<?php echo $this->form->getInput('myeventcolor'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<?php echo $this->form->getLabel('myeventshow'); ?>
						<?php echo $this->form->getInput('myeventshow'); ?>
					</div>
				</div>

				</fieldset>
                </div>
                
                <div class="col-12 col-lg-4">
                    <fieldset id="fieldset-publishingdata" class="options-form">
                        <legend>My Orders</legend>
				<div class="control-group">
					<div class="controls">
						<?php echo $this->form->getLabel('myordericon'); ?>
						<?php echo $this->form->getInput('myordericon'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<?php echo $this->form->getLabel('myorderlabel'); ?>
						<?php echo $this->form->getInput('myorderlabel'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<?php echo $this->form->getLabel('myordercolor'); ?>
						<?php echo $this->form->getInput('myordercolor'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<?php echo $this->form->getLabel('myordershow'); ?>
						<?php echo $this->form->getInput('myordershow'); ?>
					</div>
				</div>

				</fieldset>
                </div>
    </div>
	  
	  
	  <div class="row">
				<div class="col-12 col-lg-4">
                    <fieldset id="fieldset-publishingdata" class="options-form">
                        <legend>My Tickets</legend>
				<div class="control-group">
					<div class="controls">
						<?php echo $this->form->getLabel('myticketicon'); ?>
						<?php echo $this->form->getInput('myticketicon'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<?php echo $this->form->getLabel('myticketlabel'); ?>
						<?php echo $this->form->getInput('myticketlabel'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<?php echo $this->form->getLabel('myticketcolor'); ?>
						<?php echo $this->form->getInput('myticketcolor'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<?php echo $this->form->getLabel('myticketshow'); ?>
						<?php echo $this->form->getInput('myticketshow'); ?>
					</div>
				</div>

				</fieldset>
                </div>
                
                <div class="col-12 col-lg-4">
                    <fieldset id="fieldset-publishingdata" class="options-form">
                        <legend>Notification Settings</legend>
				<div class="control-group">
					<div class="controls">
						<?php echo $this->form->getLabel('notifyicon'); ?>
						<?php echo $this->form->getInput('notifyicon'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<?php echo $this->form->getLabel('notifylabel'); ?>
						<?php echo $this->form->getInput('notifylabel'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<?php echo $this->form->getLabel('notifycolor'); ?>
						<?php echo $this->form->getInput('notifycolor'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<?php echo $this->form->getLabel('notifyshow'); ?>
						<?php echo $this->form->getInput('notifyshow'); ?>
					</div>
				</div>

				</fieldset>
                </div>
                
                <div class="col-12 col-lg-4">
                    <fieldset id="fieldset-publishingdata" class="options-form">
                        <legend>Check-in Admin</legend>
				<div class="control-group">
					<div class="controls">
						<?php echo $this->form->getLabel('checkinadminicon'); ?>
						<?php echo $this->form->getInput('checkinadminicon'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<?php echo $this->form->getLabel('checkinadminlabel'); ?>
						<?php echo $this->form->getInput('checkinadminlabel'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<?php echo $this->form->getLabel('checkinadmincolor'); ?>
						<?php echo $this->form->getInput('checkinadmincolor'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<?php echo $this->form->getLabel('checkinadminshow'); ?>
						<?php echo $this->form->getInput('checkinadminshow'); ?>
					</div>
				</div>

				</fieldset>
                </div>
                
                
    </div>
    
    <div class="row">
        <div class="col-12 col-lg-4">
                    <fieldset id="fieldset-publishingdata" class="options-form">
                        <legend>Logout</legend>
				<div class="control-group">
					<div class="controls">
						<?php echo $this->form->getLabel('logouticon'); ?>
						<?php echo $this->form->getInput('logouticon'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<?php echo $this->form->getLabel('logoutlabel'); ?>
						<?php echo $this->form->getInput('logoutlabel'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<?php echo $this->form->getLabel('logoutcolor'); ?>
						<?php echo $this->form->getInput('logoutcolor'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<?php echo $this->form->getLabel('logoutshow'); ?>
						<?php echo $this->form->getInput('logoutshow'); ?>
					</div>
				</div>

				</fieldset>
                </div>
    </div>
	  
  </div>

  
<div id="tab3" class="tab-content">	
	<div class="row">
                
                <div class="col-12 col-lg-4">
                    <fieldset id="fieldset-publishingdata" class="options-form">
                        <legend><?php echo $this->form->getLabel('backbuttonimage'); ?></legend>
				<div class="control-group">
					<div class="controls">
						<?php echo $this->form->getInput('backbuttonimage'); ?>
					</div>
				</div>
				</fieldset>
                </div>
    
    </div>
</div>
	
<div id="tab4" class="tab-content">	
	<div class="row">
                
                <div class="col-12 col-lg-4">
                    <fieldset id="fieldset-publishingdata" class="options-form">
                        <legend><?php echo $this->form->getLabel('selfcheckinradius'); ?></legend>
				<div class="control-group">
					<div class="controls">
						<?php echo $this->form->getInput('selfcheckinradius'); ?>
					</div>
				</div>
				</fieldset>
                </div>
    
    </div>
</div>

<div id="tab5" class="tab-content">	
	<div class="row">
                
                <div class="col-12 col-lg-4">
                    <fieldset id="fieldset-publishingdata" class="options-form">
                        <legend><?php echo $this->form->getLabel('fontsizetitle'); ?></legend>
				<div class="control-group">
					<div class="controls">
						<?php echo $this->form->getInput('fontsizetitle'); ?>
					</div>
				</div>
				</fieldset>
                </div>
                
                <div class="col-12 col-lg-4">
                    <fieldset id="fieldset-publishingdata" class="options-form">
                        <legend><?php echo $this->form->getLabel('fontsizemenu'); ?></legend>
				<div class="control-group">
					<div class="controls">
						<?php echo $this->form->getInput('fontsizemenu'); ?>
					</div>
				</div>
				</fieldset>
                </div>
                
                <div class="col-12 col-lg-4">
                    <fieldset id="fieldset-publishingdata" class="options-form">
                        <legend><?php echo $this->form->getLabel('fontsizebody'); ?></legend>
				<div class="control-group">
					<div class="controls">
						<?php echo $this->form->getInput('fontsizebody'); ?>
					</div>
				</div>
				</fieldset>
                </div>
    
    </div>
    
    <div class="row">
                
                <div class="col-12 col-lg-4">
                    <fieldset id="fieldset-publishingdata" class="options-form">
                        <legend><?php echo $this->form->getLabel('fontsizesmall'); ?></legend>
				<div class="control-group">
					<div class="controls">
						<?php echo $this->form->getInput('fontsizesmall'); ?>
					</div>
				</div>
				</fieldset>
                </div>
                
                <div class="col-12 col-lg-4">
                    <fieldset id="fieldset-publishingdata" class="options-form">
                        <legend><?php echo $this->form->getLabel('buttonbgcolor'); ?></legend>
				<div class="control-group">
					<div class="controls">
						<?php echo $this->form->getInput('buttonbgcolor'); ?>
					</div>
				</div>
				</fieldset>
                </div>
                
                <div class="col-12 col-lg-4">
                    <fieldset id="fieldset-publishingdata" class="options-form">
                        <legend><?php echo $this->form->getLabel('buttontextcolor'); ?></legend>
				<div class="control-group">
					<div class="controls">
						<?php echo $this->form->getInput('buttontextcolor'); ?>
					</div>
				</div>
				</fieldset>
                </div>
    
    </div>
    
    <div class="row">
                
                <div class="col-12 col-lg-4">
                    <fieldset id="fieldset-publishingdata" class="options-form">
                        <legend><?php echo $this->form->getLabel('switchcoloron'); ?></legend>
				<div class="control-group">
					<div class="controls">
						<?php echo $this->form->getInput('switchcoloron'); ?>
					</div>
				</div>
				</fieldset>
                </div>
                
                <div class="col-12 col-lg-4">
                    <fieldset id="fieldset-publishingdata" class="options-form">
                        <legend><?php echo $this->form->getLabel('switchcoloroff'); ?></legend>
				<div class="control-group">
					<div class="controls">
						<?php echo $this->form->getInput('switchcoloroff'); ?>
					</div>
				</div>
				</fieldset>
                </div>

    
    </div>
    
</div>

<div id="tab6" class="tab-content">	
	
	<div class="control-group">
		<div class="control-label">
		<?php echo $this->form->getLabel('forgotpasswordshow'); ?>
		</div>
		<div class="controls">
		<?php echo $this->form->getInput('forgotpasswordshow'); ?>
		</div>
	</div>
	
	<div class="control-group">
		<div class="control-label">
		<?php echo $this->form->getLabel('signupshow'); ?>
		</div>
		<div class="controls">
		<?php echo $this->form->getInput('signupshow'); ?>
		</div>
	</div>
	
	<div class="control-group">
		<div class="control-label">
		<?php echo $this->form->getLabel('selfcheckinshow'); ?>
		</div>
		<div class="controls">
		<?php echo $this->form->getInput('selfcheckinshow'); ?>
		</div>
	</div>
				
</div>

<div id="tab7" class="tab-content">	
	
	<div class="control-group">
		<div class="control-label">
		<?php echo $this->form->getLabel('firebasejson'); ?>
		</div>
		<div class="controls">
		<?php echo $this->form->getInput('firebasejson'); ?>
		</div>
	</div>
				
</div>
	
	
	<div class="row-fluid" style="display:none;">
		<div class="span10 form-horizontal">

				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('created_by'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('created_by'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('state'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('state'); ?>
					</div>
				</div>
            </fieldset>
    	</div>
        <input type="hidden" name="task" value="" />
        <?php echo HTMLHelper::_('form.token'); ?>
    </div>
	<div id="validation-form-failed" data-backend-detail="mobileconfig" data-message="<?php echo $this->escape(Text::_('JGLOBAL_VALIDATION_FORM_FAILED'));?>">
	</div>
</form>





<script>
    function openTab(evt, tabName) {
      // Hide all tab content elements
      const tabContents = document.getElementsByClassName("tab-content");
      for (let i = 0; i < tabContents.length; i++) {
        tabContents[i].style.display = "none";
      }

      // Deactivate all tabs
      const tabs = document.getElementsByClassName("tab");
      for (let i = 0; i < tabs.length; i++) {
        tabs[i].classList.remove("active");
      }

      // Show the selected tab content and activate the corresponding tab
      document.getElementById(tabName).style.display = "block";
      evt.currentTarget.classList.add("active");
    }

    // Show the first tab content by default
    document.getElementById("tab1").style.display = "block";
  </script>


<style>
    /* Basic styling for the tabs */
    .tab-container {
      display: flex;
      justify-content: left;
      border-bottom: 1px solid;
      margin-bottom: 20px;
    }

    .tab {
  padding: 10px 20px;
  background-color: #f1f1f1;
  cursor: pointer;
  font-size: 16px;
  font-weight: bold;
  padding: 12px 30px;
}

    .tab.active {
  background-color: #ddd;
  border-bottom: 2px solid #411bf4;
}

    /* Content styling */
    .tab-content {
      display: none;
    }

    .tab-content.active {
      display: block;
    }
  </style>