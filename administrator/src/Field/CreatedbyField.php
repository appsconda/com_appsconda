<?php
/**
 * @package     com_appsconda
 * @version     1.0.0
 * @copyright   Copyright (C) 2023. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      AppsConda ApS <support@appsconda.com> - https://appsconda.com
 */

namespace Joomla\Component\Appsconda\Administrator\Field;

defined('_JEXEC') or die;

use Joomla\CMS\Form\Field\ListField;
use Joomla\CMS\Factory;

/**
 * The form field implementation
 */
class CreatedbyField extends ListField
{
	/**
	 * The form field type
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'createdby';

	/**
	 * Method to get the field input markup
	 *
	 * @return	string	The field input markup
	 * @since	1.6
	 */
	protected function getInput()
	{
		// Get the current user
		$user = Factory::getUser();

		// Set this to be sure the user texts are displayed as default
		$userExists = true;

		// If the value is set
		if ($this->value)
		{
			// Look for the user in the DB
			$db = Factory::getDbo();
			$query = $db->getQuery(true)
				->select('id')
				->from('#__users')
				->where($db->qn('id') . ' = ' . $db->q($this->value));
			$db->setQuery($query);
			$userId = $db->loadResult();

			// If the user exists in the DB
			if ($userId)
			{
				// Get the user from the value in the input box
				$user = Factory::getUser($this->value);
			}
			else
			{
				$userExists = false;

				// Otherwise set the value to the current user
				$this->value = $user->id;
			}
		}
		else
		{
			// Set the value to the current user
			$this->value = $user->id;
		}

        $html = '';

		// If the user ID exists in the DB (this user exists)
		if ($userExists)
		{
			$html = $user->name . " (" . $user->username . ")";
		}

		$html .= '<input type="hidden" name="' . $this->name . '" value="' . $this->value . '" />';

		return $html;
	}
}
