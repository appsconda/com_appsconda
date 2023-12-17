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


/** @var \Joomla\Component\Appsconda\Administrator\View\Custompage\HtmlView $this */

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
						<?php echo $this->form->getLabel('name'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('name'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('image1'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('image1'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('title1'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('title1'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('content1'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('content1'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('image2'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('image2'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('title2'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('title2'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('content2'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('content2'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('image3'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('image3'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('title3'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('title3'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('content3'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('content3'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('image4'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('image4'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('title4'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('title4'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('content4'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('content4'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('image5'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('image5'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('title5'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('title5'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('content5'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('content5'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('image6'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('image6'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('title6'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('title6'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('content6'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('content6'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('image7'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('image7'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('title7'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('title7'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('content7'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('content7'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('image8'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('image8'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('title8'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('title8'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('content8'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('content8'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('image9'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('image9'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('title9'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('title9'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('content9'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('content9'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('image10'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('image10'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('title10'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('title10'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('content10'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('content10'); ?>
					</div>
				</div>
						<?php echo $this->form->getInput('ordering'); ?>
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
	<div id="validation-form-failed" data-backend-detail="custompage" data-message="<?php echo $this->escape(Text::_('JGLOBAL_VALIDATION_FORM_FAILED'));?>">
	</div>
</form>
