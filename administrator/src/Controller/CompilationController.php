<?php
/**
 * @package     com_appsconda
 * @version     1.0.0
 * @copyright   Copyright (C) 2023. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author     AppsConda ApS <support@appsconda.com> - https://appsconda.com
 */

namespace Joomla\Component\Appsconda\Administrator\Controller;

// No direct access
defined('_JEXEC') or die;

use Joomla\CMS\MVC\Controller\FormController;
use Joomla\CMS\Factory;
use Joomla\CMS\Http\HttpFactory;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Mail\Mail;

/**
 * Appsconda detail controller
 */
class CompilationController extends FormController {
	protected $view_list = 'compilations';

	public function compile() {

		$app = Factory::getApplication();
		$db = Factory::getDbo();
		// Get the JInput object to access the POST data
		$jinput = \Joomla\CMS\Factory::getApplication()->input;
		$data = $jinput->get( 'jform', array(), 'array' ); // Assuming the form uses 'jform'

		// Get the model
		$model = $this->getModel( 'Compilation' ); // Replace 'YourModelName' with the appropriate model name

		// Save the record
		if ( $model->save( $data ) ) {

			$compilationId = $model->getState( $model->getName() . '.id' );
			$item = $model->getItem( $compilationId );
			$appicon = $item->appicon;
			$packagename = $item->packagename;
			$appname = $item->appname;
			$entrypage = $item->entrypage;
			$splashimage = $item->splashimage;
			$splashbg = $item->splashbackground;

			// Extract the actual image path
			$relativeImagePath = strtok( $appicon, '#' );

			// Combine base URI with relative image path to get the absolute URL
			$imageUrlappicon = Uri::root() . $relativeImagePath;

			// Convert URL to server path
			$baseServerPath = JPATH_ROOT . "/";
			$imageServerPath = str_replace( Uri::root(), $baseServerPath, $imageUrlappicon );

			if ( file_exists( $imageServerPath ) ) {
				// Use getimagesize with the imageUrl since it can handle URLs
				list( $width, $height, $type, $attr ) = getimagesize( $imageUrlappicon );

				echo "Image width: " . $width . " pixels<br>";
				echo "Image height: " . $height . " pixels<br>";
				echo "Image type: " . $type . "<br>";
				echo "Attributes: " . $attr . "<br>";
				if ( $width != 512 || $height != 512 ) {
					$this->setRedirect( 'index.php?option=com_appsconda&view=compilation&layout=edit&id=' . $compilationId, false );
					$app->enqueueMessage( Text::_( 'IMAGE_SIZE_APPICON_NOT_MEETS_REQUIREMENTS_COULD_NOT_SEND_FOR_COMPILATION' ), 'error' );
					return;
				}
			} else {
				$this->setRedirect( 'index.php?option=com_appsconda&view=compilation&layout=edit&id=' . $compilationId, false );
				$app->enqueueMessage( Text::_( 'IMAGE_SIZE_APPICON_NOT_MEETS_REQUIREMENTS_COULD_NOT_SEND_FOR_COMPILATION' ), 'error' );
				return;
			}
			
			$splashimage = $item->splashimage;

			// Extract the actual image path
			$relativeImagePath = strtok( $splashimage, '#' );

			// Combine base URI with relative image path to get the absolute URL
			$imageUrlsplashimage = Uri::root() . $relativeImagePath;

			// Convert URL to server path
			$baseServerPath = JPATH_ROOT . "/";
			$imageServerPath = str_replace( Uri::root(), $baseServerPath, $imageUrlsplashimage );

			if ( file_exists( $imageServerPath ) ) {
				// Use getimagesize with the imageUrl since it can handle URLs
				list( $width, $height, $type, $attr ) = getimagesize( $imageUrlsplashimage );

				echo "Image width: " . $width . " pixels<br>";
				echo "Image height: " . $height . " pixels<br>";
				echo "Image type: " . $type . "<br>";
				echo "Attributes: " . $attr . "<br>";
				if ( $width != 512 || $height != 512 ) {
					$this->setRedirect( 'index.php?option=com_appsconda&view=compilation&layout=edit&id=' . $compilationId, false );
					$app->enqueueMessage( Text::_( 'IMAGE_SIZE_SPLASH_NOT_MEETS_REQUIREMENTS_COULD_NOT_SEND_FOR_COMPILATION' ), 'error' );
					return;
				}
			} else {
				$this->setRedirect( 'index.php?option=com_appsconda&view=compilation&layout=edit&id=' . $compilationId, false );
				$app->enqueueMessage( Text::_( 'IMAGE_SIZE_SPLASH_NOT_MEETS_REQUIREMENTS_COULD_NOT_SEND_FOR_COMPILATION' ), 'error' );
				return;
			}
			
			

    // Create the SQL query to update the sentforcompile column where id = 1
    $query = $db->getQuery(true);
    $query->update($db->quoteName('#__appsconda_compilations'))
          ->set($db->quoteName('sentforcompile') . ' = 1')
          ->where($db->quoteName('id') . ' = ' . $compilationId);

    // Set and execute the query
    $db->setQuery($query);
    
    try {
        $db->execute();
        
        // Get an instance of Joomla's HTTP client
    $http = HttpFactory::getHttp();

// The URL you want to post to
$url = 'https://appsconda.com/index.php?option=com_appscompile&view=api&task=api.compileapp';

// Get the current URI instance
$uri = Uri::getInstance();
// Get the host (domain part) of the URL
$domain = $uri->getHost();

// Your POST data
$data = array(
    'appname'    => $appname,
    'appdomain'    => $domain,
    'packagename'  => $packagename,
    'entrypage'       => $entrypage,
    'appicon'  => $imageUrlappicon,
    'splashimage'         => $imageUrlsplashimage,
    'splashbg'  => $splashbg
);

$jsonData = json_encode($data);
$http = HttpFactory::getHttp();
$headers = array('Content-Type' => 'application/json');
$response = $http->post('https://appsconda.com/index.php?option=com_appscompile&view=api&task=api.compileapp', $jsonData, $headers);


// Decode the response
$responseData = json_decode($response->body);

// Output the response (You can process it further if needed)
if ($responseData->status == 'success') {
    $app->enqueueMessage( Text::_( 'APP_SENT_FOR_COMPILATION' ), 'message' );
} else {
    // Handle error
    $app->enqueueMessage( Text::_( 'APP_NOT_SENT_FOR_COMPILATION' ), 'error' );
}

        
        
    } catch (RuntimeException $e) {
		$app->enqueueMessage( Text::_( 'APP_NOT_SENT_FOR_COMPILATION' ) . $e->getMessage(), 'error' );
        //echo 'Failed to update sentforcompile: ' . $e->getMessage();
    }
    // Email successfully sent
    // Your PHP code goes here
    
} 
		else {
			// Handle the error in saving the record if needed
			$app->enqueueMessage( Text::_( 'COULD_NOT_SAVE_JOOMLA_ISSUE_LIKELY' ), 'error' );

		}
		//$recordId = $model->getState($model->getName() . '.id');
		$this->setRedirect( 'index.php?option=com_appsconda&view=compilation&layout=edit&id=1', false );

	}
}
