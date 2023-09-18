<?php
/**
 * @package     com_appsconda
 * @version     1.0.0
 * @copyright   Copyright (C) 2023. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author     AppsConda ApS <support@appsconda.com> - https://appsconda.com
 */

namespace Joomla\Component\Appsconda\Administrator\Model;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\Model\ListModel;
use Joomla\CMS\Factory;
use Joomla\CMS\Component\ComponentHelper;
use Joomla\Component\Appsconda\Administrator\Helper\AppscondaHelper;

/**
 * Appsconda model
 */
class PushsModel extends ListModel
{
	/**
	 * @var		int		An array with the filtering columns
	 */
	protected $filter_fields;
	
    /**
     * Constructor
     *
     * @param    array    		An optional associative array of configuration settings
	 *
     * @see      JController
     * @since    1.6
     */
    public function __construct($config = array())
    {
        if (empty($config['filter_fields']))
        {
            $config['filter_fields'] = array(
				'id', 'a.id',
				'title', 'a.title',
				'send_date', 'a.send_date',
				'message', 'a.message',
				'image', 'a.image',
				'created_by', 'a.created_by',
				'state', 'a.state',
				'ordering', 'a.ordering',
            );
        }

        parent::__construct($config);
    }

	/**
	 * Method to auto-populate the model state
	 *
	 * Note. Calling getState in this method will result in recursion
	 *
	 * @param null $ordering
	 * @param null $direction
	 */
	protected function populateState($ordering = null, $direction = null)
	{
		// Initialise variables
		$app = Factory::getApplication('administrator');

		// Load the filter state
		$search = $app->getUserStateFromRequest($this->context.'.filter.search', 'filter_search');
		$this->setState('filter.search', $search);

		$published = $app->getUserStateFromRequest($this->context.'.filter.state', 'filter_published', '', 'int');
		$this->setState('filter.state', $published);

		// List state information
		$value = $app->input->get('limit', $app->get('list_limit', 20), 'uint');
		$this->setState('list.limit', $value);

		$value = $app->input->get('limitstart', 0, 'uint');
		$this->setState('list.start', $value);

		// Load the parameters
		$params = ComponentHelper::getParams('com_appsconda');
		$this->setState('params', $params);

		// List state information
		parent::populateState('a.ordering', 'asc');
	}

	/**
	 * Build an SQL query to load the list data.
	 *
	 * @return	JDatabaseQuery
	 * @since	1.6
	 */
	protected function getListQuery()
	{
		$query	= $this->_db->getQuery(true);

		$query->select('a.id, a.title, a.message, a.send_date');
		$query->select('a.image, a.state, a.ordering');

		$query->from('`#__appsconda_pushs` AS a');

		$query->select('e.name AS `created_by`');
		$query->leftJoin($this->_db->qn('#__users') . ' AS `e` ON e.id = a.created_by');

		// Filter by published state
		$state = $this->getState('filter.published');

		if (is_numeric($state))
		{
			$query->where('a.state = ' . (int)$state);
		}
		elseif ($state !== '*')
		{
			$query->where('(a.state IN (0, 1))');
		}

		// Search for this word
		$searchPhrase = $this->getState('filter.search');

		// Search in these columns
		$searchColumns = array(
            'a.title',
			'a.message',
			'e.name',
        );

		if (!empty($searchPhrase))
		{
			if (stripos($searchPhrase, 'id:') === 0)
			{
				// Build the ID search
				$idPart = (int) substr($searchPhrase, 3);
				$query->where($this->_db->qn('a.id') . ' = ' . $this->_db->q($idPart));
			}
			else
			{
				// Build the search query from the search word and search columns
				$query = AppscondaHelper::buildSearchQuery($searchPhrase, $searchColumns, $query);
			}
		}

		// Add the list ordering clause
        $orderCol	= $this->state->get('list.ordering');
        $orderDirn	= $this->state->get('list.direction');

        if ($orderCol && $orderDirn)
        {
	        $query->order($this->_db->escape($orderCol.' '.$orderDirn));
        }

		return $query;
	}
}
