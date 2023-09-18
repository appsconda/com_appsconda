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
			<th class="item-appname">
				<?php echo JText::_('COM_APPSCONDA_HEADING_FRONTEND_DETAIL_COMPILATION_APPNAME'); ?>
			</th>
			<td>
				<?php echo $this->item->appname; ?>
			</td>
		</tr>
		<tr>
			<th class="item-packagename">
				<?php echo JText::_('COM_APPSCONDA_HEADING_FRONTEND_DETAIL_COMPILATION_PACKAGENAME'); ?>
			</th>
			<td>
				<?php echo $this->item->packagename; ?>
			</td>
		</tr>
		<tr>
			<th class="item-entrypage">
				<?php echo JText::_('COM_APPSCONDA_HEADING_FRONTEND_DETAIL_COMPILATION_ENTRYPAGE'); ?>
			</th>
			<td>
				<?php echo $this->item->entrypage; ?>
			</td>
		</tr>
		<tr>
			<th class="item-appicon">
				<?php echo JText::_('COM_APPSCONDA_HEADING_FRONTEND_DETAIL_COMPILATION_APPICON'); ?>
			</th>
			<td>
				<?php if(!empty($this->item->appicon)) : ?>
					<img src="<?php echo JURI::root() . $this->item->appicon; ?>" class="list-media" />
				<?php endif; ?>
			</td>
		</tr>
		<tr>
			<th class="item-splashimage">
				<?php echo JText::_('COM_APPSCONDA_HEADING_FRONTEND_DETAIL_COMPILATION_SPLASHIMAGE'); ?>
			</th>
			<td>
				<?php if(!empty($this->item->splashimage)) : ?>
					<img src="<?php echo JURI::root() . $this->item->splashimage; ?>" class="list-media" />
				<?php endif; ?>
			</td>
		</tr>
		<tr>
			<th class="item-splashbackground">
				<?php echo JText::_('COM_APPSCONDA_HEADING_FRONTEND_DETAIL_COMPILATION_SPLASHBACKGROUND'); ?>
			</th>
			<td>
				<?php echo $this->item->splashbackground; ?>
			</td>
		</tr>
		<tr>
			<th class="item-created_by">
				<?php echo JText::_('COM_APPSCONDA_HEADING_FRONTEND_DETAIL_COMPILATION_CREATED_BY'); ?>
			</th>
			<td>
				<?php echo $this->item->created_by; ?>
			</td>
		</tr>
    </table>
</div>
