<?php
/**
 * @package     com_appsconda
 * @version     1.0.0
 * @copyright   Copyright (C) 2023. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author     AppsConda ApS <support@appsconda.com> - https://appsconda.com
 */

// No direct access
defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Session\Session;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\Http\HttpFactory;
use Joomla\CMS\Language\Text;
?>

<?php

$show_allinfo = false;

$db = Factory::getDbo();

$query = $db->getQuery(true)
            ->select($db->quoteName('packagename'))
            ->from($db->quoteName('#__appsconda_compilations'))
            ->where($db->quoteName('id') . ' = 1');;

$db->setQuery($query);

$packagename = $db->loadResult();

if (!empty($packagename)) {

// Prepare the URL
        $url = "https://appsconda.com/index.php?option=com_appscompile&view=api&task=api.compilestatus&package=" . $packagename;

        // Get an instance of Joomla's HTTP client
        $http = HttpFactory::getHttp();
        
        try {
            $response = $http->get($url);
            
            // Decode the response body
            $result = json_decode($response->body, true);
            
            if ($response->code === 200 && $result['success'] == true) {
                
                
                
                if (!empty($result['result']['downloadurl'])) {
                    $show_allinfo = true;
                } else {
                // Display error message
                echo "<div style='background: #fef8f8;color: #c52827;padding: 10px;margin-bottom: 30px;border: 1px solid #c52827;'>";
				echo "<div><b><u>Next steps to publish your mobile app on Playstore and Appstore:</u></b></div>";
				echo "<div class='error'><br>Information about publishing your app will be visible here once your app has been compiled.</div>";
				echo "</div>";
            }
                
            } else {
                // Display error message
                echo "<div style='background: #fef8f8;color: #c52827;padding: 10px;margin-bottom: 30px;border: 1px solid #c52827;'>";
				echo "<div><b><u>Next steps to publish your mobile app on Playstore and Appstore:</u></b></div>";
				echo "<div class='error'><br>Information about publishing your app will be visible here once your app has been compiled.</div>";
				echo "</div>";
            }
        } catch (Exception $e) {
            // Display error message
                echo "<div style='background: #fef8f8;color: #c52827;padding: 10px;margin-bottom: 30px;border: 1px solid #c52827;'>";
				echo "<div><b><u>Next steps to publish your mobile app on Playstore and Appstore:</u></b></div>";
				echo "<div class='error'><br>Information about publishing your app will be visible here once your app has been compiled.</div>";
				echo "</div>";
        }

}

 
  
  

?>

<?php if ($show_allinfo): ?>
  
  
    <style>
        .bodypublish {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            color: #333;
            line-height: 1.6;
            padding: 20px;
        }

        .content {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 40px auto;
        }

        h2 {
            color: #2c3e50;
            font-size: 24px;
            margin-bottom: 20px;
        }

        p {
            font-size: 18px;
            margin-bottom: 20px;
        }

        .highlight {
            color: #e74c3c;
            font-weight: bold;
        }
        .highlighturl {
            color: #e74c3c;
            font-weight: bold;
        }
    </style>

    <div class="bodypublish">
    <div class="content">
        <h2>Ready to Publish Your Mobile App?</h2>
        <p>
            Launching your mobile app on platforms like Google Playstore and Apple Appstore can seem daunting. The great news is that with the <a href="https://applaunchportal.com/" target="_blank"><span class="highlighturl">App Launch Portal</span></a> service, you can effortlessly get your mobile app out there.
        </p>
    </div>
    </div>

  
  
  
  <?php endif; ?>