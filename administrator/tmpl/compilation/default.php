<?php
/**
 * @package     com_appsconda
 * @version     1.0.0
 * @copyright   Copyright (C) 2023. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author     AppsConda ApS <support@appsconda.com> - https://appsconda.com
 */

// No direct access
defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Http\HttpFactory;

/** @var \Joomla\Component\Appsconda\Administrator\View\Compilation\HtmlView $this */

/** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
$wa = $this->document->getWebAssetManager();
$wa->getRegistry()->addExtensionRegistryFile('com_contenthistory');
$wa->useScript('keepalive')
   ->useScript('form.validate')
   ->useScript('com_contenthistory.admin-history-versions');
?>

<?php

$sentforcompile = $this->item->sentforcompile;
if ($sentforcompile === 1) {
$packagename = $this->item->packagename;  // Or wherever you get this from

        // Prepare the URL
        $url = "https://appsconda.com/index.php?option=com_appscompile&view=api&task=api.compilestatus&package=" . $packagename;

        // Get an instance of Joomla's HTTP client
        $http = HttpFactory::getHttp();
        
        try {
            $response = $http->get($url);
            
            // Decode the response body
            $result = json_decode($response->body, true);
            
            if ($response->code === 200 && $result['success'] == true) {
                // Display success result
                echo "<div style='background: #f2f8f4;color: #457d54;padding: 10px;margin-bottom: 30px;border: 1px solid #0fbd2a;'>";
				echo "<div><b><u>" . Text::_('MESSAGE_FROM_APP_COMPILATION_API') . "</u></b></div>";
				echo "<div>" . Text::_('PACKAGE_NAME') . htmlspecialchars($result['result']['packagename']) . "</div>";
                echo "<div>" . Text::_('COMPILATION_STATUS') . htmlspecialchars($result['result']['status']) . "</div>";
                
                echo "<div>" . Text::_('APP_DOWNLOAD_URL');
                if (!empty($result['result']['downloadurl'])) {
                    echo "<a target='_blank' href='" . htmlspecialchars($result['result']['downloadurl']) . "'>Download</a>";
                }
                echo "</div>";

                echo "<div>" . Text::_('APP_COMPILATION_NOTE') . htmlspecialchars($result['result']['note']) . "</div>";
				echo "</div>";
            } else {
                // Display error message
                echo "<div style='background: #e1dd9b;color: #000;padding: 10px;margin-bottom: 30px;border: 1px solid #bfba67;'>";
				echo "<div>Message from the App Compilation API:</div>";
				echo "<div class='error'>" . htmlspecialchars($result['message']) . "</div>";
				echo "</div>";
            }
        } catch (Exception $e) {
            // Display exception message
            echo "<div style='background: #fef8f8;color: #c52827;padding: 10px;margin-bottom: 30px;border: 1px solid #c52827;'>";
			echo "<div>Message from the App Compilation API:</div>";
			echo "<div class='error'>Error while fetching data.</div>";
			echo "</div>";
        }
}

?>
<form action="<?php echo Route::_('index.php?option=com_appsconda&layout=edit&id=' . $this->item->id); ?>" method="post" enctype="multipart/form-data" name="adminForm" id="adminForm" class="form-validate">
	<div class="row-fluid">
		<div class="span10 form-horizontal">
            <fieldset class="adminform">
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('id'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('id'); ?>
					</div>
				</div>
            	<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('appname'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('appname'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('packagename'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('packagename'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('entrypage'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('entrypage'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('appicon'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('appicon'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('splashimage'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('splashimage'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('splashbackground'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('splashbackground'); ?>
					</div>
				</div>
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
	<div id="validation-form-failed" data-backend-detail="compilation" data-message="<?php echo $this->escape(Text::_('JGLOBAL_VALIDATION_FORM_FAILED'));?>">
	</div>
</form>
