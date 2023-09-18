<?php
/**
 * @package     com_appsconda
 * @version     1.0.0
 * @copyright   Copyright (C) 2023. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      AppsConda ApS <support@appsconda.com> - https://appsconda.com
 */

namespace Joomla\Component\Appsconda\Administrator\Helper;

// No direct access
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\Database\Mysqli\MysqliQuery;

/**
 * Appsconda helper class
 */
class AppscondaHelper
{
	/**
	 * Add the submenus
	 *
	 * @param string $name
	 */
	public static function addSubmenu($name = '')
	{
		\JHtmlSidebar::addEntry(
			Text::_('COM_APPSCONDA_TITLE_CUSTOMPAGES'),
			'index.php?option=com_appsconda&view=custompages',
			$name === 'custompages'
		);
	}

	/**
	 * Gets a list of the actions that can be performed
	 *
	 * @return array
	 * @since    1.6
	 */
	public static function getActions() : array
	{
		$user	= Factory::getUser();
		$result	= [];

		$assetName = 'com_appsconda';

		$actions = [
			'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.state', 'core.delete'
		];

		foreach ($actions as $action)
		{
			$result[$action] = $user->authorise($action, $assetName);
		}

		return $result;
	}

	/**
	 * Build the search query from the columns
	 *
	 * @param	string		        $searchPhrase	    Search for this phrase
	 * @param	array		        $searchColumns	    The columns in the DB to look up
	 * @param   MysqliQuery         $query              The query
	 *
	 * @return	MysqliQuery		    $query			    The query (search filters applied)
	 */
	public static function buildSearchQuery(string $searchPhrase, array $searchColumns, MysqliQuery $query) : MysqliQuery
	{
		$db = Factory::getDbo();

		$where = [];

		foreach ($searchColumns as $i => $searchColumn)
		{
			$where[] = $db->qn($searchColumn) . ' LIKE ' . $db->q('%' . $db->escape($searchPhrase, true) . '%');
		}

		if (!empty($where))
		{
			$query->where('(' . implode(' OR ', $where) . ')');
		}

		return $query;
	}
}
