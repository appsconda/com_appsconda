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
			<th class="item-name">
				<?php echo JText::_('COM_APPSCONDA_HEADING_FRONTEND_DETAIL_CUSTOMPAGE_NAME'); ?>
			</th>
			<td>
				<?php echo $this->item->name; ?>
			</td>
		</tr>
		<tr>
			<th class="item-image1">
				<?php echo JText::_('COM_APPSCONDA_HEADING_FRONTEND_DETAIL_CUSTOMPAGE_IMAGE1'); ?>
			</th>
			<td>
				<?php if(!empty($this->item->image1)) : ?>
					<img src="<?php echo JURI::root() . $this->item->image1; ?>" class="list-media" />
				<?php endif; ?>
			</td>
		</tr>
		<tr>
			<th class="item-title1">
				<?php echo JText::_('COM_APPSCONDA_HEADING_FRONTEND_DETAIL_CUSTOMPAGE_TITLE1'); ?>
			</th>
			<td>
				<?php echo $this->item->title1; ?>
			</td>
		</tr>
		<tr>
			<th class="item-content1">
				<?php echo JText::_('COM_APPSCONDA_HEADING_FRONTEND_DETAIL_CUSTOMPAGE_CONTENT1'); ?>
			</th>
			<td>
				<?php echo $this->item->content1; ?>
			</td>
		</tr>
		<tr>
			<th class="item-image2">
				<?php echo JText::_('COM_APPSCONDA_HEADING_FRONTEND_DETAIL_CUSTOMPAGE_IMAGE2'); ?>
			</th>
			<td>
				<?php if(!empty($this->item->image2)) : ?>
					<img src="<?php echo JURI::root() . $this->item->image2; ?>" class="list-media" />
				<?php endif; ?>
			</td>
		</tr>
		<tr>
			<th class="item-title2">
				<?php echo JText::_('COM_APPSCONDA_HEADING_FRONTEND_DETAIL_CUSTOMPAGE_TITLE2'); ?>
			</th>
			<td>
				<?php echo $this->item->title2; ?>
			</td>
		</tr>
		<tr>
			<th class="item-content2">
				<?php echo JText::_('COM_APPSCONDA_HEADING_FRONTEND_DETAIL_CUSTOMPAGE_CONTENT2'); ?>
			</th>
			<td>
				<?php echo $this->item->content2; ?>
			</td>
		</tr>
		<tr>
			<th class="item-image3">
				<?php echo JText::_('COM_APPSCONDA_HEADING_FRONTEND_DETAIL_CUSTOMPAGE_IMAGE3'); ?>
			</th>
			<td>
				<?php if(!empty($this->item->image3)) : ?>
					<img src="<?php echo JURI::root() . $this->item->image3; ?>" class="list-media" />
				<?php endif; ?>
			</td>
		</tr>
		<tr>
			<th class="item-title3">
				<?php echo JText::_('COM_APPSCONDA_HEADING_FRONTEND_DETAIL_CUSTOMPAGE_TITLE3'); ?>
			</th>
			<td>
				<?php echo $this->item->title3; ?>
			</td>
		</tr>
		<tr>
			<th class="item-content3">
				<?php echo JText::_('COM_APPSCONDA_HEADING_FRONTEND_DETAIL_CUSTOMPAGE_CONTENT3'); ?>
			</th>
			<td>
				<?php echo $this->item->content3; ?>
			</td>
		</tr>
		<tr>
			<th class="item-image4">
				<?php echo JText::_('COM_APPSCONDA_HEADING_FRONTEND_DETAIL_CUSTOMPAGE_IMAGE4'); ?>
			</th>
			<td>
				<?php if(!empty($this->item->image4)) : ?>
					<img src="<?php echo JURI::root() . $this->item->image4; ?>" class="list-media" />
				<?php endif; ?>
			</td>
		</tr>
		<tr>
			<th class="item-title4">
				<?php echo JText::_('COM_APPSCONDA_HEADING_FRONTEND_DETAIL_CUSTOMPAGE_TITLE4'); ?>
			</th>
			<td>
				<?php echo $this->item->title4; ?>
			</td>
		</tr>
		<tr>
			<th class="item-content4">
				<?php echo JText::_('COM_APPSCONDA_HEADING_FRONTEND_DETAIL_CUSTOMPAGE_CONTENT4'); ?>
			</th>
			<td>
				<?php echo $this->item->content4; ?>
			</td>
		</tr>
		<tr>
			<th class="item-image5">
				<?php echo JText::_('COM_APPSCONDA_HEADING_FRONTEND_DETAIL_CUSTOMPAGE_IMAGE5'); ?>
			</th>
			<td>
				<?php if(!empty($this->item->image5)) : ?>
					<img src="<?php echo JURI::root() . $this->item->image5; ?>" class="list-media" />
				<?php endif; ?>
			</td>
		</tr>
		<tr>
			<th class="item-title5">
				<?php echo JText::_('COM_APPSCONDA_HEADING_FRONTEND_DETAIL_CUSTOMPAGE_TITLE5'); ?>
			</th>
			<td>
				<?php echo $this->item->title5; ?>
			</td>
		</tr>
		<tr>
			<th class="item-content5">
				<?php echo JText::_('COM_APPSCONDA_HEADING_FRONTEND_DETAIL_CUSTOMPAGE_CONTENT5'); ?>
			</th>
			<td>
				<?php echo $this->item->content5; ?>
			</td>
		</tr>
		<tr>
			<th class="item-image6">
				<?php echo JText::_('COM_APPSCONDA_HEADING_FRONTEND_DETAIL_CUSTOMPAGE_IMAGE6'); ?>
			</th>
			<td>
				<?php if(!empty($this->item->image6)) : ?>
					<img src="<?php echo JURI::root() . $this->item->image6; ?>" class="list-media" />
				<?php endif; ?>
			</td>
		</tr>
		<tr>
			<th class="item-title6">
				<?php echo JText::_('COM_APPSCONDA_HEADING_FRONTEND_DETAIL_CUSTOMPAGE_TITLE6'); ?>
			</th>
			<td>
				<?php echo $this->item->title6; ?>
			</td>
		</tr>
		<tr>
			<th class="item-content6">
				<?php echo JText::_('COM_APPSCONDA_HEADING_FRONTEND_DETAIL_CUSTOMPAGE_CONTENT6'); ?>
			</th>
			<td>
				<?php echo $this->item->content6; ?>
			</td>
		</tr>
		<tr>
			<th class="item-image7">
				<?php echo JText::_('COM_APPSCONDA_HEADING_FRONTEND_DETAIL_CUSTOMPAGE_IMAGE7'); ?>
			</th>
			<td>
				<?php if(!empty($this->item->image7)) : ?>
					<img src="<?php echo JURI::root() . $this->item->image7; ?>" class="list-media" />
				<?php endif; ?>
			</td>
		</tr>
		<tr>
			<th class="item-title7">
				<?php echo JText::_('COM_APPSCONDA_HEADING_FRONTEND_DETAIL_CUSTOMPAGE_TITLE7'); ?>
			</th>
			<td>
				<?php echo $this->item->title7; ?>
			</td>
		</tr>
		<tr>
			<th class="item-content7">
				<?php echo JText::_('COM_APPSCONDA_HEADING_FRONTEND_DETAIL_CUSTOMPAGE_CONTENT7'); ?>
			</th>
			<td>
				<?php echo $this->item->content7; ?>
			</td>
		</tr>
		<tr>
			<th class="item-image8">
				<?php echo JText::_('COM_APPSCONDA_HEADING_FRONTEND_DETAIL_CUSTOMPAGE_IMAGE8'); ?>
			</th>
			<td>
				<?php if(!empty($this->item->image8)) : ?>
					<img src="<?php echo JURI::root() . $this->item->image8; ?>" class="list-media" />
				<?php endif; ?>
			</td>
		</tr>
		<tr>
			<th class="item-title8">
				<?php echo JText::_('COM_APPSCONDA_HEADING_FRONTEND_DETAIL_CUSTOMPAGE_TITLE8'); ?>
			</th>
			<td>
				<?php echo $this->item->title8; ?>
			</td>
		</tr>
		<tr>
			<th class="item-content8">
				<?php echo JText::_('COM_APPSCONDA_HEADING_FRONTEND_DETAIL_CUSTOMPAGE_CONTENT8'); ?>
			</th>
			<td>
				<?php echo $this->item->content8; ?>
			</td>
		</tr>
		<tr>
			<th class="item-image9">
				<?php echo JText::_('COM_APPSCONDA_HEADING_FRONTEND_DETAIL_CUSTOMPAGE_IMAGE9'); ?>
			</th>
			<td>
				<?php if(!empty($this->item->image9)) : ?>
					<img src="<?php echo JURI::root() . $this->item->image9; ?>" class="list-media" />
				<?php endif; ?>
			</td>
		</tr>
		<tr>
			<th class="item-title9">
				<?php echo JText::_('COM_APPSCONDA_HEADING_FRONTEND_DETAIL_CUSTOMPAGE_TITLE9'); ?>
			</th>
			<td>
				<?php echo $this->item->title9; ?>
			</td>
		</tr>
		<tr>
			<th class="item-content9">
				<?php echo JText::_('COM_APPSCONDA_HEADING_FRONTEND_DETAIL_CUSTOMPAGE_CONTENT9'); ?>
			</th>
			<td>
				<?php echo $this->item->content9; ?>
			</td>
		</tr>
		<tr>
			<th class="item-image10">
				<?php echo JText::_('COM_APPSCONDA_HEADING_FRONTEND_DETAIL_CUSTOMPAGE_IMAGE10'); ?>
			</th>
			<td>
				<?php if(!empty($this->item->image10)) : ?>
					<img src="<?php echo JURI::root() . $this->item->image10; ?>" class="list-media" />
				<?php endif; ?>
			</td>
		</tr>
		<tr>
			<th class="item-title10">
				<?php echo JText::_('COM_APPSCONDA_HEADING_FRONTEND_DETAIL_CUSTOMPAGE_TITLE10'); ?>
			</th>
			<td>
				<?php echo $this->item->title10; ?>
			</td>
		</tr>
		<tr>
			<th class="item-content10">
				<?php echo JText::_('COM_APPSCONDA_HEADING_FRONTEND_DETAIL_CUSTOMPAGE_CONTENT10'); ?>
			</th>
			<td>
				<?php echo $this->item->content10; ?>
			</td>
		</tr>
		<tr>
			<th class="item-created_by">
				<?php echo JText::_('COM_APPSCONDA_HEADING_FRONTEND_DETAIL_CUSTOMPAGE_CREATED_BY'); ?>
			</th>
			<td>
				<?php echo $this->item->created_by; ?>
			</td>
		</tr>
    </table>
</div>
