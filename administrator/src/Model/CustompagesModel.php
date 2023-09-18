<?php
/**
 * @package     com_appsconda
 * @version     1.0.0
 * @copyright   Copyright (C) 2023. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      AppsConda ApS <support@appsconda.com> - https://appsconda.com
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
class CustompagesModel extends ListModel
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
				'name', 'a.name',
				'title2', 'a.title2',
				'content2', 'a.content2',
				'image3', 'a.image3',
				'title3', 'a.title3',
				'content3', 'a.content3',
				'image4', 'a.image4',
				'title4', 'a.title4',
				'content4', 'a.content4',
				'image5', 'a.image5',
				'title5', 'a.title5',
				'content5', 'a.content5',
				'image6', 'a.image6',
				'title6', 'a.title6',
				'content6', 'a.content6',
				'image7', 'a.image7',
				'title7', 'a.title7',
				'content7', 'a.content7',
				'image8', 'a.image8',
				'title8', 'a.title8',
				'content8', 'a.content8',
				'image9', 'a.image9',
				'title9', 'a.title9',
				'content9', 'a.content9',
				'image10', 'a.image10',
				'title10', 'a.title10',
				'content10', 'a.content10',
				'ordering', 'a.ordering',
				'created_by', 'a.created_by',
				'state', 'a.state',
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

		$query->select('a.id, a.name, a.title2');
		$query->select('a.content2, a.image3, a.title3');
		$query->select('a.content3, a.image4, a.title4');
		$query->select('a.content4, a.image5, a.title5');
		$query->select('a.content5, a.image6, a.title6');
		$query->select('a.content6, a.image7, a.title7');
		$query->select('a.content7, a.image8, a.title8');
		$query->select('a.content8, a.image9, a.title9');
		$query->select('a.content9, a.image10, a.title10');
		$query->select('a.content10, a.ordering, a.state');

		$query->from('`#__appsconda_custompages` AS a');

		$query->select('ad.name AS `created_by`');
		$query->leftJoin($this->_db->qn('#__users') . ' AS `ad` ON ad.id = a.created_by');

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
            'a.name',
			'ad.name',
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
