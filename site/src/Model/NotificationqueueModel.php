<?php
/**
 * @package     com_appsconda
 * @version     1.0.0
 * @copyright   Copyright (C) 2023. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author     AppsConda ApS <support@appsconda.com> - https://appsconda.com
 */

namespace Joomla\Component\Appsconda\Site\Model;

// No direct access
defined('_JEXEC') or die;

use Joomla\CMS\MVC\Model\FormModel;
use Joomla\CMS\Factory;
use Joomla\CMS\Form\Form;

/**
 * Appsconda detail model
 */
class NotificationqueueModel extends FormModel
{
	/**
	 * The item to hold data
	 *
	 * @return object
	 */
    protected $_item;

    /**
     * Get the data
     *
     * @param null $pk
     *
     * @return  object
     *
     * @throws \Exception
     * @since   1.6
     */
	public function getItem($pk = null)
	{
		if (isset($this->_item)) {
			return $this->_item;
		}

		$app = Factory::getApplication();

		$id = $app->input->getInt('id');
		$params = $app->getParams();

        $paramId = $params->get('id');
        if ($paramId && !$id) {
            $id = $paramId;
        }

		$db = $this->getDbo();
		$query = $db->getQuery(true);

		$query->select('a.id, a.notification_id, a.token');
		$query->select('a.send_date, a.state, a.ordering');

		$query->from('#__appsconda_notificationqueues as a');

		$query->select('e.name AS `created_by`');
		$query->leftJoin($this->_db->qn('#__users') . ' AS `e` ON e.id = a.created_by');

		$query->where('a.id = ' . intval($id));
		$db->setQuery($query);

		try {
			$db->execute();
		} catch (\RuntimeException $e) {
			JError::raiseError(500, $e->getMessage());
		}

		$this->_item = $db->loadObject();

		return $this->_item;
	}

    /**
     * Method to get the form.
     *
     * The base form is loaded from XML
     *
     * @param	array	$data		An optional array of data for the form to interogate.
     * @param	boolean	$loadData	True if the form is to load its own data (default case), false if not.
     * @return	Form	A JForm object on success, false on failure
     * @throws \Exception
     * @since	1.6
     */
    public function getForm($data = [], $loadData = true)
    {
        Form::addFormPath(JPATH_ADMINISTRATOR . '/components/com_appsconda/forms');

        // Get the form
        $form = $this->loadForm('com_appsconda.notificationqueue', 'notificationqueue', ['control' => 'jform', 'load_data' => $loadData]);
        if (empty($form)) {
            return false;
        }

        return $form;
    }
}
