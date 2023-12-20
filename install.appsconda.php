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
        $this->executeSQLFile($parent, '/administrator/sql/update.sql');
    }

    private function executeSQLFile($parent, $filePath) {
        $db = Factory::getDbo();

        // Construct the full path to the SQL file
        $fullPath = $parent->getParent()->getPath('source') . $filePath;

        // Read the SQL file
        $sql = file_get_contents($fullPath);

        // Execute each query in the file
        foreach (explode(';', $sql) as $query) {
            if (!empty(trim($query))) {
                $db->setQuery($query);
                $db->execute();
            }
        }
    }
}

