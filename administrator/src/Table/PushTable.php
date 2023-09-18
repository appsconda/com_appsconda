<?php
/**
 * @package     com_appsconda
 * @version     1.0.0
 * @copyright   Copyright (C) 2023. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author     AppsConda ApS <support@appsconda.com> - https://appsconda.com
 */

namespace Joomla\Component\Appsconda\Administrator\Table;

// No direct access
defined('_JEXEC') or die;

use Joomla\CMS\Table\Table;
use Joomla\CMS\Factory;
use Joomla\Utilities\ArrayHelper;
use Joomla\CMS\Language\Text;

/**
 * Appsconda table
 */
class PushTable extends Table
{
    /**
     * Constructor
     *
     * @param JDatabase A database connector object
     */
    public function __construct(&$db)
    {
        parent::__construct('#__appsconda_pushs', 'id', $db);
    }

    /**
     * Overloaded bind function to pre-process the params.
     *
     * @param	array		Named array
     * @return	null|string	null is operation was satisfactory, otherwise returns an error
     * @see		JTable:bind
     * @since	1.5
     */
    public function bind($array, $ignore = '')
    {
		$input = Factory::getApplication()->input;
		$task = $input->getString('task', '');

		if(($task === 'save' || $task === 'apply') && ( !Factory::getUser()->authorise('core.edit.state','com_appsconda') && (int)$array['state'] === 1))
        {
			$array['state'] = 0;
		}

        if (isset($array['params']) && is_array($array['params']))
        {
            $registry = new JRegistry();
            $registry->loadArray($array['params']);
            $array['params'] = (string) $registry;
        }

        if (isset($array['metadata']) && is_array($array['metadata']))
        {
            $registry = new JRegistry();
            $registry->loadArray($array['metadata']);
            $array['metadata'] = (string) $registry;
        }

        if(!Factory::getUser()->authorise('core.admin', 'com_appsconda.push.'.$array['id']))
        {
            $actions = Factory::getACL()->getActions('com_appsconda','push');
            $default_actions = Factory::getACL()->getAssetRules('com_appsconda.push.'.$array['id'])->getData();
            $array_jaccess = array();
            foreach($actions as $action)
            {
                $array_jaccess[$action->name] = $default_actions[$action->name];
            }
            $array['rules'] = $this->JAccessRulestoArray($array_jaccess);
        }

        //Bind the rules for ACL where supported.
		if (isset($array['rules']) && is_array($array['rules']))
        {
			$this->setRules($array['rules']);
		}

		$dateTimeNow = new \DateTime('NOW');

		if ($array['id'])
		{
			$array['updated_datetime'] = $dateTimeNow->format('Y-m-d H:i:s');
		}
		else
		{
			$array['created_datetime'] = $dateTimeNow->format('Y-m-d H:i:s');
		}
		
        return parent::bind($array, $ignore);
    }

	/**
	 * This function convert an array of JAccessRule objects into an rules array.
	 *
	 * @param type $jaccessrules an arrao of JAccessRule objects
	 *
	 * @return array
	 */
    private function JAccessRulestoArray($jaccessrules)
    {
        $rules = array();
        foreach($jaccessrules as $action => $jaccess)
        {
            $actions = array();
            foreach($jaccess->getData() as $group => $allow)
            {
                $actions[$group] = ((bool)$allow);
            }
            $rules[$action] = $actions;
        }
        return $rules;
    }

    /**
     * Overloaded check function
     */
    public function check()
    {
        //If there is an ordering column and this is a new row then get the next ordering value
        if (property_exists($this, 'ordering') && (int)$this->id === 0)
        {
            $this->ordering = self::getNextOrder();
        }

        return parent::check();
    }

	/**
	 * The default store method
	 *
	 * @param bool $updateNulls
	 *
	 * @return bool
	 */
    function store($updateNulls = false)
    {
    	$k = $this->_tbl_key;

    	if ($this->$k)
    	{
    		$ret = $this->updateObject($updateNulls);
    	}
    	else
    	{
    		$ret = $this->_db->insertObject($this->_tbl, $this, $this->_tbl_key);
    	}
    
    	if (!$ret)
    	{
    		$this->setError(get_class( $this ).'::store failed - ' . $this->_db->getErrorMsg());

    		return false;
    	}

    	return true;
    }
    
