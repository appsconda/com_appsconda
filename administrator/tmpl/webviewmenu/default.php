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

/** @var \Joomla\Component\Appsconda\Administrator\View\Webviewmenu\HtmlView $this */

/** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
$wa = $this->document->getWebAssetManager();
$wa->getRegistry()->addExtensionRegistryFile('com_contenthistory');
$wa->useScript('keepalive')
   ->useScript('form.validate')
   ->useScript('com_contenthistory.admin-history-versions');
?>
<form action="<?php echo JRoute::_('index.php?option=com_appsconda&layout=edit&id=' . $this->item->id); ?>" method="post" enctype="multipart/form-data" name="adminForm" id="adminForm" class="form-validate">
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
                        <legend>Webview Menu 01</legend>
                        
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
						<?php echo $this->form->getLabel('menu1content'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu1content'); ?>
					</div>
				</div>
                        
                    </fieldset>
                </div>
                
                
                
                <div class="col-12 col-lg-4">
                    <fieldset id="fieldset-publishingdata" class="options-form">
                        <legend>Webview Menu 02</legend>
                        
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
						<?php echo $this->form->getLabel('menu2content'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu2content'); ?>
					</div>
				</div>
                        
                    </fieldset>
                </div>
                
                <div class="col-12 col-lg-4">
                    <fieldset id="fieldset-publishingdata" class="options-form">
                        <legend>Webview Menu 03</legend>
                        
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
						<?php echo $this->form->getLabel('menu3content'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu3content'); ?>
					</div>
				</div>
                        
                    </fieldset>
                </div>
                
                </div>
                
                
                
                <div class="row">
				
				<div class="col-12 col-lg-4">
                    <fieldset id="fieldset-publishingdata" class="options-form">
                        <legend>Webview Menu 04</legend>
                        
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
						<?php echo $this->form->getLabel('menu4content'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu4content'); ?>
					</div>
				</div>
                        
                    </fieldset>
                </div>
                
                
                <div class="col-12 col-lg-4">
                    <fieldset id="fieldset-publishingdata" class="options-form">
                        <legend>Webview Menu 05</legend>
                        
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
						<?php echo $this->form->getLabel('menu5content'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu5content'); ?>
					</div>
				</div>
                        
                    </fieldset>
                </div>
				
				
				<div class="col-12 col-lg-4">
                    <fieldset id="fieldset-publishingdata" class="options-form">
                        <legend>Webview Menu 06</legend>
                        
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
						<?php echo $this->form->getLabel('menu6content'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu6content'); ?>
					</div>
				</div>
                        
                    </fieldset>
                </div>
				
				
				
                         
                </div>
				
				
				
				
				
				
				<div class="row">
				
				<div class="col-12 col-lg-4">
                    <fieldset id="fieldset-publishingdata" class="options-form">
                        <legend>Webview Menu 07</legend>
                        
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
						<?php echo $this->form->getLabel('menu7content'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu7content'); ?>
					</div>
				</div>
                        
                    </fieldset>
                </div>
				
				<div class="col-12 col-lg-4">
                    <fieldset id="fieldset-publishingdata" class="options-form">
                        <legend>Webview Menu 08</legend>
                        
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
						<?php echo $this->form->getLabel('menu8content'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu8content'); ?>
					</div>
				</div>
                        
                    </fieldset>
                </div>
				
				
				<div class="col-12 col-lg-4">
                    <fieldset id="fieldset-publishingdata" class="options-form">
                        <legend>Webview Menu 09</legend>
                        
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
						<?php echo $this->form->getLabel('menu9content'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu9content'); ?>
					</div>
				</div>
                        
                    </fieldset>
                </div>
				
				
				
				
				
				
				</div>    
                         
                         
				
				
				<div class="row">
				
				<div class="col-12 col-lg-4">
                    <fieldset id="fieldset-publishingdata" class="options-form">
                        <legend>Webview Menu 10</legend>
                        
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
					<div class="control-label">
						<?php echo $this->form->getLabel('menu10content'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu10content'); ?>
					</div>
				</div>
                        
                    </fieldset>
                </div>
				
				<div class="col-12 col-lg-4">
                    <fieldset id="fieldset-publishingdata" class="options-form">
                        <legend>Webview Menu 11</legend>
                        
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
						<?php echo $this->form->getLabel('menu11content'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu11content'); ?>
					</div>
				</div>
                        
                    </fieldset>
                </div>
				
				<div class="col-12 col-lg-4">
                    <fieldset id="fieldset-publishingdata" class="options-form">
                        <legend>Webview Menu 12</legend>
                        
                        <div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menu12show'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu12show'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menu12label'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu12label'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menu12color'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu12color'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menu12icon'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu12icon'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menu12access'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu12access'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menu12content'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu12content'); ?>
					</div>
				</div>
                        
                    </fieldset>
                </div>
				
			
				
				
				
				
				
				
				</div>   
			
			
			
			<div class="row">
				
				<div class="col-12 col-lg-4">
                    <fieldset id="fieldset-publishingdata" class="options-form">
                        <legend>Webview Menu 13</legend>
                        
                        <div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menu13show'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu13show'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menu13label'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu13label'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menu13color'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu13color'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menu13icon'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu13icon'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menu13access'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu13access'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menu13content'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu13content'); ?>
					</div>
				</div>
                        
                    </fieldset>
                </div>

                <div class="col-12 col-lg-4">
                    <fieldset id="fieldset-publishingdata" class="options-form">
                        <legend>Webview Menu 14</legend>
                        
                        <div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menu14show'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu14show'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menu14label'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu14label'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menu14color'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu14color'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menu14icon'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu14icon'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menu14access'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu14access'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menu14content'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu14content'); ?>
					</div>
				</div>
                        
                    </fieldset>
                </div>

                <div class="col-12 col-lg-4">
                    <fieldset id="fieldset-publishingdata" class="options-form">
                        <legend>Webview Menu 15</legend>
                        
                        <div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menu15show'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu15show'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menu15label'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu15label'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menu15color'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu15color'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menu15icon'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu15icon'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menu15access'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu15access'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('menu15content'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('menu15content'); ?>
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
        <?php echo JHtml::_('form.token'); ?>
    </div>
	<div id="validation-form-failed" data-backend-detail="webviewmenu" data-message="<?php echo $this->escape(Text::_('JGLOBAL_VALIDATION_FORM_FAILED'));?>">
	</div>
</form>

<style>

.span10.form-horizontal div.row {
  border-bottom: 3px solid #d300ff;
  margin-bottom: 30px;
}

</style>
