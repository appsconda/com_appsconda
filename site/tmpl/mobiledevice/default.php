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
?>
<?php if ($this->params->get('show_page_heading')) : ?>
    <div class="page-header">
        <h1>
			<?php if ($this->escape($this->params->get('page_heading'))) : ?>
				<?php echo $this->escape($this->params->get('page_heading')); ?>
			<?php else : ?>
				<?php echo $this->escape($this->params->get('page_title')); ?>
			<?php endif; ?>
        </h1>
    </div>
<?php endif; ?>
<div class="table-responsive">
    <table class="table table-striped">
        <tr>
			<th class="item-juserid">
				<?php echo JText::_('COM_APPSCONDA_HEADING_FRONTEND_DETAIL_MOBILEDEVICE_JUSERID'); ?>
			</th>
			<td>
				<?php echo $this->item->juserid; ?>
			</td>
		</tr>
		<tr>
			<th class="item-push">
				<?php echo JText::_('COM_APPSCONDA_HEADING_FRONTEND_DETAIL_MOBILEDEVICE_PUSH'); ?>
			</th>
			<td>
				<?php echo $this->item->push; ?>
			</td>
		</tr>
		<tr>
			<th class="item-created_time">
				<?php echo JText::_('COM_APPSCONDA_HEADING_FRONTEND_DETAIL_MOBILEDEVICE_CREATED_TIME'); ?>
			</th>
			<td>
				<?php echo $this->item->created_time; ?>
			</td>
		</tr>
		<tr>
			<th class="item-modified_time">
				<?php echo JText::_('COM_APPSCONDA_HEADING_FRONTEND_DETAIL_MOBILEDEVICE_MODIFIED_TIME'); ?>
			</th>
			<td>
				<?php echo $this->item->modified_time; ?>
			</td>
		</tr>
		<tr>
			<th class="item-devicetoken">
				<?php echo JText::_('COM_APPSCONDA_HEADING_FRONTEND_DETAIL_MOBILEDEVICE_DEVICETOKEN'); ?>
			</th>
			<td>
				<?php echo $this->item->devicetoken; ?>
			</td>
		</tr>
		<tr>
			<th class="item-created_by">
				<?php echo JText::_('COM_APPSCONDA_HEADING_FRONTEND_DETAIL_MOBILEDEVICE_CREATED_BY'); ?>
			</th>
			<td>
				<?php echo $this->item->created_by; ?>
			</td>
		</tr>
    </table>
</div>