    /**
     * Method to set the publishing state for a row or list of rows in the database
     * table. The method respects checked out rows by other users and will attempt
     * to checkin rows that it can after adjustments are made
     *
     * @param    mixed    	An optional array of primary key values to update.  If not
     *                    	set the instance property value is used.
     * @param    integer 	The publishing state. eg. [0 = unpublished, 1 = published]
     * @param    integer 	The user id of the user performing the operation
     * @return   boolean    True on success
     * @since    1.0.4
     */
    public function publish($pks = null, $state = 1, $userId = 0)
    {
        // Initialise variables
        $k = $this->_tbl_key;

        // Sanitize input.
	    ArrayHelper::toInteger($pks);
        $userId = (int) $userId;
        $state = (int) $state;

        // If there are no primary keys set check to see if the instance key is set.
        if (empty($pks))
        {
            if ($this->$k)
            {
                $pks = array($this->$k);
            }
            // Nothing to set publishing state on, return false.
            else
            {
                $this->setError(Text::_('JLIB_DATABASE_ERROR_NO_ROWS_SELECTED'));
                return false;
            }
        }

        // Build the WHERE clause for the primary keys.
        $where = $k . '=' . implode(' OR ' . $k . '=', $pks);

        // Determine if there is checkin support for the table.
        if (!property_exists($this, 'checked_out') || !property_exists($this, 'checked_out_time'))
        {
            $checkin = '';
        }
        else
        {
            $checkin = ' AND (checked_out = 0 OR checked_out = ' . (int) $userId . ')';
        }

        try
        {
	        // Update the publishing state for rows with the given primary keys
	        $this->_db->setQuery(
		        'UPDATE `' . $this->_tbl . '`' .
		        ' SET `state` = ' . (int) $state .
		        ' WHERE (' . $where . ')' .
		        $checkin
	        );
	        $this->_db->execute();
        }
        catch (\RuntimeException $e)
        {
	        throw new \RuntimeException($e->getMessage());
        }

        // If checkin is supported and all rows were adjusted, check them in.
        if ($checkin && (count($pks) == $this->_db->getAffectedRows()))
        {
            // Checkin each row
            foreach ($pks as $pk)
            {
                $this->checkin($pk);
            }
        }

        // If the JTable instance value is in the list of primary keys that were set, set the instance.
        if (in_array($this->$k, $pks))
        {
            $this->state = $state;
        }

        $this->setError('');
        return true;
    }
    
    /**
      * Define a namespaced asset name for inclusion in the #__assets table
      * 
      * @return string The asset name 
      *
      * @see 	JTable::_getAssetName
      */
    protected function _getAssetName()
    {
        $k = $this->_tbl_key;
        return 'com_appsconda.push.' . (int) $this->$k;
    }

	/**
	 * Returns the parent asset's id. If you have a tree structure, retrieve the parent's id using the external key field
	 *
	 * @see JTable::_getAssetParentId
	 *
	 * @param Table|null $table
	 * @param null $id
	 *
	 * @return int
	 */
    protected function _getAssetParentId(Table $table = NULL, $id = NULL) : int
    {
        // We will retrieve the parent-asset from the Asset-table
        $assetParent = Table::getInstance('Asset');
        // Default: if no asset-parent can be found we take the global asset
        $assetParentId = $assetParent->getRootId();
        // The item has the component as asset-parent
        $assetParent->loadByName('com_appsconda');
        // Return the found asset-parent-id
        if ($assetParent->id)
        {
            $assetParentId=$assetParent->id;
        }
        return $assetParentId;
    }

    /**
     * Updates a row in a table based on an object's properties.
     *
     * @param boolean $updateNulls True to update null fields or false to ignore them.
     *
     * @return  boolean
     *
     * @throws \Exception
     * @since   1.7.0
     */
    public function updateObject(bool $updateNulls = false): bool
    {
        $fields = [];
        $where = [];

        $key = '';
        if (is_string($this->_tbl_key)) {
            $key = array($this->_tbl_key);
        }

        if (is_object($this->_tbl_key)) {
            $key = (array)$this->_tbl_key;
        }

        $statement = 'UPDATE ' . $this->_db->qn($this->_tbl) . ' SET %s WHERE %s';

        foreach (get_object_vars($this) as $k => $v) {
            if (is_array($v) || is_object($v) || $k[0] === '_') {
                continue;
            }
            if (in_array($k, $key)) {
                $where[] = $this->_db->qn($k) . ($v === null ? ' IS NULL' : ' = ' . $this->_db->q($v));
                continue;
            }

            if ($v === null) {
                if ($updateNulls) {
                    $val = 'NULL';
                } else {
                    continue;
                }
            } else {
                $val = $this->_db->q($v);
            }

            $fields[$k] = $this->_db->qn($k) . '=' . $val;
        }

        if (empty($fields)) {
            return true;
        }

        $fields = $this->setNullValues($fields);
        $this->_db->setQuery(sprintf($statement, implode(',', array_values($fields)), implode(' AND ', $where)));

        return $this->_db->execute();
    }

    /**
     * @param array $fields
     * @return array|mixed
     * @throws \Exception
     */
    private function setNullValues(array $fields): array
    {
        $app = Factory::getApplication();
        if ($app === null) {
            return $fields;
        }
        $data = $app->input->get('jform', null, null);
        $id = !empty($data['id']) ? $data['id'] : $app->input->get('id');
        if (!$id) {
            return $fields;
        }
        foreach ($this->getFields() as $field) {
            if ($field->Null === 'YES' && $data[$field->Field] === '' && in_array($field->Type, ['date', 'datetime'])) {
                $fields[$field->Field] = $this->_db->qn($field->Field) . ' = NULL';
            }
        }
        return $fields;
    }
}
