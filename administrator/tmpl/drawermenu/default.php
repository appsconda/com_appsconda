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

/** @var \Joomla\Component\Appsconda\Administrator\View\Drawermenu\HtmlView $this */

/** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
$wa = $this->document->getWebAssetManager();
$wa->getRegistry()->addExtensionRegistryFile('com_contenthistory');
$wa->useScript('keepalive')
   ->useScript('form.validate')
   ->useScript('com_contenthistory.admin-history-versions');
?>
<form action="<?php echo Route::_('index.php?option=com_appsconda&layout=edit&id=' . $this->item->id); ?>" method="post" enctype="multipart/form-data" name="adminForm" id="adminForm" class="form-validate">
	<div class="row-fluid">
		<div class="span10 form-horizontal">
            
				
				<div class="control-group" style="display:none;">
					<div class="control-label">
						<?php echo $this->form->getLabel('id'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('id'); ?>
					</div>
				</div>
				
				
				<div class="row">
				<div class="col-12 col-lg-4">
                    <fieldset id="fieldset-publishingdata" class="options-form">
                        <legend>Custom Page 01</legend>
                        
                        <div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menu1show'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu1show'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menu1label'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu1label'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menu1color'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu1color'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menu1icon'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu1icon'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menu1access'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu1access'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menu1contentid'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu1contentid'); ?>
					</div>
				</div>
                        
                    </fieldset>
                </div>
                
                
                
                <div class="col-12 col-lg-4">
                    <fieldset id="fieldset-publishingdata" class="options-form">
                        <legend>Custom Page 02</legend>
                        
                        <div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menu2show'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu2show'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menu2label'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu2label'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menu2color'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu2color'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menu2icon'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu2icon'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menu2access'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu2access'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menu2contentid'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu2contentid'); ?>
					</div>
				</div>
                        
                        </fieldset>
                </div>
                
                <div class="col-12 col-lg-4">
                    <fieldset id="fieldset-publishingdata" class="options-form">
                        <legend>Articles Category 01</legend>
                        
                        <div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menu3show'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu3show'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menu3label'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu3label'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menu3color'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu3color'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menu3icon'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu3icon'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menu3access'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu3access'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menu3contentid'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu3contentid'); ?>
					</div>
				</div>
                        
                        </fieldset>
                </div>
                
                </div>
                
                
                
                <div class="row">
				<div class="col-12 col-lg-4">
                    <fieldset id="fieldset-publishingdata" class="options-form">
                         <legend>Articles Category 02</legend>
                        
                        <div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menu4show'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu4show'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menu4label'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu4label'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menu4color'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu4color'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menu4icon'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu4icon'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menu4access'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu4access'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menu4contentid'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu4contentid'); ?>
					</div>
				</div>
				</fieldset>
                        
                </div>
                
                
                <div class="col-12 col-lg-4">
                    <fieldset id="fieldset-publishingdata" class="options-form">
                         <legend>Article Categories</legend>
                         
                         <div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menu5show'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu5show'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menu5label'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu5label'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menu5color'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu5color'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menu5icon'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu5icon'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menu5access'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu5access'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menu5contentid'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu5contentid'); ?>
					</div>
				</div>
				
				</fieldset>
				</div>
				
				
				<div class="col-12 col-lg-4">
                    <fieldset id="fieldset-publishingdata" class="options-form">
                         <legend>Contacts Category</legend>
                         <div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menu6show'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu6show'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menu6label'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu6label'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menu6color'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu6color'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menu6icon'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu6icon'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menu6access'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu6access'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menu6contentid'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu6contentid'); ?>
					</div>
				</div>
				</fieldset>
				</div>
				
				
				
                         
                </div>
				
				
				
				
				
				
				<div class="row">
				<div class="col-12 col-lg-4">
                    <fieldset id="fieldset-publishingdata" class="options-form">
                         <legend>Event Booking</legend>
                         
                         <div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menu7show'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu7show'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menu7label'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu7label'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menu7color'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu7color'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menu7icon'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu7icon'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menu7access'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu7access'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menu7contentid'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu7contentid'); ?>
					</div>
				</div>
                         
                     	</fieldset>
				</div>
				
				<div class="col-12 col-lg-4">
                    <fieldset id="fieldset-publishingdata" class="options-form">
                         <legend>Custom Pages</legend>
                         
                         <div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menucustompagesshow'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menucustompagesshow'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menucustompageslabel'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menucustompageslabel'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menucustompagescolor'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menucustompagescolor'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menucustompagesicon'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menucustompagesicon'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menucustompagesaccess'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menucustompagesaccess'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menucustompagescontentid'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menucustompagescontentid'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('extrashow'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('extrashow'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('extralabel'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('extralabel'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('extraurl'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('extraurl'); ?>
					</div>
				</div>
                         
                     	</fieldset>
				</div>
				
				
				<div class="col-12 col-lg-4">
                    <fieldset id="fieldset-publishingdata" class="options-form">
                         <legend>Eshop</legend>
                    <div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menu8show'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu8show'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menu8label'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu8label'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menu8color'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu8color'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menu8icon'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu8icon'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menu8access'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu8access'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menu8contentid'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu8contentid'); ?>
					</div>
				</div>
                    </fieldset>
				</div>
				
				
				
				
				
				
				</div>    
                         
                         
				
				
				<div class="row">
				<div class="col-12 col-lg-4">
                    <fieldset id="fieldset-publishingdata" class="options-form">
                         <legend>Kunena Forum</legend>
                    <div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menu9show'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu9show'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menu9label'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu9label'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menu9color'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu9color'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menu9icon'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu9icon'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menu9access'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu9access'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menu9contentid'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu9contentid'); ?>
					</div>
				</div>
                    </fieldset>
				</div>
				
				<div class="col-12 col-lg-4">
                    <fieldset id="fieldset-publishingdata" class="options-form">
                         <legend>YouTube Channel</legend>
                         
                         <div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menu10show'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu10show'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menu10label'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu10label'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menu10color'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu10color'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menu10icon'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu10icon'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menu10access'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu10access'); ?>
					</div>
				</div>
				<div class="control-group">
				    <div class="col-12 col-lg-6">
					<div class="control-label">
						<?php echo $this->form->getLabel('youtubeapikey'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('youtubeapikey'); ?>
					</div>
					</div>
					<div class="col-12 col-lg-6">
					<div class="control-label">
						<?php echo $this->form->getLabel('youtubechannelid'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('youtubechannelid'); ?>
					</div>
				</div>
				
				</div>
                         
                         </fieldset>
				</div>
				
				
				
			<div class="col-12 col-lg-4">
                    <fieldset id="fieldset-publishingdata" class="options-form">
                         <legend>SP Easy Image Gallery</legend>
                         
                         <div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menu11show'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu11show'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menu11label'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu11label'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menu11color'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu11color'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menu11icon'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu11icon'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menu11access'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu11access'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menu11contentid'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu11contentid'); ?>
					</div>
				</div>
                         
                         </fieldset>
				</div>
				
				
				
				
				
				
				</div>   
			
			
			
			<div class="row">
				<div class="col-12 col-lg-4">
				<fieldset id="fieldset-publishingdata" class="options-form">
                         <legend>Helpdesk Pro</legend>
                         
                         <div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menusupportshow'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menusupportshow'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menusupportlabel'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menusupportlabel'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menusupportcolor'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menusupportcolor'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menusupporticon'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menusupporticon'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menusupportaccess'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menusupportaccess'); ?>
					</div>
				</div>
				<div class="control-group">
				    <div class="col-12 col-lg-3">
					<div class="control-label">
						<?php echo $this->form->getLabel('supportcatid'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('supportcatid'); ?>
					</div>
					</div>
					<div class="col-12 col-lg-3">
					<div class="control-label">
						<?php echo $this->form->getLabel('supportpriorityid'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('supportpriorityid'); ?>
					</div>
					</div>
					<div class="col-12 col-lg-3">
					<div class="control-label">
						<?php echo $this->form->getLabel('supportstatusid'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('supportstatusid'); ?>
					</div>
					</div>
				</div>
                         
                         </fieldset>
				
</div>

                <div class="col-12 col-lg-4">
				<fieldset id="fieldset-publishingdata" class="options-form">
                         <legend>Login</legend>
                         
                         <div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('loginshow'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('loginshow'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('loginlabel'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('loginlabel'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('logincolor'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('logincolor'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('loginicon'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('loginicon'); ?>
					</div>
				</div>

				
                         
                         </fieldset>
				
</div>

                <div class="col-12 col-lg-4">
				<fieldset id="fieldset-publishingdata" class="options-form">
                         <legend>My Account</legend>
                         
                         <div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('myaccountshow'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('myaccountshow'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('myaccountlabel'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('myaccountlabel'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('myaccountcolor'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('myaccountcolor'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('myaccounticon'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('myaccounticon'); ?>
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
					<div class="control-label">
						<?php echo $this->form->getLabel('logoutshow'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('logoutshow'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('logoutlabel'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('logoutlabel'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('logoutcolor'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('logoutcolor'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('logouticon'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('logouticon'); ?>
					</div>
				</div>

				
                         
                         </fieldset>
				
</div>

                

                <div class="col-12 col-lg-4">
				<fieldset id="fieldset-publishingdata" class="options-form">
                         <legend>Image Above Menu (916px by 320px</legend>
                         
                         <div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('imageabovemenu'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('imageabovemenu'); ?>
					</div>
				</div>
                         
                         </fieldset>
				
</div> 
				
				</div>
                         
                         
					
            	
				
				
				
				
				
				
				
				
				
				<div class="control-group" style="display:none;">
					<div class="control-label">
						<?php echo $this->form->getLabel('created_by'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('created_by'); ?>
					</div>
				</div>
				<div class="control-group" style="display:none;">
					<div class="control-label">
						<?php echo $this->form->getLabel('state'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('state'); ?>
					</div>
				</div>
						<?php echo $this->form->getInput('ordering'); ?>
            
    	</div>
        <input type="hidden" name="task" value="" />
        <?php echo HTMLHelper::_('form.token'); ?>
    </div>
	<div id="validation-form-failed" data-backend-detail="drawermenu" data-message="<?php echo $this->escape(Text::_('JGLOBAL_VALIDATION_FORM_FAILED'));?>">
	</div>
</form>

<style>

.span10.form-horizontal div.row {
  border-bottom: 3px solid #d300ff;
  margin-bottom: 30px;
}

</style>
