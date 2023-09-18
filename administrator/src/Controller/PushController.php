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
use Joomla\CMS\Language\Text;
use Joomla\CMS\Uri\Uri;

/**
 * Appsconda detail controller
 */
class PushController extends FormController
{
	protected $view_list = 'pushs';
	
	public function saveandsend() {
	
	$app = Factory::getApplication();
	$db = Factory::getDbo();
	 // Get the JInput object to access the POST data
    $jinput = \Joomla\CMS\Factory::getApplication()->input;
    $data = $jinput->get('jform', array(), 'array');  // Assuming the form uses 'jform'

    // Get the model
    $model = $this->getModel('Push');  // Replace 'YourModelName' with the appropriate model name

    // Save the record
    if ($model->save($data))
    {
		
		$query = $db->getQuery( true )->select( 'DISTINCT devicetoken' )->from( $db->quoteName( '#__appsconda_mobiledevices' ) );

		$db->setQuery( $query );
		$uniqueTokens = $db->loadColumn();

		$notificationId = $model->getState( $model->getName() . '.id' );
		$item = $model->getItem( $notificationId );
		$title = $item->title;
		$body = $item->message;
		$image = $item->image;
		$baseURL = rtrim( Uri::root(), '/' );
		$baseURL = str_replace( '/administrator', '', $baseURL );
		$imageurl = $baseURL . '/' . $image;
		$parsedUrl = parse_url( $imageurl );
		$cleanimageurl = $parsedUrl[ 'scheme' ] . '://' . $parsedUrl[ 'host' ] . $parsedUrl[ 'path' ];
		
		$sendDate = $item->send_date;
		$createdBy = 0; // assuming system or unknown creator
		$state = 1; // default state
		$ordering = 0; // default ordering

		foreach ( $uniqueTokens as $token ) {
			$query = $db->getQuery( true );

			$columns = [ 'notification_id', 'title', 'body', 'image', 'token', 'send_date', 'created_by', 'state', 'ordering' ];
			$values = [
				$db->quote( $notificationId ),
				$db->quote( $title ),
				$db->quote( $body ),
				$db->quote( $cleanimageurl ),
				$db->quote( $token ),
				$db->quote( $sendDate ),
				$createdBy,
				$state,
				$ordering
			];

			$query
				->insert( $db->quoteName( '#__appsconda_notificationqueues' ) )->columns( $db->quoteName( $columns ) )->values( implode( ',', $values ) );

			try {
				$db->setQuery( $query );
				$db->execute();
				$app->enqueueMessage(Text::_('PUSH_SENT_TO_QUEUE_SUCCESSFULLY'), 'message');
			} catch ( Exception $e ) {
				$app->enqueueMessage(Text::_('PUSH_NOT_SENT_TO_QUEUE'). ': ' . $e->getMessage(), 'error');
				continue;
			}
		}
		
    }
    else
    {
        // Handle the error in saving the record if needed
        $app->enqueueMessage(Text::_('COULD_NOT_SAVE_JOOMLA_ISSUE_LIKELY'), 'error');
       
    }
    //$recordId = $model->getState($model->getName() . '.id');
    $this->setRedirect('index.php?option=com_appsconda&view=pushs', false);

	}
}
