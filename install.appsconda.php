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
    function preFlight($parent) {
      /*  
      // Get the current version of the installed component
        $currentVersion = ...; // Implement the logic to get the current version

        // Check if the current version is 1.0.0
        if ($currentVersion == '1.0.0') {
            // Execute SQL statements for updating to version 2.0.0
            $this->executeSQLFile($parent, 'sql/update_1_0_0_to_2_0_0.sql');
        }
      */
      $this->executeSQLFile($parent, 'sql/update.sql');
    }

    private function executeSQLFile($parent, $filePath) {
        $db = Factory::getDbo();

        // Read the SQL file
        $sql = file_get_contents($parent->getPath('source') . '/' . $filePath);

        // Execute each query in the file
        foreach (explode(';', $sql) as $query) {
            if (!empty(trim($query))) {
                $db->setQuery($query);
                $db->execute();
            }
        }
    }
}
