<?php
/**
 * @package            Joomla
 * @subpackage         AppsConda
 * @author             AppsConda ApS
 * @copyright          Copyright (C) 2023 AppsConda ApS
 * @license            GNU/GPL
 */

defined('_JEXEC') or die;

use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\Filesystem\File;
use Joomla\CMS\Filesystem\Folder;
use Joomla\CMS\Language\LanguageHelper;
use Joomla\CMS\Language\Multilanguage;
use Joomla\CMS\Language\Text;
use Joomla\Registry\Registry;

class com_appscondaInstallerScript
{
    function preFlight($type, $parent) {
        $this->executeSQLFile('/administrator/sql/update.sql');
    }

    private function executeSQLFile($filePath) {
        $db = Factory::getDbo();

        // Construct the full path to the SQL file
        // Assuming this script is within the 'scriptfile' element in your XML file
        $fullPath = JPATH_ADMINISTRATOR . $filePath;

        // Check if the file exists
        if (!file_exists($fullPath)) {
            JFactory::getApplication()->enqueueMessage("SQL file not found: " . $fullPath, 'error');
            return false;
        }

        // Read the SQL file
        $sql = file_get_contents($fullPath);

        // Execute each query in the file
        foreach (explode(';', $sql) as $query) {
            $trimmedQuery = trim($query);
            if (!empty($trimmedQuery)) {
                $db->setQuery($trimmedQuery);
                $db->execute();
            }
        }
    }
}

