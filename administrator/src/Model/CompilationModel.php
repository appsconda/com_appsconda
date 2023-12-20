<?php
/**
 * @package     com_appsconda
 * @version     1.0.0
 * @copyright   Copyright (C) 2023. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author     AppsConda ApS <support@appsconda.com> - https://appsconda.com
 */

namespace Joomla\Component\Appsconda\Administrator\Model;

// No direct access
defined('_JEXEC') or die;

use Joomla\CMS\MVC\Model\AdminModel;
use Joomla\CMS\Table\Table;
use Joomla\CMS\Factory;
use Joomla\CMS\UCM\UCMType;
use Joomla\CMS\Uri\Uri;

/**
 * Appsconda model
 */
class CompilationModel extends AdminModel
{
	/**
	 * @var		string	The prefix to use with controller messages
	 * @since	1.6
	 */
	protected $text_prefix = 'COM_APPSCONDA';

	/**
	 * Method to get the record form.
	 *
	 * @param    array $data An optional array of data for the form to interogate
	 * @param bool $loadData
	 *
	 * @return bool A JForm object on success, false on failure
	 * @since    1.6
	 */
	public function getForm($data = array(), $loadData = true)
	{
		// Get the form
		$form = $this->loadForm('com_appsconda.compilation', 'compilation', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form))
		{
			return false;
		}

		return $form;
	}

	/**
	 * Method to get the data that should be injected in the form
	 *
	 * @return	mixed	The data for the form
	 * @since	1.6
	 */
	protected function loadFormData()
	{
		// Check the session for previously entered form data
		$data = Factory::getApplication()->getUserState('com_appsconda.edit.compilation.data', array());

		if (empty($data))
		{
			$data = $this->getItem();
			
			if (empty($data->packagename)) {
			    $uri = Uri::getInstance();
			    $domain = $uri->getHost();
			    $initialpkg = 'app.' . $domain;
			    // Split the string into parts
                $parts = explode('.', $initialpkg);
                // Take only the first three parts and rejoin them
                $finalpkg = implode('.', array_slice($parts, 0, 3));
                $data->packagename = $finalpkg;
            } else {
                $app = Factory::getApplication();
                // Regular expression to match the format 'word.word.word'
                if (!preg_match('/^[a-zA-Z0-9]+(\.[a-zA-Z0-9]+){2}$/', $data->packagename)) {
                    // Display a message if the format is not matched
                    $app->enqueueMessage( 'The "Name of the package" must be in the format word.word.word. e.g. app.domain.com.', 'error' );
                } else {
                    // Format is correct, continue your logic
                }
            }
		}

		return $data;
	}

	/**
	 * Prepare and sanitise the table prior to saving
	 *
	 * @since	1.6
	 */
	protected function prepareTable($table)
	{
		jimport('joomla.filter.output');

		if (empty($table->id))
		{
			// Set ordering to the last item if not set
			if (@$table->ordering === '') {
				$db = Factory::getDbo();
				$db->setQuery('SELECT MAX(ordering) FROM #__appsconda_compilations');
				$max = $db->loadResult();
				$table->ordering = $max+1;
			}
		}
	}

	/**
	 * Method to initialize member variables used by batch methods and other methods like saveorder()
	 *
	 * @return  void
	 *
	 * @since   3.8.2
	 */
	public function initBatch()
	{
		if ($this->batchSet === null)
		{
			$this->batchSet = true;

			// Get current user
			$this->user = Factory::getUser();

			// Get table
			$this->table = $this->getTable();

			// Get table class name
			$tc = explode('\\', \get_class($this->table));
			$this->tableClassName = end($tc);

			if ($this->typeAlias === null) {
				$this->typeAlias = '';
			}

			// Get UCM Type data
			$this->contentType = new UCMType;
			$this->type = $this->contentType->getTypeByTable($this->tableClassName)
				?: $this->contentType->getTypeByAlias($this->typeAlias);
		}
	}

    /**
     * @param $data
     * @return bool
     */
    public function save($data)
    {
        foreach ($this->getForm()->getFieldset() as $field) {
            if ($field->type === 'Calendar' && $data[$field->fieldname] === '') {
                $data[$field->fieldname] = null;
            }
        }
        return parent::save($data);
    }
}
