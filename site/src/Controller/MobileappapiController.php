<?php
/**
 * Backup before adding the redirect code in productdetailsapi function
 * @package     com_appsconda
 * @version     1.0.0
 * @copyright   Copyright (C) 2023. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      AppsConda ApS <support@appsconda.com> - https://appsconda.com
 */

namespace Joomla\Component\Appsconda\Site\Controller;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\Controller\FormController;

use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Table\Table;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\User\User;
use Joomla\CMS\Date\Date;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Mail\Mail;
use Joomla\CMS\Authentication\Authentication;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Http\HttpFactory;
use stdClass;
use Joomla\CMS\User\UserHelper;
use Joomla\CMS\Component\ComponentHelper;

/**
 * Appsconda detail controller
 */
class MobileappapiController extends FormController {

	function mobileappflutterloginapi() {

		$rawData = file_get_contents( 'php://input' );

		$jsonData = json_decode( $rawData, true );

		$username = isset( $jsonData[ 'username' ] ) ? $jsonData[ 'username' ] : '';
		$password = isset( $jsonData[ 'password' ] ) ? $jsonData[ 'password' ] : '';
		$deviceidlogin = isset( $jsonData[ 'deviceidlogin' ] ) ? $jsonData[ 'deviceidlogin' ] : '';

		$db = Factory::getDbo();
		$query = $db->getQuery( true )->select( 'id AS userid, name, username, email, password' )->from( '#__users' )->where( 'username=' . $db->quote( $username ) );
		$db->setQuery( $query );
		$result = $db->loadAssoc();

		if ( $result !== null ) {

			if ( password_verify( $password, $result[ 'password' ] ) ) {
				$userid = $result[ 'userid' ];
				$username = $result[ 'username' ];
				$name = $result[ 'name' ];
				$email = $result[ 'email' ];
				$passwordraw = bin2hex( random_bytes( 12 ) );
				$passwordhashed = hash( 'sha256', $passwordraw );

				$query = $db->getQuery( true );
				$query->select( 'deviceidlogin' )->from( '#__appsconda_mobileapplogins' )->where( 'deviceidlogin = ' . $db->quote( $deviceidlogin ) );
				$db->setQuery( $query );
				$existingDevice = $db->loadAssoc();

				if ( $existingDevice !== null ) {

					$query = $db->getQuery( true );
					$fields = array(
						$db->quoteName( 'username' ) . ' = ' . $db->quote( $username ),
						$db->quoteName( 'name' ) . ' = ' . $db->quote( $name ),
						$db->quoteName( 'email' ) . ' = ' . $db->quote( $email ),
						$db->quoteName( 'password' ) . ' = ' . $db->quote( $passwordhashed )
					);
					$conditions = array(
						$db->quoteName( 'deviceidlogin' ) . ' = ' . $db->quote( $deviceidlogin )
					);
					$query->update( $db->quoteName( '#__appsconda_mobileapplogins' ) )->set( $fields )->where( $conditions );
					$db->setQuery( $query );
					$db->execute();

				} else {

					$columns = array( 'userid', 'username', 'name', 'email', 'password', 'deviceidlogin' );
					$values = array( $db->quote( $userid ), $db->quote( $username ), $db->quote( $name ), $db->quote( $email ), $db->quote( $passwordhashed ), $db->quote( $deviceidlogin ) );
					$query = $db->getQuery( true );
					$query->insert( $db->quoteName( '#__appsconda_mobileapplogins' ) )->columns( $db->quoteName( $columns ) )->values( implode( ',', $values ) );
					$db->setQuery( $query );
					$db->execute();
				}

				$user = Factory::getUser( $userid );

				$db = Factory::getDbo();
				$query = $db->getQuery( true )->select( 'CAST(userid AS CHAR) AS userid, username, name, email, deviceidlogin' )->from( '#__appsconda_mobileapplogins' )->where( 'deviceidlogin=' . $db->quote( $deviceidlogin ) );
				$db->setQuery( $query );
				$jsonresult = $db->loadAssoc();
				$jsonresult[ 'password' ] = $passwordraw;
				http_response_code( 200 );
				$response = [ 'result' => 'success', 'user' => $jsonresult ];
				if ( $user->authorise( 'core.login.admin' ) ) {
					$response[ 'isAdmin' ] = true;
				} else {
					$response[ 'isAdmin' ] = false;
				}
			} else {
				http_response_code( 403 );
				$response = [ 'result' => Text::_( 'COM_APPSCONDA_MOBILE_INVALID_LOGIN_MESSAGE' ) ];
			}
		} else {
			http_response_code( 403 );
			$response = [ 'result' => Text::_( 'COM_APPSCONDA_MOBILE_INVALID_LOGIN_MESSAGE' ) ];
		}

		header( 'Content-Type: application/json' );
		echo json_encode( $response );
		Factory::getApplication()->close();

	}

	function mobileapppmiloginapi() {

		$rawData = file_get_contents( 'php://input' );

		$jsonData = json_decode( $rawData, true );

		$username = isset( $jsonData[ 'username' ] ) ? $jsonData[ 'username' ] : '';
		$password = isset( $jsonData[ 'password' ] ) ? $jsonData[ 'password' ] : '';
		$deviceidlogin = isset( $jsonData[ 'deviceidlogin' ] ) ? $jsonData[ 'deviceidlogin' ] : '';

		if ( empty( $username ) || empty( $password ) ) {
			http_response_code( 403 );
			$response = [ 'result' => 'error', 'message' => 'Empty username or password not allowed' ];
			header( 'Content-Type: application/json' );
			echo json_encode( $response );
			Factory::getApplication()->close();
			exit;
		}

		$db = Factory::getDbo();

		$db = Factory::getDbo();
		$query = $db->getQuery( true );
		$query->select( $db->quoteName( [ 'pmi_client_id', 'pmi_client_secret' ] ) )->from( $db->quoteName( '#__appsconda_mobileconfigs' ) )->where( $db->quoteName( 'id' ) . ' = 1' );
		$db->setQuery( $query );

		$row = $db->loadAssoc();
		$pmi_client_id = $row[ 'pmi_client_id' ];
		$pmi_client_secret = $row[ 'pmi_client_secret' ];

		$tokenUrl = "https://idp.candidate.pmi.org/connect/token";
		$data = [
			'grant_type' => 'password',
			'username' => $username,
			'password' => $password,
			'client_id' => $pmi_client_id,
			'client_secret' => $pmi_client_secret,
			'scope' => 'openid',
		];

		$http = HttpFactory::getHttp();
		try {
			$response = $http->post( $tokenUrl, $data );

			if ( $response->code == 200 ) {
				$body = json_decode( $response->body, true );
				if ( isset( $body[ 'access_token' ] ) ) {
					$accesstoken = $body[ 'access_token' ];

				} else {
					http_response_code( 403 );
					$response = [ 'result' => 'error', 'message' => 'Access token not found in the response.' ];
					header( 'Content-Type: application/json' );
					echo json_encode( $response );
					Factory::getApplication()->close();

				}
			} else {
				http_response_code( 403 );
				$response = [ 'result' => 'error', 'message' => 'Errro Code: ' . $response->code ];
				header( 'Content-Type: application/json' );
				echo json_encode( $response );
				Factory::getApplication()->close();

			}

		} catch ( \Exception $e ) {

			http_response_code( 403 );
			$response = [ 'result' => 'error', 'message' => $e->getMessage() ];
			header( 'Content-Type: application/json' );
			echo json_encode( $response );
			Factory::getApplication()->close();
		}

		$url = "https://idp.candidate.pmi.org/connect/userinfo";
		$http = HttpFactory::getHttp();

		$headers = [
			'Authorization' => 'Bearer ' . $accesstoken,
			'Content-Type' => 'application/json',
		];

		try {
			$response = $http->get( $url, $headers );

			if ( $response->code == 200 ) {
				$body = json_decode( $response->body, true );
				if ( isset( $body[ 'id' ] ) ) {
					$pmiid = $body[ 'id' ];

				} else {
					http_response_code( 403 );
					$response = [ 'result' => 'error', 'message' => 'PMI ID not found in the response.' ];
					header( 'Content-Type: application/json' );
					echo json_encode( $response );
					Factory::getApplication()->close();
				}
			} else {
				http_response_code( 403 );
				$response = [ 'result' => 'error', 'message' => 'Errro Code: ' . $response->code ];
				header( 'Content-Type: application/json' );
				echo json_encode( $response );
				Factory::getApplication()->close();
			}
		} catch ( \Exception $e ) {

			http_response_code( 403 );
			$response = [ 'result' => 'error', 'message' => $e->getMessage() ];
			header( 'Content-Type: application/json' );
			echo json_encode( $response );
			Factory::getApplication()->close();

		}

		$query = $db->getQuery( true );
		$query->select( $db->quoteName( 'u.id' ) )->from( $db->quoteName( '#__comprofiler', 'c' ) )->join( 'INNER', $db->quoteName( '#__users', 'u' ) . ' ON (' . $db->quoteName( 'c.user_id' ) . ' = ' . $db->quoteName( 'u.id' ) . ')' )->where( $db->quoteName( 'c.cb_dep_depid' ) . ' = ' . $db->quote( ( int )$pmiid ) )->where( $db->quoteName( 'u.block' ) . ' = 0' );

		$db->setQuery( $query );
		$userid = $db->loadResult();
		if ( $userid ) {

			$query = $db->getQuery( true )->select( 'id AS userid, name, username, email, password' )->from( '#__users' )->where( 'id=' . $db->quote( $userid ) );
			$db->setQuery( $query );
			$result = $db->loadAssoc();

			if ( $result !== null ) {
				$userid = $result[ 'userid' ];
				$username = $result[ 'username' ];
				$name = $result[ 'name' ];
				$email = $result[ 'email' ];
				$passwordraw = bin2hex( random_bytes( 12 ) );
				$passwordhashed = hash( 'sha256', $passwordraw );

				$query = $db->getQuery( true );
				$query->select( 'deviceidlogin' )->from( '#__appsconda_mobileapplogins' )->where( 'deviceidlogin = ' . $db->quote( $deviceidlogin ) );
				$db->setQuery( $query );
				$existingDevice = $db->loadAssoc();

				if ( $existingDevice !== null ) {

					$query = $db->getQuery( true );
					$fields = array(
						$db->quoteName( 'username' ) . ' = ' . $db->quote( $username ),
						$db->quoteName( 'name' ) . ' = ' . $db->quote( $name ),
						$db->quoteName( 'email' ) . ' = ' . $db->quote( $email ),
						$db->quoteName( 'password' ) . ' = ' . $db->quote( $passwordhashed )
					);
					$conditions = array(
						$db->quoteName( 'deviceidlogin' ) . ' = ' . $db->quote( $deviceidlogin )
					);
					$query->update( $db->quoteName( '#__appsconda_mobileapplogins' ) )->set( $fields )->where( $conditions );
					$db->setQuery( $query );
					$db->execute();

				} else {

					$columns = array( 'userid', 'username', 'name', 'email', 'password', 'deviceidlogin' );
					$values = array( $db->quote( $userid ), $db->quote( $username ), $db->quote( $name ), $db->quote( $email ), $db->quote( $passwordhashed ), $db->quote( $deviceidlogin ) );
					$query = $db->getQuery( true );
					$query->insert( $db->quoteName( '#__appsconda_mobileapplogins' ) )->columns( $db->quoteName( $columns ) )->values( implode( ',', $values ) );
					$db->setQuery( $query );
					$db->execute();

				}

				$user = Factory::getUser( $userid );

				$db = Factory::getDbo();
				$query = $db->getQuery( true )->select( 'CAST(userid AS CHAR) AS userid, username, name, email, deviceidlogin' )->from( '#__appsconda_mobileapplogins' )->where( 'deviceidlogin=' . $db->quote( $deviceidlogin ) );
				$db->setQuery( $query );
				$jsonresult = $db->loadAssoc();
				$jsonresult[ 'password' ] = $passwordraw;
				http_response_code( 200 );
				$response = [ 'result' => 'success', 'user' => $jsonresult ];
				if ( $user->authorise( 'core.login.admin' ) ) {
					$response[ 'isAdmin' ] = true;
				} else {
					$response[ 'isAdmin' ] = false;
				}
				header( 'Content-Type: application/json' );
				echo json_encode( $response );
				Factory::getApplication()->close();
			} else {
				http_response_code( 403 );
				$response = [ 'result' => 'error', 'message' => 'We could not confirm your membership to this chapter.' ];
				header( 'Content-Type: application/json' );
				echo json_encode( $response );
				Factory::getApplication()->close();
			}

		} else {
			http_response_code( 403 );
			$response = [ 'result' => 'error', 'message' => 'We could not confirm your membership to this chapter.' ];
			header( 'Content-Type: application/json' );
			echo json_encode( $response );
			Factory::getApplication()->close();
		}

	}

	function mobileappflutterloginapi_beforesecurelogin() {

		$rawData = file_get_contents( 'php://input' );

		$jsonData = json_decode( $rawData, true );

		$username = isset( $jsonData[ 'username' ] ) ? $jsonData[ 'username' ] : '';
		$password = isset( $jsonData[ 'password' ] ) ? $jsonData[ 'password' ] : '';

		$db = Factory::getDbo();
		$query = $db->getQuery( true )->select( 'id AS userid, name, username, email, password' )->from( '#__users' )->where( 'username=' . $db->quote( $username ) );
		$db->setQuery( $query );
		$result = $db->loadAssoc();

		if ( $result !== null ) {

			if ( password_verify( $password, $result[ 'password' ] ) ) {
				$userid = $result[ 'userid' ];
				$username = $result[ 'username' ];
				$name = $result[ 'name' ];
				$email = $result[ 'email' ];
				$password = bin2hex( random_bytes( 12 ) );

				$query = $db->getQuery( true );
				$query->select( '*' )->from( '#__appsconda_mobileapplogins' )->where( 'userid = ' . $db->quote( $userid ) );
				$db->setQuery( $query );
				$existingRecord = $db->loadAssoc();

				if ( $existingRecord !== null ) {

					$query = $db->getQuery( true );
					$fields = array(
						$db->quoteName( 'username' ) . ' = ' . $db->quote( $username ),
						$db->quoteName( 'name' ) . ' = ' . $db->quote( $name ),
						$db->quoteName( 'email' ) . ' = ' . $db->quote( $email )

					);
					$conditions = array(
						$db->quoteName( 'userid' ) . ' = ' . $db->quote( $userid )
					);
					$query->update( $db->quoteName( '#__appsconda_mobileapplogins' ) )->set( $fields )->where( $conditions );
					$db->setQuery( $query );
					$db->execute();
				} else {

					$columns = array( 'userid', 'username', 'name', 'email', 'password' );
					$values = array( $db->quote( $userid ), $db->quote( $username ), $db->quote( $username ), $db->quote( $email ), $db->quote( $password ) );
					$query = $db->getQuery( true );
					$query->insert( $db->quoteName( '#__appsconda_mobileapplogins' ) )->columns( $db->quoteName( $columns ) )->values( implode( ',', $values ) );
					$db->setQuery( $query );
					$db->execute();
				}

				$user = Factory::getUser( $userid );

				$db = Factory::getDbo();
				$query = $db->getQuery( true )->select( 'CAST(userid AS CHAR) AS userid, username, name, email, password' )->from( '#__appsconda_mobileapplogins' )->where( 'username=' . $db->quote( $username ) );
				$db->setQuery( $query );
				$jsonresult = $db->loadAssoc();
				http_response_code( 200 );
				$response = [ 'result' => 'success', 'user' => $jsonresult ];
				if ( $user->authorise( 'core.login.admin' ) ) {
					$response[ 'isAdmin' ] = true;
				} else {
					$response[ 'isAdmin' ] = false;
				}
			} else {
				http_response_code( 403 );
				$response = [ 'result' => Text::_( 'COM_APPSCONDA_MOBILE_INVALID_LOGIN_MESSAGE' ) ];
			}
		} else {
			http_response_code( 403 );
			$response = [ 'result' => Text::_( 'COM_APPSCONDA_MOBILE_INVALID_LOGIN_MESSAGE' ) ];
		}

		header( 'Content-Type: application/json' );
		echo json_encode( $response );
		Factory::getApplication()->close();

	}

	function mobileappticketcreate() {

		$rawData = file_get_contents( "php://input" );
		$data = json_decode( $rawData, true );
		$userid = isset( $data[ 'userid' ] ) ? $data[ 'userid' ] : null;
		$passwordraw = isset( $data[ 'password' ] ) ? $data[ 'password' ] : null;
		$deviceidlogin = isset( $data[ 'deviceidlogin' ] ) ? $data[ 'deviceidlogin' ] : null;
		$name = isset( $data[ 'name' ] ) ? $data[ 'name' ] : null;
		$email = isset( $data[ 'email' ] ) ? $data[ 'email' ] : null;
		$subject = isset( $data[ 'subject' ] ) ? $data[ 'subject' ] : null;
		$message = isset( $data[ 'message' ] ) ? $data[ 'message' ] : null;
		$db = Factory::getDbo();

		if ( !empty( $passwordraw ) && !empty( $userid ) && !empty( $deviceidlogin ) ) {

			$options = array( 'remember' => true );
			$credentials[ 'userid' ] = $userid;
			$credentials[ 'password' ] = $passwordraw;
			$credentials[ 'deviceidlogin' ] = $deviceidlogin;
			$result = Factory::getApplication()->login( $credentials, $options );

			if ( $result ) {

				$query = $db->getQuery( true )->select( $db->quoteName( [ 'supportcatid', 'supportpriorityid', 'supportstatusid' ] ) )->from( $db->quoteName( '#__appsconda_drawermenus' ) );
				$db->setQuery( $query );
				$supportresults = $db->loadObjectList();

				$date = Factory::getDate()->toSql();
				$categoryid = $supportresults[ 0 ]->supportcatid;
				$priorityid = $supportresults[ 0 ]->supportpriorityid;
				$statusid = $supportresults[ 0 ]->supportstatusid;
				$ticketcode = substr( str_shuffle( 'abcdefghijklmnopqrstuvwxyz0123456789' ), 0, 10 );
				$query = $db->getQuery( true );
				$data = array(
					$db->quote( $categoryid ),
					$db->quote( $userid ),
					$db->quote( $name ),
					$db->quote( $email ),
					$db->quote( $subject ),
					$db->quote( '127.0.0.1' ),
					$db->quote( $message ),
					'NULL',
					'NULL',
					$db->quote( $ticketcode ),
					$db->quote( $date ),
					$db->quote( $date ),
					$db->quote( $priorityid ),
					$db->quote( $statusid ),
					$db->quote( 0 ),
					$db->quote( 0 ),
					$db->quote( 0 ),
					$db->quote( $userid ),
					$db->quote( 'en-GB' )
				);

				$columns = array(
					'category_id',
					'user_id',
					'name',
					'email',
					'subject',
					'user_ip',
					'message',
					'attachments',
					'original_filenames',
					'ticket_code',
					'created_date',
					'modified_date',
					'priority_id',
					'status_id',
					'rating',
					'label_id',
					'staff_id',
					'last_reyply_user_id',
					'language'
				);

				$query
					->insert( $db->quoteName( '#__helpdeskpro_tickets' ) )->columns( $db->quoteName( $columns ) )->values( implode( ',', $data ) );

				$db->setQuery( $query );

				$db->execute();

				if ( $db->getAffectedRows() > 0 ) {
					$ticketcreateresponse = array(
						'result' => 'success',
						'message' => Text::_( 'COM_APPSCONDA_MOBILE_TICKET_CREATED_SUCCESSFULLY' )
					);

					header( 'Content-Type: application/json' );
					http_response_code( 200 );

					echo json_encode( $ticketcreateresponse );

					jexit();
				} else {

					$ticketcreateresponse = array(
						'result' => 'error',
						'message' => Text::_( 'COM_APPSCONDA_MOBILE_TICKET_NOT_CREATED' )
					);
					header( 'Content-Type: application/json' );
					http_response_code( 403 );

					echo json_encode( $ticketcreateresponse );

					jexit();
				}

			} else {
				http_response_code( 403 );
				$result = array(
					'result' => 'error',
					'message' => Text::_( 'COM_APPSCONDA_MOBILE_EVENT_USER_AUTH_FAILED' )
				);
				echo json_encode( $result );
			}
		} else {
			http_response_code( 403 );
			$result = array(
				'result' => 'error',
				'message' => Text::_( 'COM_APPSCONDA_MOBILE_EVENT_USER_AUTH_FAILED' )
			);
			echo json_encode( $result );
		}
	}

	function mobileappticketreply() {

		$rawData = file_get_contents( "php://input" );
		$data = json_decode( $rawData, true );
		$userid = isset( $data[ 'userid' ] ) ? $data[ 'userid' ] : null;
		$passwordraw = isset( $data[ 'password' ] ) ? $data[ 'password' ] : null;
		$deviceidlogin = isset( $data[ 'deviceidlogin' ] ) ? $data[ 'deviceidlogin' ] : null;
		$message = isset( $data[ 'message' ] ) ? $data[ 'message' ] : null;
		$ticketid = isset( $data[ 'ticketid' ] ) ? $data[ 'ticketid' ] : null;
		$db = Factory::getDbo();

		if ( !empty( $passwordraw ) && !empty( $userid ) && !empty( $deviceidlogin ) ) {

			$options = array( 'remember' => true );
			$credentials[ 'userid' ] = $userid;
			$credentials[ 'password' ] = $passwordraw;
			$credentials[ 'deviceidlogin' ] = $deviceidlogin;
			$result = Factory::getApplication()->login( $credentials, $options );

			if ( $result ) {

				$date = Factory::getDate()->toSql();
				$query = $db->getQuery( true );
				$data = array(
					$db->quote( $ticketid ),
					$db->quote( $userid ),
					$db->quote( 0 ),
					$db->quote( $date ),
					$db->quote( $message ),
					'NULL',
					'NULL'
				);

				$columns = array(
					'ticket_id',
					'user_id',
					'internal',
					'date_added',
					'message',
					'attachments',
					'original_filenames'
				);

				$query
					->insert( $db->quoteName( '#__helpdeskpro_messages' ) )->columns( $db->quoteName( $columns ) )->values( implode( ',', $data ) );

				$db->setQuery( $query );

				$db->execute();

				if ( $db->getAffectedRows() > 0 ) {
					$ticketcreateresponse = array(
						'result' => 'success',
						'message' => Text::_( 'COM_APPSCONDA_MOBILE_REPLY_ADDED' )
					);

					header( 'Content-Type: application/json' );
					http_response_code( 200 );

					echo json_encode( $ticketcreateresponse );

					jexit();
				} else {

					$ticketcreateresponse = array(
						'result' => 'error',
						'message' => Text::_( 'COM_APPSCONDA_MOBILE_REPLY_NO_ADDED' )
					);
					header( 'Content-Type: application/json' );
					http_response_code( 403 );

					echo json_encode( $ticketcreateresponse );

					jexit();
				}

			} else {
				http_response_code( 403 );
				$result = array(
					'result' => 'error',
					'message' => Text::_( 'COM_APPSCONDA_MOBILE_EVENT_USER_AUTH_FAILED' )
				);
				echo json_encode( $result );
			}
		} else {
			http_response_code( 403 );
			$result = array(
				'result' => 'error',
				'message' => Text::_( 'COM_APPSCONDA_MOBILE_EVENT_USER_AUTH_FAILED' )
			);
			echo json_encode( $result );
		}
	}

	function mobileappuserupdate() {

		$rawData = file_get_contents( "php://input" );
		$data = json_decode( $rawData, true );
		$userid = isset( $data[ 'userid' ] ) ? $data[ 'userid' ] : null;
		$passwordraw = isset( $data[ 'password' ] ) ? $data[ 'password' ] : null;
		$deviceidlogin = isset( $data[ 'deviceidlogin' ] ) ? $data[ 'deviceidlogin' ] : null;
		$newUsername = isset( $data[ 'newusername' ] ) ? $data[ 'newusername' ] : null;
		$newName = isset( $data[ 'newname' ] ) ? $data[ 'newname' ] : null;
		$newEmail = isset( $data[ 'newemail' ] ) ? $data[ 'newemail' ] : null;
		$newPassword = isset( $data[ 'newpassword' ] ) ? $data[ 'newpassword' ] : null;
		$newPasswordConfirm = isset( $data[ 'passwordconfirm' ] ) ? $data[ 'passwordconfirm' ] : null;
		$db = Factory::getDbo();
		$user = Factory::getUser( $userid );

		if ( $newPassword != $newPasswordConfirm ) {
			http_response_code( 403 );
			$result = array(
				'result' => 'error',
				'message' => Text::_( 'COM_APPSCONDA_MOBILE_PASSWORDS_NO_MATCH' )
			);
			echo json_encode( $result );
			jexit();
		}

		if ( $user->authorise( 'core.login.admin' ) ) {
			http_response_code( 403 );
			$result = array(
				'result' => 'error',
				'message' => Text::_( 'COM_APPSCONDA_MOBILE_ADMINS_NOT_CHANGE_PROFILE' )
			);
			echo json_encode( $result );
			jexit();
		}

		if ( !empty( $passwordraw ) && !empty( $userid ) && !empty( $deviceidlogin ) ) {

			$options = array( 'remember' => true );
			$credentials[ 'userid' ] = $userid;
			$credentials[ 'password' ] = $passwordraw;
			$credentials[ 'deviceidlogin' ] = $deviceidlogin;
			$result = Factory::getApplication()->login( $credentials, $options );

			if ( $result ) {

				if ( !empty( $newUsername ) ) {
					$user->username = $newUsername;
				}
				if ( !empty( $newName ) ) {
					$user->name = $newName;
				}
				if ( !empty( $newEmail ) ) {
					$user->email = $newEmail;
				}
				if ( !empty( $newPassword ) ) {
					$hashedpassword = UserHelper::hashPassword( $newPassword );
					$user->set( 'password', $hashedpassword );
				}

				$user->save();

				header( 'Content-Type: application/json' );

				if ( $user->save() ) {
					http_response_code( 200 );
					$result = array(
						'result' => 'success',
						'message' => Text::_( 'COM_APPSCONDA_MOBILE_PROFILE_UPDATED' ),
						'newName' => $user->name,
						'newUsername' => $user->username,
						'newEmail' => $user->email
					);
					echo json_encode( $result );
				} else {
					$errorMessage = $user->getError();
					http_response_code( 403 );
					$result = array(
						'result' => 'error',
						'message' => $errorMessage
					);
					echo json_encode( $result );
				}

				jexit();
			} else {
				http_response_code( 403 );
				$result = array(
					'result' => 'error',
					'message' => Text::_( 'COM_APPSCONDA_MOBILE_EVENT_USER_AUTH_FAILED' )
				);
				echo json_encode( $result );
			}

		} else {
			http_response_code( 403 );
			$result = array(
				'result' => 'error',
				'message' => Text::_( 'COM_APPSCONDA_MOBILE_EVENT_USER_AUTH_FAILED' )
			);
			echo json_encode( $result );
			jexit();
		}
	}

	function mobileappselfcheckin() {

		function calculateDistance( $lat1, $lon1, $lat2, $lon2 ) {
			$earthRadius = 6371000;

			$lat1 = deg2rad( $lat1 );
			$lon1 = deg2rad( $lon1 );
			$lat2 = deg2rad( $lat2 );
			$lon2 = deg2rad( $lon2 );

			$deltaLat = $lat2 - $lat1;
			$deltaLon = $lon2 - $lon1;

			$a = sin( $deltaLat / 2 ) * sin( $deltaLat / 2 ) +
				cos( $lat1 ) * cos( $lat2 ) *
				sin( $deltaLon / 2 ) * sin( $deltaLon / 2 );

			$c = 2 * atan2( sqrt( $a ), sqrt( 1 - $a ) );

			$distance = $earthRadius * $c;

			return $distance;
		}
		$db = Factory::getDbo();
		$offset = Factory::getConfig()->get( 'offset' );
		$timezone = Factory::getUser()->getTimezone();

		$radiusquery = $db->getQuery( true )->select( $db->quoteName( 'selfcheckinradius' ) )->from( $db->quoteName( '#__appsconda_mobileconfigs' ) );
		$db->setQuery( $radiusquery );
		$radiusinmeters = $db->loadResult();
		$radiusinmetersint = intval( $radiusinmeters );

		$rawData = file_get_contents( 'php://input' );

		$jsonData = json_decode( $rawData, true );

		$userid = isset( $jsonData[ 'userid' ] ) ? intval( $jsonData[ 'userid' ] ) : null;
		$passwordraw = isset( $jsonData[ 'password' ] ) ? $jsonData[ 'password' ] : null;
		$deviceidlogin = isset( $jsonData[ 'deviceidlogin' ] ) ? $jsonData[ 'deviceidlogin' ] : null;
		$devicetimeunix = isset( $jsonData[ 'devicetimeunix' ] ) ? $jsonData[ 'devicetimeunix' ] : null;
		$registrationid = isset( $jsonData[ 'registrationid' ] ) ? $jsonData[ 'registrationid' ] : null;
		$eventid = isset( $jsonData[ 'eventid' ] ) ? $jsonData[ 'eventid' ] : null;
		$devicelocation = isset( $jsonData[ 'devicelocation' ] ) ? $jsonData[ 'devicelocation' ] : null;

		/*
		$response = array(
		  'result' => "success",
		  'message' => $devicetimeunix
		);
		header('Content-Type: application/json');
		http_response_code(200);
		echo json_encode($response);
		jexit();

		*/

		$query = $db->getQuery( true )->select( 'r.lat, r.long' )->from( $db->quoteName( '#__eb_locations', 'r' ) )->leftJoin( $db->quoteName( '#__eb_events', 'e' ) . ' ON ' . $db->quoteName( 'e.location_id' ) . ' = ' . $db->quoteName( 'r.id' ) )->where( $db->quoteName( 'e.id' ) . ' = ' . $db->quote( $eventid ) );
		$db->setQuery( $query );
		$eventlatlong = $db->loadAssoc();

		$query = $db->getQuery( true )->select( 'event_date' )->from( $db->quoteName( '#__eb_events' ) )->where( $db->quoteName( 'id' ) . ' = ' . $db->quote( $eventid ) );
		$db->setQuery( $query );
		$eventstartdate = $db->loadResult();
		$neweventstartdate = new Date( $eventstartdate, $offset );
		$neweventstartdate->setTimezone( $timezone );
		$eventstartdateunix = $neweventstartdate->toUnix();

		$query = $db->getQuery( true )->select( 'event_end_date' )->from( $db->quoteName( '#__eb_events' ) )->where( $db->quoteName( 'id' ) . ' = ' . $db->quote( $eventid ) );
		$db->setQuery( $query );
		$eventenddate = $db->loadResult();

		$neweventenddate = new Date( $eventenddate, $offset );
		$neweventenddate->setTimezone( $timezone );
		$eventenddateunix = $neweventenddate->toUnix();

		preg_match( '/LatLng\(lat: (.*), lng: (.*)\)/', $devicelocation, $matches );
		$deviceLat = $matches[ 1 ];
		$deviceLng = $matches[ 2 ];

		$distance = calculateDistance(
			floatval( $eventlatlong[ "lat" ] ),
			floatval( $eventlatlong[ "long" ] ),
			floatval( $deviceLat ),
			floatval( $deviceLng )
		);

		$currentdatetime = Factory::getDate();
		$newcurrentdatetime = new Date( $currentdatetime, $offset );
		$newcurrentdatetime->setTimezone( $timezone );

		$options = array( 'remember' => true );
		$credentials[ 'userid' ] = $userid;
		$credentials[ 'password' ] = $passwordraw;
		$credentials[ 'deviceidlogin' ] = $deviceidlogin;
		$result = Factory::getApplication()->login( $credentials, $options );

		if ( $result ) {

			if ( $distance < $radiusinmetersint ) {

				if ( $devicetimeunix >= $eventstartdateunix && $devicetimeunix <= $eventenddateunix ) {

					$query = $db->getQuery( true );

					$query
						->update( $db->quoteName( '#__eb_registrants' ) )->set( $db->quoteName( 'checked_in' ) . ' = 1' )->set( $db->quoteName( 'checked_in_at' ) . ' = ' . $db->quote( $newcurrentdatetime ) )->where( $db->quoteName( 'id' ) . ' = ' . $db->quote( $registrationid ) );

					$db->setQuery( $query );
					$db->execute();

					if ( $db->getAffectedRows() > 0 ) {
						$selfcheckinresponse = array(
							'result' => 'success',
							'message' => Text::_( 'COM_APPSCONDA_MOBILE_SELF_CHECKING_OK' )
						);

						header( 'Content-Type: application/json' );
						http_response_code( 200 );

						echo json_encode( $selfcheckinresponse );

						jexit();
					} else {

						$selfcheckinresponse = array(
							'result' => 'error',
							'message' => Text::_( 'COM_APPSCONDA_MOBILE_SELF_CHECKING_NOT_OK' )
						);
						header( 'Content-Type: application/json' );
						http_response_code( 403 );

						echo json_encode( $selfcheckinresponse );

						jexit();
					}

				} else {

					$selfcheckinresponse = array(
						'result' => 'error',
						'message' => Text::_( 'COM_APPSCONDA_MOBILE_SELF_CHECKING_NOT_OK_TIME' )
					);
					header( 'Content-Type: application/json' );
					http_response_code( 403 );

					echo json_encode( $selfcheckinresponse );

					jexit();
				}
			} else {

				$selfcheckinresponse = array(
					'result' => 'error',
					'message' => Text::_( 'COM_APPSCONDA_MOBILE_SELF_CHECKING_NOT_OK_LOCATION' )
				);
				header( 'Content-Type: application/json' );
				http_response_code( 403 );

				echo json_encode( $selfcheckinresponse );

				jexit();
			}

		} else {

			$selfcheckinresponse = array(
				'result' => 'error',
				'message' => Text::_( 'COM_APPSCONDA_MOBILE_SELF_CHECKING_NOT_OK' )
			);
			header( 'Content-Type: application/json' );
			http_response_code( 403 );

			echo json_encode( $selfcheckinresponse );

			jexit();
		}

	}

	function mobileappqrcodescan() {

		$rawData = file_get_contents( "php://input" );
		$data = json_decode( $rawData, true );
		$userid = isset( $data[ 'userid' ] ) ? $data[ 'userid' ] : null;
		$passwordraw = isset( $data[ 'password' ] ) ? $data[ 'password' ] : null;
		$deviceidlogin = isset( $data[ 'deviceidlogin' ] ) ? $data[ 'deviceidlogin' ] : null;
		$registrationid = isset( $data[ 'registrationid' ] ) ? $data[ 'registrationid' ] : null;
		$db = Factory::getDbo();
		$dateobj = Factory::getDate();
		$currentdatetime = $dateobj;
		$user = Factory::getUser( $userid );

		if ( !empty( $passwordraw ) && !empty( $userid ) && !empty( $deviceidlogin ) ) {

			$options = array( 'remember' => true );
			$credentials[ 'userid' ] = $userid;
			$credentials[ 'password' ] = $passwordraw;
			$credentials[ 'deviceidlogin' ] = $deviceidlogin;
			$result = Factory::getApplication()->login( $credentials, $options );

			if ( $result ) {

				if ( $user->authorise( 'core.login.admin' ) ) {

					if ( empty( trim( $registrationid ) ) ) {
						$checkinresponse = array(
							'result' => 'error',
							'message' => Text::_( 'COM_APPSCONDA_MOBILE_QR_CHECKING_NOT_OK_DB' )
						);
						header( 'Content-Type: application/json' );
						http_response_code( 403 );

						echo json_encode( $checkinresponse );

						jexit();
					}

					if ( filter_var( $registrationid, FILTER_VALIDATE_URL ) ) {
						$parsed_url = parse_url( $registrationid );
						parse_str( $parsed_url[ 'query' ], $query_params );

						if ( isset( $query_params[ 'option' ], $query_params[ 'task' ], $query_params[ 'id' ] ) &&
							$query_params[ 'option' ] === 'com_eventbooking' &&
							$query_params[ 'task' ] === 'registrant.checkin'
						) {
							$registrationid = $query_params[ 'id' ];
						} else {

							$registrationid = $registrationid;
						}
					} else {

						$registrationid = $registrationid;
					}

					$registrationid = ctype_digit( ( string )$registrationid ) ? $registrationid : 0;

					$query = $db->getQuery( true );
					$query
						->update( $db->quoteName( '#__eb_registrants' ) )->set( $db->quoteName( 'checked_in' ) . ' = 1' )->set(
							$db->quoteName( 'checked_in_at' ) .
							' = ' . $db->quote( $currentdatetime )
						)->where( $db->quoteName( 'id' ) . ' = ' . $db->quote( $registrationid ) );

					$db->setQuery( $query );

					$db->execute();

					if ( $db->getAffectedRows() > 0 ) {
						$checkinresponse = [
							'result' => 'success',
							'message' => Text::_( 'COM_APPSCONDA_MOBILE_QR_CHECKING_OK' )
						];

						header( 'Content-Type: application/json' );
						http_response_code( 200 );

						echo json_encode( $checkinresponse );

						jexit();
					} else {

						$checkinresponse = array(
							'result' => 'error',
							'message' => Text::_( 'COM_APPSCONDA_MOBILE_QR_CHECKING_NOT_OK_DB' )
						);
						header( 'Content-Type: application/json' );
						http_response_code( 403 );

						echo json_encode( $checkinresponse );

						jexit();
					}
				} else {
					$checkinresponse = array(
						'result' => 'error',
						'message' => Text::_( 'COM_APPSCONDA_MOBILE_QR_CHECKING_NOT_OK_ADMIN' )
					);
					header( 'Content-Type: application/json' );
					http_response_code( 403 );

					echo json_encode( $checkinresponse );

					jexit();

				}

			} else {

				$checkinresponse = array(
					'result' => 'error',
					'message' => Text::_( 'COM_APPSCONDA_MOBILE_QR_CHECKING_NOT_OK_ACCESS' )
				);
				header( 'Content-Type: application/json' );
				http_response_code( 403 );

				echo json_encode( $checkinresponse );

				jexit();
			}

		} else {

			$checkinresponse = array(
				'result' => 'error',
				'message' => Text::_( 'COM_APPSCONDA_MOBILE_QR_CHECKING_NOT_OK_ACCESS' )
			);
			header( 'Content-Type: application/json' );
			http_response_code( 403 );

			echo json_encode( $checkinresponse );

			jexit();
		}

	}

	function mobileappmytickets() {

		$rawData = file_get_contents( "php://input" );
		$data = json_decode( $rawData, true );
		$userid = isset( $data[ 'userid' ] ) ? $data[ 'userid' ] : null;
		$passwordraw = isset( $data[ 'password' ] ) ? $data[ 'password' ] : null;
		$deviceidlogin = isset( $data[ 'deviceidlogin' ] ) ? $data[ 'deviceidlogin' ] : null;
		$numberoftickets = 0;
		$db = Factory::getDbo();

		if ( !empty( $passwordraw ) && !empty( $userid ) && !empty( $deviceidlogin ) ) {

			$options = array( 'remember' => true );
			$credentials[ 'userid' ] = $userid;
			$credentials[ 'password' ] = $passwordraw;
			$credentials[ 'deviceidlogin' ] = $deviceidlogin;
			$result = Factory::getApplication()->login( $credentials, $options );

			if ( $result ) {

				$queryforticketsnumber = $db->getQuery( true )->select( 'COUNT(*)' )->from( '#__helpdeskpro_tickets' )->where( 'user_id = ' . $db->quote( $userid ) );

				$db->setQuery( $queryforticketsnumber );
				$numberoftickets = $db->loadResult();
				$havetickets = !empty( $numberoftickets );

				$query = $db->getQuery( true )->select( 'CAST(o.id AS CHAR) AS id, o.subject, o.message, o.created_date, s.title AS status, 
        COUNT(m.id) > 0 AS hasreplies' )->from( '#__helpdeskpro_tickets AS o' )->leftJoin( '#__helpdeskpro_statuses AS s ON o.status_id = s.id' )->leftJoin( '#__helpdeskpro_messages AS m ON o.id = m.ticket_id' )->where( 'o.user_id = ' . $db->quote( $userid ) )->group( 'o.id' )->order( 'o.created_date DESC' );

				$db->setQuery( $query );
				$mytickets = $db->loadAssocList();

				foreach ( $mytickets as & $ticket ) {
					$ticket[ 'hasreplies' ] = ( bool )$ticket[ 'hasreplies' ];
				}

				if ( $mytickets ) {

					header( 'Content-Type: application/json' );
					http_response_code( 200 );

					$response = array(
						'noticketmsg' => Text::_( 'COM_APPSCONDA_MOBILE_QR_CHECKING_NO_TICKETS' ),
						'havetickets' => $havetickets ? true : false,
						'result' => $mytickets
					);
					echo json_encode( $response );

					jexit();
				} else

				{
					$myorderdetails = [
						'noticketmsg' => Text::_( 'COM_APPSCONDA_MOBILE_QR_CHECKING_NO_TICKETS' ),
						'havetickets' => $havetickets ? true : false,
						'result' => $mytickets
					];
					header( 'Content-Type: application/json' );
					http_response_code( 403 );

					echo json_encode( $myorderdetails );

					jexit();
				}

			} else

			{
				$myorderdetails = [
					'noticketmsg' => Text::_( 'COM_APPSCONDA_MOBILE_EVENT_USER_AUTH_FAILED' ),
					'userauth' => false,
					'havetickets' => $havetickets ? true : false,
					'result' => $mytickets
				];
				header( 'Content-Type: application/json' );
				http_response_code( 200 );

				echo json_encode( $myorderdetails );

				jexit();
			}
		} else

		{
			$myorderdetails = [
				'noticketmsg' => Text::_( 'COM_APPSCONDA_MOBILE_QR_CHECKING_NO_TICKETS' ),
				'havetickets' => $havetickets ? true : false,
				'result' => $mytickets
			];
			header( 'Content-Type: application/json' );
			http_response_code( 403 );
			echo json_encode( $myorderdetails );
			jexit();
		}
	}

	function mobileappmyticketdetails() {

		$rawData = file_get_contents( "php://input" );
		$data = json_decode( $rawData, true );
		$userid = isset( $data[ 'userid' ] ) ? $data[ 'userid' ] : null;
		$passwordraw = isset( $data[ 'password' ] ) ? $data[ 'password' ] : null;
		$deviceidlogin = isset( $data[ 'deviceidlogin' ] ) ? $data[ 'deviceidlogin' ] : null;
		$ticketid = isset( $data[ 'ticketid' ] ) ? $data[ 'ticketid' ] : null;
		$db = Factory::getDbo();

		if ( !empty( $passwordraw ) && !empty( $userid ) && !empty( $deviceidlogin ) ) {

			$options = array( 'remember' => true );
			$credentials[ 'userid' ] = $userid;
			$credentials[ 'password' ] = $passwordraw;
			$credentials[ 'deviceidlogin' ] = $deviceidlogin;
			$result = Factory::getApplication()->login( $credentials, $options );

			if ( $result ) {

				$query = $db->getQuery( true )->select( 'o.id, o.ticket_id, o.date_added, o.message, u.name' )->from( '#__helpdeskpro_messages AS o' )->leftJoin( '#__users AS u ON o.user_id = u.id' )->where( 'o.ticket_id = ' . $db->quote( $ticketid ) )->order( 'o.date_added DESC' );

				$db->setQuery( $query );
				$myticketdetails = $db->loadAssocList();

				$response = array(
					'datecreatedtext' => Text::_( 'COM_APPSCONDA_MOBILE_DATE_CREATED' ),
					'statustext' => Text::_( 'COM_APPSCONDA_MOBILE_STATUS' ),
					'dateaddedtext' => Text::_( 'COM_APPSCONDA_MOBILE_DATE_ADDED' ),
					'postedbytext' => Text::_( 'COM_APPSCONDA_MOBILE_POSTED_BY' ),
					'messageheretext' => Text::_( 'COM_APPSCONDA_MOBILE_MESAGE_HERE' ),
					'replybuttontext' => Text::_( 'COM_APPSCONDA_MOBILE_REPLY_TO_THE_TICKET' ),
					'result' => $myticketdetails
				);

				if ( $myticketdetails ) {

					header( 'Content-Type: application/json' );
					http_response_code( 200 );

					echo json_encode( $response );

					jexit();
				} else

				{
					$responsefornoreplies = [
						'result' => 'error',
						'datecreatedtext' => Text::_( 'COM_APPSCONDA_MOBILE_DATE_CREATED' ),
						'statustext' => Text::_( 'COM_APPSCONDA_MOBILE_STATUS' ),
						'dateaddedtext' => Text::_( 'COM_APPSCONDA_MOBILE_DATE_ADDED' ),
						'postedbytext' => Text::_( 'COM_APPSCONDA_MOBILE_POSTED_BY' ),
						'messageheretext' => Text::_( 'COM_APPSCONDA_MOBILE_MESAGE_HERE' ),
						'replybuttontext' => Text::_( 'COM_APPSCONDA_MOBILE_REPLY_TO_THE_TICKET' ),
						'message' => Text::_( 'COM_APPSCONDA_MOBILE_NO_TICKET_FETCH' )
					];
					header( 'Content-Type: application/json' );

					echo json_encode( $responsefornoreplies );

					jexit();
				}

			} else

			{
				$response = [
					'result' => 'error',
					'message' => Text::_( 'COM_APPSCONDA_MOBILE_LOGIN_VALIDATION_FAILED' )
				];
				header( 'Content-Type: application/json' );
				http_response_code( 200 );

				echo json_encode( $response );

				jexit();
			}
		} else

		{
			$response = [
				'result' => 'error',
				'message' => Text::_( 'COM_APPSCONDA_MOBILE_COULD_NOT_DECODE' )
			];
			header( 'Content-Type: application/json' );
			http_response_code( 403 );

			echo json_encode( $response );

			jexit();
		}
	}

	function mobileappgallerycategories() {

		$db = Factory::getDbo();

		$query = $db->getQuery( true );

		$query->select( $db->quoteName( 'menu11contentid' ) );
		$query->from( $db->quoteName( '#__appsconda_drawermenus' ) );

		$db->setQuery( $query );
		$menu11contentids = $db->loadColumn();
		$menu11contentids = array_filter( $menu11contentids );

		$query = $db->getQuery( true )->select( 'cd.id, cd.title, cd.image, COUNT(pc.id) AS number_of_images' )->from( '#__speasyimagegallery_albums AS cd' )->join( 'LEFT', '#__speasyimagegallery_images AS pc ON cd.id = pc.album_id' )->group( 'cd.id' )->having( 'number_of_images > 0' )->order( 'cd.created DESC' );

		if ( !empty( $menu11contentids ) ) {
			$query->where( 'cd.id IN (' . implode( ',', $menu11contentids ) . ')' );
		}

		$db->setQuery( $query );
		$results = $db->loadAssocList();

		$items = array();
		foreach ( $results as $result ) {

			if ( isset( $result[ 'image' ] ) && !empty( $result[ 'image' ] ) ) {
				$categoryimage = Uri::base() . $result[ 'image' ];
			}

			$category = array(
				'id' => $result[ 'id' ],
				'image' => $categoryimage,
				'numberofimages' => $result[ 'number_of_images' ],
				'title' => $result[ 'title' ]
			);
			$items[] = $category;
		}

		$queryforgallerynumber = $db->getQuery( true )->select( 'COUNT(pc.id) AS number_of_images' )->from( '#__speasyimagegallery_albums AS cd' )->join( 'LEFT', '#__speasyimagegallery_images AS pc ON cd.id = pc.album_id' )->group( 'cd.id' )->having( 'number_of_images > 0' )->order( 'cd.created DESC' );

		$db->setQuery( $queryforgallerynumber );
		$numberofgallery = $db->loadResult();
		$havegallery = !empty( $numberofgallery );

		$response = array(
			'nogallerymsg' => Text::_( 'COM_APPSCONDA_MOBILE_NO_GALLERY' ),
			'havegallery' => $havegallery ? true : false,
			'result' => $items
		);

		header( 'Content-Type: application/json' );

		echo json_encode( $response );

		jexit();

	}

	function mobileappeventregistrationapi() {

		$jinput = Factory::getApplication()->input;
		$eventid = $jinput->get( 'eventid', 'default_value', 'INT' );
		$userid = Factory::getApplication()->input->cookie->get( 'userid', '', 'INT' );
		$deviceidlogin = Factory::getApplication()->input->cookie->get( 'deviceidlogin', '', 'STRING' );
		$passwordraw = Factory::getApplication()->input->cookie->get( 'password', '', 'STRING' );
		$user = Factory::getUser();

		if ( $user->guest ) {

			if ( !empty( $passwordraw ) && !empty( $userid ) && !empty( $deviceidlogin ) ) {

				$options = array( 'remember' => true );
				$credentials[ 'userid' ] = $userid;
				$credentials[ 'password' ] = $passwordraw;
				$credentials[ 'deviceidlogin' ] = $deviceidlogin;
				$result = Factory::getApplication()->login( $credentials, $options );

				if ( $result ) {

					$this->setRedirect( "index.php?option=com_eventbooking&task=register.individual_registration&event_id=" . $eventid );
				} else {

					$this->setRedirect( "index.php?option=com_eventbooking&task=register.individual_registration&event_id=" . $eventid );
				}

			} else {
				$this->setRedirect( "index.php?option=com_eventbooking&task=register.individual_registration&event_id=" . $eventid );
			}
		} else {

			$this->setRedirect( "index.php?option=com_eventbooking&task=register.individual_registration&event_id=" . $eventid );
		}
	}

	function custompagesurl() {

		$jinput = Factory::getApplication()->input;
		$userid = Factory::getApplication()->input->cookie->get( 'userid', '', 'INT' );
		$deviceidlogin = Factory::getApplication()->input->cookie->get( 'deviceidlogin', '', 'STRING' );
		$passwordraw = Factory::getApplication()->input->cookie->get( 'password', '', 'STRING' );
		$user = Factory::getUser();

		$db = Factory::getDbo();
		$queryforcustompagesurl = $db->getQuery( true )->select( 'extraurl' )->from( '#__appsconda_drawermenus' )->where( $db->quoteName( 'id' ) . ' = 1' );

		$db->setQuery( $queryforcustompagesurl );
		$custompagesurl = $db->loadResult();

		if ( $user->guest ) {

			if ( !empty( $passwordraw ) && !empty( $userid ) && !empty( $deviceidlogin ) ) {

				$options = array( 'remember' => true );
				$credentials[ 'userid' ] = $userid;
				$credentials[ 'password' ] = $passwordraw;
				$credentials[ 'deviceidlogin' ] = $deviceidlogin;
				$result = Factory::getApplication()->login( $credentials, $options );

				if ( $result ) {

					$this->setRedirect( $custompagesurl );

				} else {

					$this->setRedirect( $custompagesurl );

				}

			} else {
				$this->setRedirect( $custompagesurl );
			}
		} else {

			$this->setRedirect( $custompagesurl );
		}
	}

	function mobileappmyevents() {

		$rawData = file_get_contents( "php://input" );
		$data = json_decode( $rawData, true );
		$userid = isset( $data[ 'userid' ] ) ? $data[ 'userid' ] : null;
		$passwordraw = isset( $data[ 'password' ] ) ? $data[ 'password' ] : null;
		$deviceidlogin = isset( $data[ 'deviceidlogin' ] ) ? $data[ 'deviceidlogin' ] : null;

		if ( !empty( $passwordraw ) && !empty( $userid ) && !empty( $deviceidlogin ) ) {

			$options = array( 'remember' => true );
			$credentials[ 'userid' ] = $userid;
			$credentials[ 'password' ] = $passwordraw;
			$credentials[ 'deviceidlogin' ] = $deviceidlogin;
			$result = Factory::getApplication()->login( $credentials, $options );
		}

		if ( $result ) {

			$db = Factory::getDbo();

			$query = $db->getQuery( true )->select( 'r.id, r.event_id, r.user_id, r.first_name, r.last_name, r.total_amount, r.discount_amount, r.amount, r.register_date, r.published, r.checked_in, r.checked_in_at, e.title, e.event_date' )->from( $db->quoteName( '#__eb_registrants', 'r' ) )->leftJoin( $db->quoteName( '#__eb_events', 'e' ) . ' ON ' . $db->quoteName( 'r.event_id' ) . ' = ' . $db->quoteName( 'e.id' ) )->where( $db->quoteName( 'r.user_id' ) . ' = ' . $db->quote( $userid ) )->where( $db->quoteName( 'r.published' ) . ' = 1' )->order( $db->quoteName( 'r.register_date' ) . ' DESC' );

			$db->setQuery( $query );
			$myevents = $db->loadAssocList();

			foreach ( $myevents as & $event ) {
				$offset = Factory::getConfig()->get( 'offset' );
				$timezone = Factory::getUser()->getTimezone();

				$newcheckedinat = new Date( $event[ 'checked_in_at' ] );
				$newcheckedinat->setTimezone( $timezone );
				$dateTime = new Date( $newcheckedinat );
				$date_time_part = $dateTime->format( 'Y-m-d H:i:s' );

				$newregisterdate = new Date( $event[ 'register_date' ] );
				$newregisterdate->setTimezone( $timezone );
				$registerdateTime = new Date( $newregisterdate );
				$register_date_time_part = $registerdateTime->format( 'Y-m-d H:i:s' );

				$event[ 'checked_in' ] = ( $event[ 'checked_in' ] == 1 ) ? true : false;
				$event[ 'checked_in_at' ] = $date_time_part;
				$event[ 'register_date' ] = $register_date_time_part;

			}

			$queryforeventsnumber = $db->getQuery( true )->select( 'COUNT(*)' )->from( '#__eb_registrants' )->where( $db->quoteName( 'user_id' ) . ' = ' . $db->quote( $userid ) )->where( $db->quoteName( 'published' ) . ' = 1' );

			$db->setQuery( $queryforeventsnumber );
			$numberofevents = $db->loadResult();
			$haveevents = !empty( $numberofevents );

			$response = array(
				'noeventtext' => Text::_( 'COM_APPSCONDA_MOBILE_NO_EVENT' ),
				'eventdatetext' => Text::_( 'COM_APPSCONDA_MOBILE_EVENT_DATE' ),
				'registerdatetext' => Text::_( 'COM_APPSCONDA_MOBILE_REGISTER_DATE' ),
				'eventtext' => Text::_( 'COM_APPSCONDA_MOBILE_EVENT' ),
				'nametext' => Text::_( 'COM_APPSCONDA_MOBILE_NAME' ),
				'amounttext' => Text::_( 'COM_APPSCONDA_MOBILE_EVENT_AMOUNT' ),
				'discountamounttext' => Text::_( 'COM_APPSCONDA_MOBILE_EVENT_DISCOUNT_AMOUNT' ),
				'totalamounttext' => Text::_( 'COM_APPSCONDA_MOBILE_EVENT_TOTAL_AMOUNT' ),
				'checkedintext' => Text::_( 'COM_APPSCONDA_MOBILE_EVENT_CHECKED_IN' ),
				'checkedintimetext' => Text::_( 'COM_APPSCONDA_MOBILE_EVENT_CHECKED_IN_TIME' ),
				'buttontext' => Text::_( 'COM_APPSCONDA_MOBILE_EVENT_SELF_CHECK_IN' ),
				'haveevents' => $haveevents ? true : false,
				'result' => $myevents
			);

			header( 'Content-Type: application/json' );
			http_response_code( 200 );

			echo json_encode( $response );

			jexit();

		} else {

			$myevents = array(
				'result' => 'error',
				'message' => Text::_( 'COM_APPSCONDA_MOBILE_EVENT_USER_AUTH_FAILED' )
			);
			header( 'Content-Type: application/json' );
			http_response_code( 403 );

			echo json_encode( $myevents );

			jexit();
		}

	}

	function mobileappmyorders() {

		$rawData = file_get_contents( "php://input" );
		$data = json_decode( $rawData, true );
		$userid = isset( $data[ 'userid' ] ) ? $data[ 'userid' ] : null;
		$passwordraw = isset( $data[ 'password' ] ) ? $data[ 'password' ] : null;
		$deviceidlogin = isset( $data[ 'deviceidlogin' ] ) ? $data[ 'deviceidlogin' ] : null;

		if ( !empty( $passwordraw ) && !empty( $userid ) && !empty( $deviceidlogin ) ) {

			$options = array( 'remember' => true );
			$credentials[ 'userid' ] = $userid;
			$credentials[ 'password' ] = $passwordraw;
			$credentials[ 'deviceidlogin' ] = $deviceidlogin;
			$result = Factory::getApplication()->login( $credentials, $options );
		}

		if ( $result ) {

			$db = Factory::getDbo();

			$query = $db->getQuery( true )->select( 'id, order_number, total, created_date' )->from( $db->quoteName( '#__eshop_orders' ) )->where( $db->quoteName( 'customer_id' ) . ' = ' . $db->quote( $userid ) )->order( $db->quoteName( 'created_date' ) . ' DESC' );

			$db->setQuery( $query );
			$myorders = $db->loadAssocList();

			$queryforordersnumber = $db->getQuery( true )->select( 'COUNT(*)' )->from( '#__eshop_orders' )->where( $db->quoteName( 'customer_id' ) . ' = ' . $db->quote( $userid ) );

			$db->setQuery( $queryforordersnumber );
			$numberoforders = $db->loadResult();
			$haveorders = !empty( $numberoforders );

			$response = array(
				'noordertext' => Text::_( 'COM_APPSCONDA_MOBILE_NO_ORDER_FOUND' ),
				'ordernumbertext' => Text::_( 'COM_APPSCONDA_MOBILE_ORDER_NUMBER' ),
				'ordertotaltext' => Text::_( 'COM_APPSCONDA_MOBILE_ORDER_TOTAL' ),
				'orderdatetext' => Text::_( 'COM_APPSCONDA_MOBILE_ORDER_DATE' ),
				'ordertotalexshiptext' => Text::_( 'COM_APPSCONDA_MOBILE_ORDER_TOTAL_EX_SHIPPING' ),
				'paymentmethodtext' => Text::_( 'COM_APPSCONDA_MOBILE_PAYMENT_METHOD' ),
				'orderstatustext' => Text::_( 'COM_APPSCONDA_MOBILE_ORDER_STATUS' ),
				'pricetext' => Text::_( 'COM_APPSCONDA_MOBILE_PRICE' ),
				'quantitytext' => Text::_( 'COM_APPSCONDA_MOBILE_QUANTITY' ),
				'totaltext' => Text::_( 'COM_APPSCONDA_MOBILE_TOTAL' ),
				'haveorders' => $haveorders ? true : false,
				'result' => $myorders
			);

			header( 'Content-Type: application/json' );
			http_response_code( 200 );

			echo json_encode( $response );

			jexit();

		} else {

			$myorders = array(
				'result' => 'error',
				'message' => Text::_( 'COM_APPSCONDA_MOBILE_EVENT_USER_AUTH_FAILED' )
			);
			header( 'Content-Type: application/json' );
			http_response_code( 403 );

			echo json_encode( $myorders );

			jexit();
		}

	}

	function mobileappmyorderdetails() {

		$rawData = file_get_contents( "php://input" );
		$data = json_decode( $rawData, true );
		$userid = isset( $data[ 'userid' ] ) ? $data[ 'userid' ] : null;
		$passwordraw = isset( $data[ 'password' ] ) ? $data[ 'password' ] : null;
		$deviceidlogin = isset( $data[ 'deviceidlogin' ] ) ? $data[ 'deviceidlogin' ] : null;
		$orderid = isset( $data[ 'orderid' ] ) ? $data[ 'orderid' ] : null;
		$db = Factory::getDbo();

		if ( !empty( $passwordraw ) && !empty( $userid ) && !empty( $deviceidlogin ) ) {

			$options = array( 'remember' => true );
			$credentials[ 'userid' ] = $userid;
			$credentials[ 'password' ] = $passwordraw;
			$credentials[ 'deviceidlogin' ] = $deviceidlogin;
			$result = Factory::getApplication()->login( $credentials, $options );

			if ( $result ) {

				$query = $db->getQuery( true )->select( 'o.id, o.order_number, o.customer_id, o.payment_method_title, o.total, o.order_status_id, o.created_date, s.orderstatus_name' )->from( '#__eshop_orders AS o' )->leftJoin( '#__eshop_orderstatusdetails AS s ON o.order_status_id = s.orderstatus_id' )->where( 'o.id = ' . $db->quote( $orderid ) );

				$db->setQuery( $query );
				$order = $db->loadAssoc();

				if ( $order ) {

					$query = $db->getQuery( true )->select( 'p.product_name, p.quantity, p.price, p.total_price' )->from( '#__eshop_orderproducts AS p' )->where( 'p.order_id = ' . $db->quote( $orderid ) );

					$db->setQuery( $query );
					$products = $db->loadAssocList();

					$order[ 'products' ] = $products;

					header( 'Content-Type: application/json' );
					http_response_code( 200 );
					echo json_encode( $order );

					jexit();
				} else

				{
					$myorderdetails = [
						'result' => 'error',
						'message' => Text::_( 'COM_APPSCONDA_MOBILE_COULD_NOT_FETCH_ORDER_DETAILS' )
					];
					header( 'Content-Type: application/json' );
					http_response_code( 403 );

					echo json_encode( $myorderdetails );

					jexit();
				}

			} else

			{
				$myorderdetails = [
					'result' => 'error',
					'message' => Text::_( 'COM_APPSCONDA_MOBILE_EVENT_USER_AUTH_FAILED' )
				];
				header( 'Content-Type: application/json' );
				http_response_code( 403 );

				echo json_encode( $myorderdetails );

				jexit();
			}

		} else

		{
			$myorderdetails = [
				'result' => 'error',
				'message' => Text::_( 'COM_APPSCONDA_MOBILE_EVENT_USER_AUTH_FAILED' )
			];
			header( 'Content-Type: application/json' );
			http_response_code( 403 );

			echo json_encode( $myorderdetails );

			jexit();
		}
	}

	function mobileapptopicreplyapi() {

		$jinput = Factory::getApplication()->input;
		$topicid = $jinput->get( 'topicid', 'default_value', 'INT' );
		$userid = Factory::getApplication()->input->cookie->get( 'userid', '', 'INT' );
		$deviceidlogin = Factory::getApplication()->input->cookie->get( 'deviceidlogin', '', 'STRING' );
		$passwordraw = Factory::getApplication()->input->cookie->get( 'password', '', 'STRING' );
		$user = Factory::getUser();

		if ( $user->guest ) {

			if ( !empty( $passwordraw ) && !empty( $userid ) && !empty( $deviceidlogin ) ) {

				$options = array( 'remember' => true );
				$credentials[ 'userid' ] = $userid;
				$credentials[ 'password' ] = $passwordraw;
				$credentials[ 'deviceidlogin' ] = $deviceidlogin;
				$result = Factory::getApplication()->login( $credentials, $options );

				if ( $result ) {

					$this->setRedirect( "index.php?option=com_kunena&view=topic&layout=reply&id=" . $topicid );

				} else {

					$this->setRedirect( "index.php?option=com_kunena&view=topic&layout=reply&id=" . $topicid );

				}

			} else {
				$this->setRedirect( "index.php?option=com_kunena&view=topic&layout=reply&id=" . $topicid );
			}
		} else {

			$this->setRedirect( "index.php?option=com_kunena&view=topic&layout=reply&id=" . $topicid );
		}
	}

	public
	function mobileappproductdetailsapi() {
		$jinput = Factory::getApplication()->input;
		$productid = $jinput->get( 'productid', 'default_value', 'INT' );
		$userid = Factory::getApplication()->input->cookie->get( 'userid', '', 'INT' );
		$deviceidlogin = Factory::getApplication()->input->cookie->get( 'deviceidlogin', '', 'STRING' );
		$passwordraw = Factory::getApplication()->input->cookie->get( 'password', '', 'STRING' );

		$user = Factory::getUser();

		if ( $user->guest ) {

			if ( !empty( $passwordraw ) && !empty( $userid ) && !empty( $deviceidlogin ) ) {

				$options = array( 'remember' => true );
				$credentials[ 'userid' ] = $userid;
				$credentials[ 'password' ] = $passwordraw;
				$credentials[ 'deviceidlogin' ] = $deviceidlogin;
				$result = Factory::getApplication()->login( $credentials, $options );

				if ( $result ) {

					$this->setRedirect( "index.php?option=com_eshop&view=product&id=" . $productid );

				} else {

					$this->setRedirect( "index.php?option=com_eshop&view=product&id=" . $productid );

				}

			} else {
				$this->setRedirect( "index.php?option=com_eshop&view=product&id=" . $productid );
			}
		} else {

			$this->setRedirect( "index.php?option=com_eshop&view=product&id=" . $productid );
		}
	}

	function productlisting() {

		$categoryID = Factory::getApplication()->input->getInt( 'categoryid' );

		$db = Factory::getDbo();

		$baseURL = Uri::base();

		$additionalPath = 'media/com_eshop/products/';

		$query = $db->getQuery( true )->select( 'p.id AS productid, CONCAT("' . $baseURL . $additionalPath . '", p.product_image) AS productimage, ROUND(p.product_price, 2) AS productprice, pd.product_name AS producttitle' )->from( $db->quoteName( '#__eshop_products', 'p' ) )->join( 'INNER', $db->quoteName( '#__eshop_productdetails', 'pd' ) . ' ON p.id = pd.product_id' )->join( 'INNER', $db->quoteName( '#__eshop_productcategories', 'pc' ) . ' ON p.id = pc.product_id' )->where( $db->quoteName( 'pc.category_id' ) . ' = ' . $db->quote( $categoryID ) );

		$db->setQuery( $query );
		$results = $db->loadAssocList();

		$queryforproductnumber = $db->getQuery( true )->select( 'COUNT(*) AS num_results' )->from( $db->quoteName( '#__eshop_products', 'p' ) )->join( 'INNER', $db->quoteName( '#__eshop_productdetails', 'pd' ) . ' ON p.id = pd.product_id' )->join( 'INNER', $db->quoteName( '#__eshop_productcategories', 'pc' ) . ' ON p.id = pc.product_id' )->where( $db->quoteName( 'pc.category_id' ) . ' = ' . $db->quote( $categoryID ) );

		$db->setQuery( $queryforproductnumber );
		$numberofproducts = $db->loadResult();
		$haveproducts = !empty( $numberofproducts );

		$response = array(
			'noproducttext' => Text::_( 'COM_APPSCONDA_MOBILE_NO_PRODUCT' ),
			'haveproducts' => $haveproducts ? true : false,
			'result' => $results
		);

		header( 'Content-Type: application/json' );

		echo json_encode( $response );

		jexit();

	}

	function galleryimagelisting() {

		$albumID = Factory::getApplication()->input->getInt( 'categoryid' );

		$db = Factory::getDbo();

		$query = $db->getQuery( true );

		$query->select( $db->quoteName( array( 'id', 'title', 'images' ) ) );

		$query->from( $db->quoteName( '#__speasyimagegallery_images' ) );

		$query->where( $db->quoteName( 'album_id' ) . ' = ' . $db->quote( $albumID ) );

		$db->setQuery( $query );

		$results = $db->loadAssocList();

		foreach ( $results as & $row ) {
			$images = json_decode( $row[ 'images' ], true );
			$row[ 'images' ] = Uri::root() . $images[ 'original' ];
		}

		header( 'Content-Type: application/json' );

		echo json_encode( $results );

		jexit();

	}

	function topiclisting() {

		$categoryID = Factory::getApplication()->input->getInt( 'categoryid' );

		$db = Factory::getDbo();

		$query = $db->getQuery( true )->select( 'id AS topicid, subject AS topictitle, posts AS numberofposts, last_post_time' )->from( $db->quoteName( '#__kunena_topics' ) )->where( $db->quoteName( 'category_id' ) . ' = ' . $db->quote( $categoryID ) );

		$db->setQuery( $query );
		$results = $db->loadAssocList();

		foreach ( $results as & $result ) {
			$result[ 'last_post_time' ] = Date::getInstance( $result[ 'last_post_time' ] )->format( 'Y-m-d H:i:s' );
		}

		$queryfortopicnumber = $db->getQuery( true )->select( 'COUNT(*) AS num_results' )->from( $db->quoteName( '#__kunena_topics' ) )->where( $db->quoteName( 'category_id' ) . ' = ' . $db->quote( $categoryID ) );

		$db->setQuery( $queryfortopicnumber );
		$numberoftopic = $db->loadResult();
		$havetopic = !empty( $numberoftopic );

		$response = array(
			'notopictext' => Text::_( 'COM_APPSCONDA_MOBILE_NO_TOPICS' ),
			'havetopic' => $havetopic ? true : false,
			'result' => $results
		);

		header( 'Content-Type: application/json' );

		echo json_encode( $response );

		jexit();

	}

	function topicdetails() {

		$topicID = Factory::getApplication()->input->getInt( 'topicid' );

		$db = Factory::getDbo();

		$query = $db->getQuery( true )->select( 'p.message, pd.subject, pd.time, u.name' )->from( $db->quoteName( '#__kunena_messages_text', 'p' ) )->join( 'INNER', $db->quoteName( '#__kunena_messages', 'pd' ) . ' ON p.mesid = pd.id' )->join( 'INNER', $db->quoteName( '#__users', 'u' ) . ' ON pd.userid = u.id' )->where( $db->quoteName( 'pd.thread' ) . ' = ' . $db->quote( $topicID ) )->order( 'pd.time DESC' );

		$db->setQuery( $query );
		$results = $db->loadAssocList();

		foreach ( $results as & $result ) {
			$result[ 'time' ] = Date::getInstance( $result[ 'time' ] )->format( 'Y-m-d H:i:s' );
		}

		header( 'Content-Type: application/json' );

		echo json_encode( $results );

		jexit();

	}



	function mobileappmenu() {

		$db = Factory::getDbo();

		$query = $db->getQuery( true )->select( '*' ) // No need for quoteName here.
			->from( $db->quoteName( '#__appsconda_drawermenus' ) );

		$db->setQuery( $query );

		$results = $db->loadObjectList();

		$items = [];

		foreach ( $results as $row ) {
			$item = [];

			if ( $row->menu1show == "true" ) {
				$item[ 'menuCustomShow' ] = true;
				$item[ 'menuCustomLabel' ] = $row->menu1label;
				$item[ 'menuCustomColor' ] = $row->menu1color;
				if ( !empty( $row->menu1icon ) ) {
					$item[ 'menuCustomIcon' ] = Uri::base() . substr( $row->menu1icon, 0, strpos( $row->menu1icon, '#' ) );
				} else {
					$item[ 'menuCustomIcon' ] = "";
				}
				$item[ 'menuCustomAccess' ] = $row->menu1access == "true" ? true : ( $row->menu1access == "false" ? false : null );
			}

			if ( $row->menu2show == "true" ) {
				$item[ 'menuCustom2Show' ] = true;
				$item[ 'menuCustom2Label' ] = $row->menu2label;
				$item[ 'menuCustom2Color' ] = $row->menu2color;
				if ( !empty( $row->menu2icon ) ) {
					$item[ 'menuCustom2Icon' ] = Uri::base() . substr( $row->menu2icon, 0, strpos( $row->menu2icon, '#' ) );
				} else {
					$item[ 'menuCustom2Icon' ] = "";
				}
				$item[ 'menuCustom2Access' ] = $row->menu2access == "true" ? true : ( $row->menu2access == "false" ? false : null );
			}

			if ( $row->menu3show == "true" ) {
				$item[ 'menuArticlesShow' ] = true;
				$item[ 'menuArticlesLabel' ] = $row->menu3label;
				$item[ 'menuArticlesColor' ] = $row->menu3color;
				if ( !empty( $row->menu3icon ) ) {
					$item[ 'menuArticlesIcon' ] = Uri::base() . substr( $row->menu3icon, 0, strpos( $row->menu3icon, '#' ) );
				} else {
					$item[ 'menuArticlesIcon' ] = "";
				}
				$item[ 'menuArticlesAccess' ] = $row->menu3access == "true" ? true : ( $row->menu3access == "false" ? false : null );
			}

			if ( $row->menu4show == "true" ) {
				$item[ 'menuArticles2Show' ] = true;
				$item[ 'menuArticles2Label' ] = $row->menu4label;
				$item[ 'menuArticles2Color' ] = $row->menu4color;
				if ( !empty( $row->menu4icon ) ) {
					$item[ 'menuArticles2Icon' ] = Uri::base() . substr( $row->menu4icon, 0, strpos( $row->menu4icon, '#' ) );
				} else {
					$item[ 'menuArticles2Icon' ] = "";
				}
				$item[ 'menuArticles2Access' ] = $row->menu4access == "true" ? true : ( $row->menu4access == "false" ? false : null );
			}

			if ( $row->menu5show == "true" ) {
				$item[ 'menuArticleCategoriesShow' ] = true;
				$item[ 'menuArticleCategoriesLabel' ] = $row->menu5label;
				$item[ 'menuArticleCategoriesColor' ] = $row->menu5color;
				if ( !empty( $row->menu5icon ) ) {
					$item[ 'menuArticleCategoriesIcon' ] = Uri::base() . substr( $row->menu5icon, 0, strpos( $row->menu5icon, '#' ) );
				} else {
					$item[ 'menuArticleCategoriesIcon' ] = "";
				}
				$item[ 'menuArticleCategoriesAccess' ] = $row->menu5access == "true" ? true : ( $row->menu5access == "false" ? false : null );
			}

			if ( $row->menu6show == "true" ) {
				$item[ 'menuContactsShow' ] = true;
				$item[ 'menuContactsLabel' ] = $row->menu6label;
				$item[ 'menuContactsColor' ] = $row->menu6color;
				if ( !empty( $row->menu6icon ) ) {
					$item[ 'menuContactsIcon' ] = Uri::base() . substr( $row->menu6icon, 0, strpos( $row->menu6icon, '#' ) );
				} else {
					$item[ 'menuContactsIcon' ] = "";
				}
				$item[ 'menuContactsAccess' ] = $row->menu6access == "true" ? true : ( $row->menu6access == "false" ? false : null );
			}

			if ( $row->menu7show == "true" ) {
				$item[ 'menuEventsShow' ] = true;
				$item[ 'menuEventsLabel' ] = $row->menu7label;
				$item[ 'menuEventsColor' ] = $row->menu7color;
				if ( !empty( $row->menu7icon ) ) {
					$item[ 'menuEventsIcon' ] = Uri::base() . substr( $row->menu7icon, 0, strpos( $row->menu7icon, '#' ) );
				} else {
					$item[ 'menuEventsIcon' ] = "";
				}
				$item[ 'menuEventsAccess' ] = $row->menu7access == "true" ? true : ( $row->menu7access == "false" ? false : null );
			}

			if ( $row->menucustompagesshow == "true" ) {
				$item[ 'menuCustompagesShow' ] = true;
				$item[ 'menuCustompagesLabel' ] = $row->menucustompageslabel;
				$item[ 'menuCustompagesColor' ] = $row->menucustompagescolor;
				if ( !empty( $row->menucustompagesicon ) ) {
					$item[ 'menuCustompagesIcon' ] = Uri::base() . substr( $row->menucustompagesicon, 0, strpos( $row->menucustompagesicon, '#' ) );
				} else {
					$item[ 'menuCustompagesIcon' ] = "";
				}
				$item[ 'menuCustompagesAccess' ] = $row->menucustompagesaccess == "true" ? true : ( $row->menucustompagesaccess == "false" ? false : null );
			}

			if ( $row->menu8show == "true" ) {
				$item[ 'menuShopShow' ] = true;
				$item[ 'menuShopLabel' ] = $row->menu8label;
				$item[ 'menuShopColor' ] = $row->menu8color;
				if ( !empty( $row->menu8icon ) ) {
					$item[ 'menuShopIcon' ] = Uri::base() . substr( $row->menu8icon, 0, strpos( $row->menu8icon, '#' ) );
				} else {
					$item[ 'menuShopIcon' ] = "";
				}
				$item[ 'menuShopAccess' ] = $row->menu8access == "true" ? true : ( $row->menu8access == "false" ? false : null );
			}

			if ( $row->menu9show == "true" ) {
				$item[ 'menuForumShow' ] = true;
				$item[ 'menuForumLabel' ] = $row->menu9label;
				$item[ 'menuForumColor' ] = $row->menu9color;
				if ( !empty( $row->menu9icon ) ) {
					$item[ 'menuForumIcon' ] = Uri::base() . substr( $row->menu9icon, 0, strpos( $row->menu9icon, '#' ) );
				} else {
					$item[ 'menuForumIcon' ] = "";
				}
				$item[ 'menuForumAccess' ] = $row->menu9access == "true" ? true : ( $row->menu9access == "false" ? false : null );
			}

			if ( $row->menu10show == "true" ) {
				$item[ 'menuVideosShow' ] = true;
				$item[ 'menuVideosLabel' ] = $row->menu10label;
				$item[ 'menuVideosColor' ] = $row->menu10color;
				if ( !empty( $row->menu10icon ) ) {
					$item[ 'menuVideosIcon' ] = Uri::base() . substr( $row->menu10icon, 0, strpos( $row->menu10icon, '#' ) );
				} else {
					$item[ 'menuVideosIcon' ] = "";
				}
				$item[ 'menuVideosAccess' ] = $row->menu10access == "true" ? true : ( $row->menu10access == "false" ? false : null );
			}

			if ( $row->menu11show == "true" ) {
				$item[ 'menuGalleryShow' ] = true;
				$item[ 'menuGalleryLabel' ] = $row->menu11label;
				$item[ 'menuGalleryColor' ] = $row->menu11color;
				if ( !empty( $row->menu11icon ) ) {
					$item[ 'menuGalleryIcon' ] = Uri::base() . substr( $row->menu11icon, 0, strpos( $row->menu11icon, '#' ) );
				} else {
					$item[ 'menuGalleryIcon' ] = "";
				}
				$item[ 'menuGalleryAccess' ] = $row->menu11access == "true" ? true : ( $row->menu11access == "false" ? false : null );
			}

			if ( $row->menusupportshow == "true" ) {
				$item[ 'menuSupportShow' ] = true;
				$item[ 'menuSupportLabel' ] = $row->menusupportlabel;
				$item[ 'menuSupportColor' ] = $row->menusupportcolor;
				if ( !empty( $row->menusupporticon ) ) {
					$item[ 'menuSupportIcon' ] = Uri::base() . substr( $row->menusupporticon, 0, strpos( $row->menusupporticon, '#' ) );
				} else {
					$item[ 'menuSupportIcon' ] = "";
				}
				$item[ 'menuSupportAccess' ] = true;
			}

			if (!empty($row->imageabovemenu)) {
		                $imagePath = $row->imageabovemenu;
		                
		                // Check if '#' character exists in the string
		                $pos = strpos($imagePath, '#');
		                
		                if ($pos !== false) {
		                    // Extract the part of the string before '#'
		                    $imagePath = substr($imagePath, 0, $pos);
		                }
		                
		                $item['imageAboveMenu'] = Uri::base() . $imagePath;
			} else {
		                $item['imageAboveMenu'] = "";
			}

			if ( $row->loginshow == "true" ) {
				$item[ 'menuLoginShow' ] = true;
				$item[ 'menuLoginLabel' ] = $row->loginlabel;
				$item[ 'menuLoginColor' ] = $row->logincolor;
				if ( !empty( $row->loginicon ) ) {
					$item[ 'menuLoginIcon' ] = Uri::base() . substr( $row->loginicon, 0, strpos( $row->loginicon, '#' ) );
				} else {
					$item[ 'menuLoginIcon' ] = "";
				}
			}

			if ( $row->myaccountshow == "true" ) {
				$item[ 'menuMyaccountShow' ] = true;
				$item[ 'menuMyaccountLabel' ] = $row->myaccountlabel;
				$item[ 'menuMyaccountColor' ] = $row->myaccountcolor;
				if ( !empty( $row->myaccounticon ) ) {
					$item[ 'menuMyaccountIcon' ] = Uri::base() . substr( $row->myaccounticon, 0, strpos( $row->myaccounticon, '#' ) );
				} else {
					$item[ 'menuMyaccountIcon' ] = "";
				}
			}

			if ( $row->logoutshow == "true" ) {
				$item[ 'menuLogoutShow' ] = true;
				$item[ 'menuLogoutLabel' ] = $row->logoutlabel;
				$item[ 'menuLogoutColor' ] = $row->logoutcolor;
				if ( !empty( $row->logouticon ) ) {
					$item[ 'menuLogoutIcon' ] = Uri::base() . substr( $row->logouticon, 0, strpos( $row->logouticon, '#' ) );
				} else {
					$item[ 'menuLogoutIcon' ] = "";
				}
			}

			$items[] = $item;
		}

		$response = [
			'menuItems' => $items
		];

		header( 'Content-Type: application/json' );

		echo json_encode( $response );

		jexit();

	}

	function myaccountmenu() {

		$db = Factory::getDbo();

		$query = $db->getQuery( true )->select( '*' )->from( $db->quoteName( '#__appsconda_mobileconfigs' ) );

		$db->setQuery( $query );

		$results = $db->loadObjectList();

		$items = [];

		foreach ( $results as $row ) {
			$item = [];

			if ( $row->myprofileshow == "true" ) {
				$item[ 'menuMyprofileShow' ] = filter_var( $row->myprofileshow, FILTER_VALIDATE_BOOLEAN );
				$item[ 'menuMyprofileLabel' ] = $row->myprofilelabel;
				$item[ 'menuMyprofileColor' ] = $row->myprofilecolor;
				if ( !empty( $row->myprofileicon ) ) {
					$item[ 'menuMyprofileIcon' ] = Uri::base() . substr( $row->myprofileicon, 0, strpos( $row->myprofileicon, '#' ) );
				} else {
					$item[ 'menuMyprofileIcon' ] = "";
				};
			}

			if ( $row->myeventshow == "true" ) {
				$item[ 'menumyeventShow' ] = filter_var( $row->myeventshow, FILTER_VALIDATE_BOOLEAN );
				$item[ 'menumyeventLabel' ] = $row->myeventlabel;
				$item[ 'menumyeventColor' ] = $row->myeventcolor;
				if ( !empty( $row->myeventicon ) ) {
					$item[ 'menumyeventIcon' ] = Uri::base() . substr( $row->myeventicon, 0, strpos( $row->myeventicon, '#' ) );
				} else {
					$item[ 'menumyeventIcon' ] = "";
				};
			}

			if ( $row->myordershow == "true" ) {
				$item[ 'menumyorderShow' ] = filter_var( $row->myordershow, FILTER_VALIDATE_BOOLEAN );
				$item[ 'menumyorderLabel' ] = $row->myorderlabel;
				$item[ 'menumyorderColor' ] = $row->myordercolor;
				if ( !empty( $row->myordericon ) ) {
					$item[ 'menumyorderIcon' ] = Uri::base() . substr( $row->myordericon, 0, strpos( $row->myordericon, '#' ) );
				} else {
					$item[ 'menumyorderIcon' ] = "";
				};
			}

			if ( $row->myticketshow == "true" ) {
				$item[ 'menumyticketShow' ] = filter_var( $row->myticketshow, FILTER_VALIDATE_BOOLEAN );
				$item[ 'menumyticketLabel' ] = $row->myticketlabel;
				$item[ 'menumyticketColor' ] = $row->myticketcolor;
				if ( !empty( $row->myticketicon ) ) {
					$item[ 'menumyticketIcon' ] = Uri::base() . substr( $row->myticketicon, 0, strpos( $row->myticketicon, '#' ) );
				} else {
					$item[ 'menumyticketIcon' ] = "";
				};
			}

			if ( $row->notifyshow == "true" ) {
				$item[ 'menunotifyShow' ] = filter_var( $row->notifyshow, FILTER_VALIDATE_BOOLEAN );
				$item[ 'menunotifyLabel' ] = $row->notifylabel;
				$item[ 'menunotifyColor' ] = $row->notifycolor;
				if ( !empty( $row->notifyicon ) ) {
					$item[ 'menunotifyIcon' ] = Uri::base() . substr( $row->notifyicon, 0, strpos( $row->notifyicon, '#' ) );
				} else {
					$item[ 'menunotifyIcon' ] = "";
				};
			}

			if ( $row->checkinadminshow == "true" ) {
				$item[ 'menucheckinadminShow' ] = filter_var( $row->checkinadminshow, FILTER_VALIDATE_BOOLEAN );
				$item[ 'menucheckinadminLabel' ] = $row->checkinadminlabel;
				$item[ 'menucheckinadminColor' ] = $row->checkinadmincolor;
				if ( !empty( $row->checkinadminicon ) ) {
					$item[ 'menucheckinadminIcon' ] = Uri::base() . substr( $row->checkinadminicon, 0, strpos( $row->checkinadminicon, '#' ) );
				} else {
					$item[ 'menucheckinadminIcon' ] = "";
				};
			}

			if ( $row->logoutshow == "true" ) {
				$item[ 'menuLogoutShow' ] = filter_var( $row->logoutshow, FILTER_VALIDATE_BOOLEAN );
				$item[ 'menuLogoutLabel' ] = $row->logoutlabel;
				$item[ 'menuLogoutColor' ] = $row->logoutcolor;
				if ( !empty( $row->logouticon ) ) {
					$item[ 'menuLogoutIcon' ] = Uri::base() . substr( $row->logouticon, 0, strpos( $row->logouticon, '#' ) );
				} else {
					$item[ 'menuLogoutIcon' ] = "";
				}
			}

			$items[] = $item;
		}

		$response = [
			'menuItems' => $items
		];

		header( 'Content-Type: application/json' );

		echo json_encode( $response );

		jexit();

	}

	function mobileappconfig() {

		$db = Factory::getDbo();
		$baseURL = Uri::base();

		$query = $db->getQuery( true )->select( '*' )->from( $db->quoteName( '#__appsconda_mobileconfigs' ) );

		$db->setQuery( $query );

		$results = $db->loadObjectList();

		$items = [];

		foreach ( $results as $row ) {
			$item = [];

			$item[ 'titlebgcolor' ] = $row->titlebgcolor;
			$item[ 'titleonlaunch' ] = $row->titleonlaunch;
			$item[ 'titletextcolor' ] = $row->titletextcolor;
			$item[ 'hamburgercolor' ] = $row->hamburgercolor;
			$item[ 'fontsizetitle' ] = intval( $row->fontsizetitle );
			$item[ 'fontsizemenu' ] = intval( $row->fontsizemenu );
			$item[ 'fontsizebody' ] = intval( $row->fontsizebody );
			$item[ 'fontsizesmall' ] = intval( $row->fontsizesmall );
			$item[ 'buttonbgcolor' ] = $row->buttonbgcolor;
			$item[ 'buttontextcolor' ] = $row->buttontextcolor;
			$item[ 'switchcoloron' ] = $row->switchcoloron;
			$item[ 'switchcoloroff' ] = $row->switchcoloroff;
			$item[ 'selfcheckinshow' ] = ( $row->selfcheckinshow === "true" );

			if ( isset( $row->backbuttonimage ) && !empty( $row->backbuttonimage ) ) {
				$splitimage = explode( "#", $row->backbuttonimage );
				$imageabovemenu = $splitimage[ 0 ];
				$item[ 'backbuttonimage' ] = Uri::base() . $imageabovemenu;
			} else {
				$item[ 'backbuttonimage' ] = "";
			}

			$items[] = $item;
		}

		$response = [
			'appConfig' => $items
		];

		header( 'Content-Type: application/json' );

		echo json_encode( $response );

		jexit();

	}

	function mobileappmenucustom() {

		$db = Factory::getDbo();

		$query = $db->getQuery( true )->select( $db->quoteName( 'menu1contentid' ) )->from( $db->quoteName( '#__appsconda_drawermenus' ) );

		$db->setQuery( $query );
		$menu1contentid = $db->loadResult();

		$query = $db->getQuery( true )->select( '*' )->from( $db->quoteName( '#__appsconda_custompages' ) )->where( $db->quoteName( 'id' ) . ' = ' . $db->quote( $menu1contentid ) );

		$db->setQuery( $query );
		$results = $db->loadAssocList();

		$output = array();
		if ( !empty( $results ) ) {
			$firstRow = $results[ 0 ];
			foreach ( $firstRow as $column => $value ) {
				$output[ $column ] = ( !empty( $value ) ) ? $value : "";
			}
		}

		$baseURL = Uri::base();

		foreach ( $output as $key => $value ) {
			if ( strpos( $key, 'image' ) === 0 ) {
				$output[ $key ] = ( !empty( $value ) ) ? $baseURL . $value : "";
			}
		}

		header( 'Content-Type: application/json' );

		echo json_encode( $output, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES );

		jexit();

	}

	function mobileappmenucustomtwo() {

		$db = Factory::getDbo();

		$query = $db->getQuery( true )->select( $db->quoteName( 'menu2contentid' ) )->from( $db->quoteName( '#__appsconda_drawermenus' ) );

		$db->setQuery( $query );
		$menu2contentid = $db->loadResult();

		$query = $db->getQuery( true )->select( '*' )->from( $db->quoteName( '#__appsconda_custompages' ) )->where( $db->quoteName( 'id' ) . ' = ' . $db->quote( $menu2contentid ) );

		$db->setQuery( $query );
		$results = $db->loadAssocList();

		$output = array();
		if ( !empty( $results ) ) {
			$firstRow = $results[ 0 ];
			foreach ( $firstRow as $column => $value ) {
				$output[ $column ] = ( !empty( $value ) ) ? $value : "";
			}
		}

		$baseURL = Uri::base();

		foreach ( $output as $key => $value ) {
			if ( strpos( $key, 'image' ) === 0 ) {
				$output[ $key ] = ( !empty( $value ) ) ? $baseURL . $value : "";
			}
		}

		header( 'Content-Type: application/json' );

		echo json_encode( $output, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES );

		jexit();

	}

	function mobileappmenucustompages() {

		$db = Factory::getDbo();
		$query = $db->getQuery( true );

		$query->select( $db->quoteName( 'menucustompagescontentid' ) );
		$query->from( $db->quoteName( '#__appsconda_drawermenus' ) );

		$db->setQuery( $query );
		$menucustompagescontentids = $db->loadColumn();

		$items = [];

		if ( !empty( $menucustompagescontentids ) ) {

			$query = $db->getQuery( true );
			$query->select( 'id, name' );
			$query->from( $db->quoteName( '#__appsconda_custompages' ) );
			$query->where( $db->quoteName( 'id' ) . ' IN (' . implode( ',', $menucustompagescontentids ) . ')' );
			$query->order( $db->quoteName( 'ordering' ) . ' ASC' );
			$db->setQuery( $query );
			$results = $db->loadAssocList();

			$queryforpagesnumber = $db->getQuery( true )->select( 'COUNT(*)' )->from( '#__appsconda_custompages' )->where( $db->quoteName( 'id' ) . ' IN (' . implode( ',', $menucustompagescontentids ) . ')' );

			$db->setQuery( $queryforpagesnumber );
			$numberofpages = $db->loadResult();
			$havepages = !empty( $numberofpages );

			$extracustompagesquery = $db->getQuery( true )->select( $db->quoteName( [ 'extralabel', 'extraurl', 'extrashow' ] ) )->from( $db->quoteName( '#__appsconda_drawermenus' ) );
			$db->setQuery( $extracustompagesquery );
			$customextraresults = $db->loadObjectList();
			$extralabel = $customextraresults[ 0 ]->extralabel;
			$extraurl = $customextraresults[ 0 ]->extraurl;
			$extrashow = $customextraresults[ 0 ]->extrashow;

			$response = array(
				'nopagesmsg' => Text::_( 'COM_APPSCONDA_MOBILE_NO_PAGES' ),
				'havepages' => $havepages ? true : false,
				'showextramenu' => filter_var( $extrashow, FILTER_VALIDATE_BOOLEAN ),
				'extramenulabel' => $extralabel,
				'extramenuurl' => $extraurl,
				'result' => $results
			);

		}

		header( 'Content-Type: application/json' );

		echo json_encode( $response );

		jexit();

	}

	function mobileappmenusupport() {

		$response = array(
			'createtickettext' => Text::_( 'COM_APPSCONDA_MOBILE_CREATE_TICKET' ),
			'myticketstext' => Text::_( 'COM_APPSCONDA_MOBILE_MY_TICKETS' ),
			'subjectheretext' => Text::_( 'COM_APPSCONDA_MOBILE_SUBJECT_HERE' ),
			'messageheretext' => Text::_( 'COM_APPSCONDA_MOBILE_MESAGE_HERE' ),
			'createaticketbuttontext' => Text::_( 'COM_APPSCONDA_MOBILE_CREATE_TICKET_BUTTON_TEXT' ),
			'replytoticketbuttontext' => Text::_( 'COM_APPSCONDA_MOBILE_REPLY_TO_THE_TICKET' ),
		);

		header( 'Content-Type: application/json' );

		echo json_encode( $response );

		jexit();

	}

	function mobileappmenunotify() {

		$response = array(
			'receivepushtext' => Text::_( 'COM_APPSCONDA_RECEIVE_PUSH_TEXT' )
		);

		header( 'Content-Type: application/json' );

		echo json_encode( $response );

		jexit();

	}

	function myprofilepage() {

		$response = array(
			'nameplaceholder' => Text::_( 'PROFILE_YOUR_NAME_HERE' ),
			'usernameplaceholder' => Text::_( 'PROFILE_YOUR_USERNAME_HERE' ),
			'emailplaceholder' => Text::_( 'PROFILE_YOUR_EMAIL_HERE' ),
			'passwordplaceholder' => Text::_( 'COM_APPSCONDA_MOBILE_PROFILE_NEW_PASSWORD' ),
			'passwordconfirmplaceholder' => Text::_( 'COM_APPSCONDA_MOBILE_PROFILE_CONFIRM_PASSWORD' ),
			'buttontext' => Text::_( 'COM_APPSCONDA_MOBILE_PROFILE_UPDATE_BUTTON_TEXT' ),
		);

		header( 'Content-Type: application/json' );

		echo json_encode( $response );

		jexit();

	}

	function mobileappmenulogout() {

		$response = array(
			'logoutheadingtext' => Text::_( 'LOGOUT_SURE_HEADING' ),
			'logoutbuttontext' => Text::_( 'LOGOUT_BUTTON_TEXT' )
		);

		header( 'Content-Type: application/json' );

		echo json_encode( $response );

		jexit();

	}

	function loginpage() {

		$db = Factory::getDbo();
		$query = $db->getQuery( true );
		$query->select( $db->quoteName( [ 'forgotpasswordshow', 'signupshow' ] ) )->from( $db->quoteName( '#__appsconda_mobileconfigs' ) )->where( $db->quoteName( 'id' ) . ' = 1' );
		$db->setQuery( $query );

		$row = $db->loadAssoc();

		$response = array(
			'loginheadingtext' => Text::_( 'LOGIN_PAGE_HEADING' ),
			'loginusernameplaceholder' => Text::_( 'LOGIN_PAGE_USERNAME_PLACEHOLDER' ),
			'loginpasswordplaceholder' => Text::_( 'LOGIN_PAGE_PASSWORD_PLACEHOLDER' ),
			'loginbuttontext' => Text::_( 'LOGIN_PAGE_BUTTON_TEXT' ),
			'forgotloginbuttontext' => Text::_( 'FORGOT_LOGIN_BUTTON_TEXT' ),
			'signupbuttontext' => Text::_( 'SIGNUP_BUTTON_TEXT' ),
			'loginsuccessmessage' => Text::_( 'LOGIN_PAGE_SUCCESS_MESSAGE' ),
			'forgotpasswordshow' => $row[ 'forgotpasswordshow' ] === 'true',
			'signupshow' => $row[ 'signupshow' ] === 'true'
		);

		header( 'Content-Type: application/json' );

		echo json_encode( $response );

		jexit();

	}

	function loginforgotpage() {

		$response = array(
			'loginforgotheadingtext' => Text::_( 'LOGIN_FORGOT_PAGE_HEADING' ),
			'loginforgotemailplaceholder' => Text::_( 'LOGIN_FORGOT_PAGE_EMAIL_PLACEHOLDER' ),
			'requestloginbuttontext' => Text::_( 'REQUEST_LOGIN_BUTTON_TEXT' ),
			'passwordplaceholder' => Text::_( 'LOGIN_FORGOT_PAGE_PASSWORD_PLACEHOLDER' ),
			'verifycodeplaceholder' => Text::_( 'LOGIN_FORGOT_PAGE_VERIFY_CODE_PLACEHOLDER' ),
			'resetpasswordbuttontext' => Text::_( 'RESET_PASSWORD_BUTTON_TEXT' )
		);

		header( 'Content-Type: application/json' );

		echo json_encode( $response );

		jexit();

	}

	function loginsignuppage() {

		$response = array(
			'loginsignupheadingtext' => Text::_( 'LOGIN_SIGNUP_PAGE_HEADING' ),
			'loginsignupnameplaceholder' => Text::_( 'LOGIN_FORGOT_PAGE_NAME_PLACEHOLDER' ),
			'loginsignupemailplaceholder' => Text::_( 'LOGIN_FORGOT_PAGE_EMAIL_PLACEHOLDER' ),
			'signupbuttontext' => Text::_( 'SIGNUP_BUTTON_TEXT' )
		);

		header( 'Content-Type: application/json' );

		echo json_encode( $response );

		jexit();

	}

	function forgotlogin() {

		$app = Factory::getApplication();

		$json_str = file_get_contents( 'php://input' );

		$json_obj = json_decode( $json_str, true );

		if ( isset( $json_obj ) ) {

			$email = $json_obj[ 'email' ];

			$db = Factory::getDbo();
			$quotedEmail = $db->quote( $email );

			$query = $db->getQuery( true )->select( $db->quoteName( 'id' ) )->from( $db->quoteName( '#__users' ) )->where( $db->quoteName( 'email' ) . ' = ' . $quotedEmail );
			$db->setQuery( $query );
			$emailExists = $db->loadResult();

			if ( $emailExists ) {

				$queryusername = $db->getQuery( true )->select( $db->quoteName( 'username' ) )->from( $db->quoteName( '#__users' ) )->where( $db->quoteName( 'email' ) . ' = ' . $quotedEmail );
				$db->setQuery( $queryusername );
				$username = $db->loadResult();

				$queryverifycodeexist = $db->getQuery( true )->select( $db->quoteName( 'id' ) )->from( $db->quoteName( '#__appsconda_forgotlogin' ) )->where( $db->quoteName( 'email' ) . ' = ' . $quotedEmail );
				$db->setQuery( $queryverifycodeexist );
				$verifycodeexist = $db->loadResult();

				if ( $verifycodeexist ) {
					$deleteexistingcodequery = "DELETE FROM `#__appsconda_forgotlogin` WHERE `email`=$quotedEmail";
					$db->setQuery( $deleteexistingcodequery );
					$db->execute();
				}

				$verifyCode = mt_rand( 1000000000, 9999999999 );

				$queryverifyinsert = "Insert into #__appsconda_forgotlogin (email, verifycode)
            VALUES ($quotedEmail, '$verifyCode')";
				$db->setQuery( $queryverifyinsert );
				$resultinserted = $db->execute();

				$recipient = $email;
				$subject = Text::_( 'COM_APPSCONDA_MOBILE_FORGOT_LOGIN_EMAIL_SUBJECT' );
				$body = Text::_( 'COM_APPSCONDA_MOBILE_FORGOT_LOGIN_EMAIL_BODY_LINE_ONE' ) . " " . $username . ".\n\n";
				$body .= Text::_( 'COM_APPSCONDA_MOBILE_FORGOT_LOGIN_EMAIL_BODY_LINE_TWO' ) . " " . $verifyCode . ".\n\n";
				$body .= Text::_( 'COM_APPSCONDA_MOBILE_FORGOT_LOGIN_EMAIL_BODY_LINE_THREE' );
				$mailfrom = $app->get( 'mailfrom' );
				$fromname = $app->get( 'fromname' );
				$mailer = Factory::getMailer();
				$mailer->setSender(
					array(
						$mailfrom,
						$fromname
					)
				);
				$mailer->addRecipient( $recipient );
				$mailer->setSubject( $subject );
				$mailer->setBody( $body );
				$send = $mailer->send();

				if ( $send !== true ) {
					header( 'Content-Type: application/json' );
					http_response_code( 403 );
					$result = array(
						'result' => 'error',
						'message' => $send->__toString()
					);
					echo json_encode( $result );
					jexit();
				}

				if ( $resultinserted && $send == true ) {

					header( 'Content-Type: application/json' );
					http_response_code( 200 );
					$result = array(
						'result' => 'success',
						'message' => Text::_( 'COM_APPSCONDA_MOBILE_VERIFY_CODE_SENT' )
					);
					echo json_encode( $result );
					jexit();
				} else {

					header( 'Content-Type: application/json' );
					http_response_code( 403 );
					$result = array(
						'result' => 'error',
						'message' => Text::_( 'COM_APPSCONDA_MOBILE_VERIFY_CODE_NOT_ISSUED' )
					);
					echo json_encode( $result );
					jexit();
				}
			} else {

				header( 'Content-Type: application/json' );
				http_response_code( 403 );
				$result = array(
					'result' => 'error',
					'message' => Text::_( 'COM_APPSCONDA_MOBILE_EMAIL_NOT_EXIST' )
				);
				echo json_encode( $result );
				jexit();
			}

		} else {

			header( 'Content-Type: application/json' );
			http_response_code( 403 );
			$result = array(
				'result' => 'error',
				'message' => Text::_( 'COM_APPSCONDA_MOBILE_EMAIL_EMPTY' )
			);
			echo json_encode( $result );
			jexit();
		}

	}

	function resetpassword() {

		$app = Factory::getApplication();

		$json_str = file_get_contents( 'php://input' );

		$json_obj = json_decode( $json_str, true );

		if ( isset( $json_obj ) ) {

			$email = $json_obj[ 'email' ];
			$newpassword = $json_obj[ 'newpassword' ];
			$verifycode = $json_obj[ 'verifycode' ];

			$db = Factory::getDbo();
			$quotedEmail = $db->quote( $email );
			$quotedVerifycode = $db->quote( $verifycode );
			$newpasswordhashed = UserHelper::hashPassword( $newpassword );

			$query = $db->getQuery( true )->select( $db->quoteName( 'id' ) )->from( $db->quoteName( '#__appsconda_forgotlogin' ) )->where( $db->quoteName( 'email' ) . ' = ' . $quotedEmail )->where( $db->quoteName( 'verifycode' ) . ' = ' . $quotedVerifycode );
			$db->setQuery( $query );
			$canResetPassword = $db->loadResult();

			if ( $canResetPassword ) {

				$resetpasswordquery = "UPDATE #__users SET password = '$newpasswordhashed' WHERE email = '$email'";
				$db->setQuery( $resetpasswordquery );
				if ( $db->execute() ) {

					$recipient = $email;
					$subject = Text::_( 'COM_APPSCONDA_MOBILE_PASSWORD_RESET_SUCCESS_EMAIL_SUBJECT' );
					$body = Text::_( 'COM_APPSCONDA_MOBILE_PASSWORD_RESET_SUCCESS_EMAIL_BODY_LINE_ONE' ) . ".\n\n";
					$body .= Text::_( 'COM_APPSCONDA_MOBILE_PASSWORD_RESET_SUCCESS_EMAIL_BODY_LINE_TWO' ) . ".\n\n";
					$mailfrom = $app->get( 'mailfrom' );
					$fromname = $app->get( 'fromname' );
					$mailer = Factory::getMailer();
					$mailer->setSender(
						array(
							$mailfrom,
							$fromname
						)
					);
					$mailer->addRecipient( $recipient );
					$mailer->setSubject( $subject );
					$mailer->setBody( $body );
					$send = $mailer->send();

					header( 'Content-Type: application/json' );
					http_response_code( 200 );
					$result = array(
						'result' => 'success',
						'message' => Text::_( 'COM_APPSCONDA_MOBILE_PASSWORD_RESET_SUCCESS' )
					);
					echo json_encode( $result );
					jexit();
				} else {
					header( 'Content-Type: application/json' );
					http_response_code( 403 );
					$result = array(
						'result' => 'error',
						'message' => Text::_( 'COM_APPSCONDA_MOBILE_PASSWORD_RESET_FAILED' )
					);
					echo json_encode( $result );
					jexit();
				}
			} else {
				header( 'Content-Type: application/json' );
				http_response_code( 403 );
				$result = array(
					'result' => 'error',
					'message' => Text::_( 'COM_APPSCONDA_MOBILE_VERIFICATION_CODE_NO_MATCH' )
				);
				echo json_encode( $result );
				jexit();
			}

		}

	}

	function mobileappadmincheckin() {

		$response = array(
			'admincheckheadingtext' => Text::_( 'QR_SCANNING_HEADING' ),
			'buttontext' => Text::_( 'QR_SCANNING_BUTTON_TEXT' )
		);

		header( 'Content-Type: application/json' );

		echo json_encode( $response );

		jexit();

	}

	function mobileappmenucustompagesdetail() {

		$json_str = file_get_contents( 'php://input' );

		$json_obj = json_decode( $json_str, true );
		$db = Factory::getDbo();

		if ( isset( $json_obj ) ) {

			$custompageid = $json_obj[ 'custompageid' ];

			$query = $db->getQuery( true )->select( '*' )->from( $db->quoteName( '#__appsconda_custompages' ) )->where( $db->quoteName( 'id' ) . ' = ' . $db->quote( $custompageid ) );

			$db->setQuery( $query );
			$results = $db->loadAssocList();

			$output = array();
			if ( !empty( $results ) ) {
				$firstRow = $results[ 0 ];
				foreach ( $firstRow as $column => $value ) {
					$output[ $column ] = ( !empty( $value ) ) ? $value : "";
				}
			}

			$baseURL = Uri::base();

			foreach ( $output as $key => $value ) {
				if ( strpos( $key, 'image' ) === 0 ) {
					$output[ $key ] = ( !empty( $value ) ) ? $baseURL . $value : "";
				}
			}

			header( 'Content-Type: application/json' );

			echo json_encode( $output, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES );

			jexit();

		}

	}

	function mobileappmenuarticles() {

		$db = Factory::getDbo();
		$query = $db->getQuery( true );

		$query->select( $db->quoteName( 'menu3contentid' ) );
		$query->from( $db->quoteName( '#__appsconda_drawermenus' ) );

		$db->setQuery( $query );
		$menu3contentids = $db->loadColumn();

		$items = [];

		if ( !empty( $menu3contentids ) ) {

			$query = $db->getQuery( true );
			$query->select( '*' );
			$query->from( $db->quoteName( '#__content' ) );
			$query->where( $db->quoteName( 'catid' ) . ' IN (' . implode( ',', $menu3contentids ) . ')' );
			$query->order( $db->quoteName( 'publish_up' ) . ' DESC' );
			$db->setQuery( $query );
			$results = $db->loadAssocList();

			foreach ( $results as $result ) {

				$content = $result[ 'introtext' ] . $result[ 'fulltext' ];

				$content = strip_tags( $content );
				$content = preg_replace( '/\R+/u', "\r\n\r\n", $content );

				$content = trim( $content );

				$content = htmlspecialchars( $content );

				$images = json_decode( $result[ 'images' ], true );
				$introimage = '';
				$fullimage = '';

				if ( isset( $images[ 'image_intro' ] ) && !empty( $images[ 'image_intro' ] ) ) {
					$introimage = Uri::base() . $images[ 'image_intro' ];
				}

				if ( isset( $images[ 'image_fulltext' ] ) && !empty( $images[ 'image_fulltext' ] ) ) {
					$fullimage = Uri::base() . $images[ 'image_fulltext' ];
				}

				$item = [
					'id' => $result[ 'id' ],
					'title' => $result[ 'title' ],
					'content' => $content,
					'publish_up' => $result[ 'publish_up' ],
					'introimage' => $introimage,
					'fullimage' => $fullimage
				];

				$items[] = $item;
			}
		}

		$queryforarticlesnumber = $db->getQuery( true )->select( 'COUNT(*)' )->from( '#__content' )->where( $db->quoteName( 'catid' ) . ' IN (' . implode( ',', $menu3contentids ) . ')' );

		$db->setQuery( $queryforarticlesnumber );
		$numberofarticles = $db->loadResult();
		$havearticles = !empty( $numberofarticles );

		$response = array(
			'noarticlesmsg' => Text::_( 'NO_ARTICLES' ),
			'havearticles' => $havearticles ? true : false,
			'result' => $items
		);

		header( 'Content-Type: application/json' );

		echo json_encode( $response );

		jexit();

	}

	function mobileappmenuarticlestwo() {

		$db = Factory::getDbo();
		$query = $db->getQuery( true );

		$query->select( $db->quoteName( 'menu4contentid' ) );
		$query->from( $db->quoteName( '#__appsconda_drawermenus' ) );

		$db->setQuery( $query );
		$menu4contentids = $db->loadColumn();

		$items = [];

		if ( !empty( $menu4contentids ) ) {

			$query = $db->getQuery( true );
			$query->select( '*' );
			$query->from( $db->quoteName( '#__content' ) );
			$query->where( $db->quoteName( 'catid' ) . ' IN (' . implode( ',', $menu4contentids ) . ')' );
			$query->order( $db->quoteName( 'publish_up' ) . ' DESC' );
			$db->setQuery( $query );
			$results = $db->loadAssocList();

			foreach ( $results as $result ) {

				$content = $result[ 'introtext' ] . $result[ 'fulltext' ];

				$content = strip_tags( $content );
				$content = preg_replace( '/\R+/u', "\r\n\r\n", $content );

				$content = trim( $content );

				$content = htmlspecialchars( $content );

				$images = json_decode( $result[ 'images' ], true );
				$introimage = '';
				$fullimage = '';

				if ( isset( $images[ 'image_intro' ] ) && !empty( $images[ 'image_intro' ] ) ) {
					$introimage = Uri::base() . $images[ 'image_intro' ];
				}

				if ( isset( $images[ 'image_fulltext' ] ) && !empty( $images[ 'image_fulltext' ] ) ) {
					$fullimage = Uri::base() . $images[ 'image_fulltext' ];
				}

				$item = [
					'id' => $result[ 'id' ],
					'title' => $result[ 'title' ],
					'content' => $content,
					'publish_up' => $result[ 'publish_up' ],
					'introimage' => $introimage,
					'fullimage' => $fullimage
				];

				$items[] = $item;
			}
		}

		$queryforarticlesnumber = $db->getQuery( true )->select( 'COUNT(*)' )->from( '#__content' )->where( $db->quoteName( 'catid' ) . ' IN (' . implode( ',', $menu4contentids ) . ')' );

		$db->setQuery( $queryforarticlesnumber );
		$numberofarticles = $db->loadResult();
		$havearticles = !empty( $numberofarticles );

		$response = array(
			'noarticlesmsg' => Text::_( 'NO_ARTICLES' ),
			'havearticles' => $havearticles ? true : false,
			'result' => $items
		);

		header( 'Content-Type: application/json' );

		echo json_encode( $response );

		jexit();

	}

	function mobileappmenuarticlecategories() {

		$db = Factory::getDbo();

		$query = $db->getQuery( true );

		$query->select( $db->quoteName( 'menu5contentid' ) );
		$query->from( $db->quoteName( '#__appsconda_drawermenus' ) );

		$db->setQuery( $query );
		$menu5contentids = $db->loadColumn();
		$menu5contentids = array_filter( $menu5contentids );

		$query = $db->getQuery( true )->select( 'id, title, params' )->from( '#__categories' )->where( 'extension = ' . $db->quote( 'com_content' ) );

		if ( !empty( $menu5contentids ) ) {
			$query->where( 'id IN (' . implode( ',', $menu5contentids ) . ')' );
		}

		$db->setQuery( $query );
		$results = $db->loadAssocList();

		$items = array();
		foreach ( $results as $result ) {

			$images = json_decode( $result[ 'params' ], true );
			$categoryimage = '';

			if ( isset( $images[ 'image' ] ) && !empty( $images[ 'image' ] ) ) {
				$categoryimage = Uri::base() . $images[ 'image' ];
			}

			$category = array(
				'categoryid' => $result[ 'id' ],
				'categoryimage' => $categoryimage,
				'categorytitle' => $result[ 'title' ]
			);
			$items[] = $category;
		}

		$queryforcategorynumber = $db->getQuery( true )->select( 'COUNT(*)' )->from( '#__categories' )->where( 'extension = ' . $db->quote( 'com_content' ) );

		if ( !empty( $menu5contentids ) ) {
			$queryforcategorynumber->where( 'id IN (' . implode( ',', $menu5contentids ) . ')' );
		}

		$db->setQuery( $queryforcategorynumber );
		$numberofcategory = $db->loadResult();
		$havecategory = !empty( $numberofcategory );

		$response = array(
			'nocategorysmsg' => Text::_( 'NO_CATEGORIES' ),
			'havecategory' => $havecategory ? true : false,
			'result' => $items
		);

		header( 'Content-Type: application/json' );

		echo json_encode( $response );

		jexit();

	}

	function categoriesarticles() {

		$json_str = file_get_contents( 'php://input' );

		$json_obj = json_decode( $json_str, true );
		$db = Factory::getDbo();

		if ( isset( $json_obj ) ) {

			$categoryid = $json_obj[ 'categoryid' ];

			$items = [];

			if ( !empty( $categoryid ) ) {

				$query = $db->getQuery( true );
				$query->select( '*' );
				$query->from( $db->quoteName( '#__content' ) );
				$query->where( 'catid = ' . $db->quote( $categoryid ) );
				$query->order( $db->quoteName( 'publish_up' ) . ' DESC' );
				$db->setQuery( $query );
				$results = $db->loadAssocList();

				foreach ( $results as $result ) {

					$content = $result[ 'introtext' ] . $result[ 'fulltext' ];

					$content = strip_tags( $content );
					$content = preg_replace( '/\R+/u', "\r\n\r\n", $content );

					$content = trim( $content );

					$content = htmlspecialchars( $content );

					$images = json_decode( $result[ 'images' ], true );
					$introimage = '';
					$fullimage = '';

					if ( isset( $images[ 'image_intro' ] ) && !empty( $images[ 'image_intro' ] ) ) {
						$introimage = Uri::base() . $images[ 'image_intro' ];
					}

					if ( isset( $images[ 'image_fulltext' ] ) && !empty( $images[ 'image_fulltext' ] ) ) {
						$fullimage = Uri::base() . $images[ 'image_fulltext' ];
					}

					$item = [
						'articleid' => $result[ 'id' ],
						'title' => $result[ 'title' ],
						'content' => $content,
						'publish_up' => $result[ 'publish_up' ],
						'introimage' => $introimage,
						'fullimage' => $fullimage
					];

					$items[] = $item;
				}
			}

			$queryforarticlesnumber = $db->getQuery( true )->select( 'COUNT(*)' )->from( '#__content' )->where( 'catid = ' . $db->quote( $categoryid ) );;

			$db->setQuery( $queryforarticlesnumber );
			$numberofarticles = $db->loadResult();
			$havearticles = !empty( $numberofarticles );

			$response = array(
				'noarticlesmsg' => Text::_( 'NO_ARTICLES' ),
				'havearticles' => $havearticles ? true : false,
				'result' => $items
			);

			header( 'Content-Type: application/json' );

			echo json_encode( $response );

			jexit();

		}

	}

	function mobileappmenucontact() {

		$db = Factory::getDbo();
		$query = $db->getQuery( true );

		$query->select( $db->quoteName( 'menu6contentid' ) );
		$query->from( $db->quoteName( '#__appsconda_drawermenus' ) );

		$db->setQuery( $query );
		$menu6contentids = $db->loadColumn();

		$items = [];

		if ( !empty( $menu6contentids ) ) {

			$query = $db->getQuery( true );
			$query->select( '*' );
			$query->from( $db->quoteName( '#__contact_details' ) );
			$query->where( $db->quoteName( 'catid' ) . ' IN (' . implode( ',', $menu6contentids ) . ')' );
			$query->order( $db->quoteName( 'ordering' ) . ' ASC' );
			$db->setQuery( $query );
			$results = $db->loadAssocList();

			foreach ( $results as $result ) {

				$content = $result[ 'misc' ];

				$content = strip_tags( $content );
				$content = preg_replace( '/\R+/u', "\r\n\r\n", $content );

				$content = trim( $content );

				$content = htmlspecialchars( $content );

				$image = Uri::base() . $result[ 'image' ];

				$item = [
					'id' => $result[ 'id' ],
					'name' => $result[ 'name' ],
					'position' => $result[ 'con_position' ],
					'content' => $content,
					'image' => $image,
					'email' => $result[ 'email_to' ]
				];

				$items[] = $item;
			}
		}

		$queryforcontactsnumber = $db->getQuery( true )->select( 'COUNT(*)' )->from( '#__contact_details' )->where( $db->quoteName( 'catid' ) . ' IN (' . implode( ',', $menu6contentids ) . ')' );

		$db->setQuery( $queryforcontactsnumber );
		$numberofcontacts = $db->loadResult();
		$havecontacts = !empty( $numberofcontacts );

		$response = array(
			'sendemailtext' => Text::_( 'SEND_EMAIL' ),
			'nocontactsmsg' => Text::_( 'NO_CONTACTS' ),
			'havecontacts' => $havecontacts ? true : false,
			'results' => $items
		);

		header( 'Content-Type: application/json' );

		echo json_encode( $response );

		jexit();

	}

	function mobileappmenuevents() {

		$db = Factory::getDbo();
		$query = $db->getQuery( true );
		$query->select( $db->quoteName( 'menu7contentid' ) )->from( $db->quoteName( '#__appsconda_drawermenus' ) );
		$db->setQuery( $query );
		$menu7contentids = $db->loadColumn();
		$menu7contentids = array_filter( $menu7contentids );
		$items = [];
		$query = $db->getQuery( true );
		$query->select( '*' )->from( $db->quoteName( '#__eb_events' ) );
		if ( !empty( $menu7contentids ) ) {
			$query->where( $db->quoteName( 'main_category_id' ) . ' IN (' . implode( ',', $menu7contentids ) . ')' );
		}
		$query->where( $db->quoteName( 'event_date' ) . ' > ' . $db->quote( date( 'Y-m-d H:i:s' ) ) )->order( $db->quoteName( 'event_date' ) . ' ASC' );
		$db->setQuery( $query );
		$results = $db->loadAssocList();
		foreach ( $results as $result ) {
			$content = strip_tags( $result[ 'description' ] );
			$content = preg_replace( '/\R+/u', "\r\n\r\n", $content );
			$content = trim( $content );
			$content = htmlspecialchars( $content );
			$image = Uri::base() . $result[ 'image' ];
			$items[] = [
				'id' => $result[ 'id' ],
				'title' => $result[ 'title' ],
				'event_date' => $result[ 'event_date' ],
				'event_end_date' => $result[ 'event_end_date' ],
				'description' => $content,
				'cut_off_date' => $result[ 'cut_off_date' ],
				'registration_start_date' => $result[ 'registration_start_date' ],
				'image' => $image,
				'price_text' => $result[ 'price_text' ]
			];
		}
		$queryforeventsnumber = $db->getQuery( true )->select( 'COUNT(*)' )->from( '#__eb_events' );
		if ( !empty( $menu7contentids ) ) {
			$queryforeventsnumber->where( $db->quoteName( 'main_category_id' ) . ' IN (' . implode( ',', $menu7contentids ) . ')' );
		}
		$queryforeventsnumber->where( $db->quoteName( 'event_date' ) . ' > ' . $db->quote( $db->escape( date( 'Y-m-d H:i:s' ) ) ) );
		$db->setQuery( $queryforeventsnumber );
		$numberofevents = $db->loadResult();
		$haveevents = !empty( $numberofevents );
		$response = array(
			'registernowtext' => Text::_( 'REGISTER_NOW' ),
			'showregisterbutton' => true,
			'noeventsmsg' => Text::_( 'NO_EVENTS' ),
			'haveevents' => $haveevents ? true : false,
			'results' => $items
		);
		header( 'Content-Type: application/json' );
		echo json_encode( $response );
		jexit();

	}

	function mobileappmenushop() {

		$db = Factory::getDbo();

		$query = $db->getQuery( true );

		$query->select( $db->quoteName( 'menu8contentid' ) );
		$query->from( $db->quoteName( '#__appsconda_drawermenus' ) );

		$db->setQuery( $query );
		$menu8contentids = $db->loadColumn();
		$menu8contentids = array_filter( $menu8contentids );

		$query = $db->getQuery( true )->select( 'cd.category_id, cd.category_name, c.category_image, COUNT(pc.product_id) AS number_of_products' )->from( '#__eshop_categorydetails AS cd' )->join( 'LEFT', '#__eshop_categories AS c ON cd.category_id = c.id' )->join( 'LEFT', '#__eshop_productcategories AS pc ON cd.category_id = pc.category_id' )->group( 'cd.category_id' )->having( 'number_of_products > 0' )->order( 'number_of_products DESC' );

		if ( !empty( $menu8contentids ) ) {
			$query->where( 'cd.category_id IN (' . implode( ',', $menu8contentids ) . ')' );
		}

		$db->setQuery( $query );
		$results = $db->loadAssocList();

		$items = array();
		foreach ( $results as $result ) {

			if ( isset( $result[ 'category_image' ] ) && !empty( $result[ 'category_image' ] ) ) {
				$categoryimage = Uri::base() . 'media/com_eshop/categories/' . $result[ 'category_image' ];
			}

			$category = array(
				'categoryid' => $result[ 'category_id' ],
				'categoryimage' => $categoryimage,
				'numberofproducts' => $result[ 'number_of_products' ],
				'categorytitle' => $result[ 'category_name' ]
			);
			$items[] = $category;
		}

		$queryforshopnumber = $db->getQuery( true )->select( 'COUNT(pc.product_id) AS number_of_products' )->from( '#__eshop_categorydetails AS cd' )->join( 'LEFT', '#__eshop_categories AS c ON cd.category_id = c.id' )->join( 'LEFT', '#__eshop_productcategories AS pc ON cd.category_id = pc.category_id' )->group( 'cd.category_id' )->having( 'number_of_products > 0' )->order( 'number_of_products DESC' );

		$db->setQuery( $queryforshopnumber );
		$numberofshop = $db->loadResult();
		$haveshop = !empty( $numberofshop );

		$response = array(
			'noshopsmsg' => Text::_( 'COM_APPSCONDA_MOBILE_NO_PRODUCT' ),
			'haveshop' => $haveshop ? true : false,
			'results' => $items
		);

		header( 'Content-Type: application/json' );

		echo json_encode( $response );

		jexit();

	}

	function mobileappmenuforum() {

		$db = Factory::getDbo();
		$query = $db->getQuery( true )->select( 'id AS categoryid, name AS categorytitle, numTopics, last_post_time' )->from( '#__kunena_categories' )->where( 'numTopics > 0' );

		$db->setQuery( $query );
		$results = $db->loadAssocList();

		foreach ( $results as & $result ) {
			$result[ 'last_post_time' ] = Date::getInstance( $result[ 'last_post_time' ] )->format( 'Y-m-d H:i:s' );
		}

		$queryforkunenanumber = $db->getQuery( true )->select( 'COUNT(*)' )->from( '#__kunena_categories' )->where( 'numTopics > 0' );

		$db->setQuery( $queryforkunenanumber );
		$numberofkunena = $db->loadResult();
		$havekunena = !empty( $numberofkunena );

		$response = array(
			'lastposttext' => Text::_( 'LAST_POST' ),
			'postedontext' => Text::_( 'POSTED_ON' ),
			'postedbytext' => Text::_( 'POSTED_BY' ),
			'topicreplytext' => Text::_( 'REPLY' ),
			'showtopicreplybutton' => true,
			'nokunenamsg' => Text::_( 'NO_FORUM_FOUND' ),
			'havekunena' => $havekunena ? true : false,
			'results' => $results
		);

		header( 'Content-Type: application/json' );

		echo json_encode( $response );

		jexit();

	}

	function mobileappmenuvideos() {
		$db = Factory::getDbo();
		$query = $db->getQuery( true )->select( $db->quoteName( [ 'youtubeapikey', 'youtubechannelid' ] ) )->from( $db->quoteName( '#__appsconda_drawermenus' ) );
		$db->setQuery( $query );
		$youtuberesults = $db->loadObjectList();
		$youtubeapikey = $youtuberesults[ 0 ]->youtubeapikey;
		$youtubechannelid = $youtuberesults[ 0 ]->youtubechannelid;

		$apiUrl = 'https://www.googleapis.com/youtube/v3/search?part=snippet&channelId=' . $youtubechannelid . '&order=date&maxResults=50&key=' . $youtubeapikey;

		$response = file_get_contents( $apiUrl );
		$data = json_decode( $response, true );

		$output = array();
		if ( isset( $data[ 'items' ] ) ) {
			foreach ( $data[ 'items' ] as $item ) {

				if ( !empty( $item[ 'id' ][ 'videoId' ] ) ) {

					$videoId = $item[ 'id' ][ 'videoId' ];
					$title = $item[ 'snippet' ][ 'title' ];
					$description = $item[ 'snippet' ][ 'description' ];
					$thumbnail = $item[ 'snippet' ][ 'thumbnails' ][ 'default' ][ 'url' ];
					$fullThumbnail = $thumbnail;
					$publishedAt = date( 'Y-m-d', strtotime( $item[ 'snippet' ][ 'publishedAt' ] ) );

					if ( isset( $item[ 'snippet' ][ 'thumbnails' ][ 'high' ][ 'url' ] ) ) {
						$fullThumbnail = $item[ 'snippet' ][ 'thumbnails' ][ 'high' ][ 'url' ];
					}

					$videoUrl = 'https://www.youtube.com/watch?v=' . $videoId;

					$videoInfo = array(
						'videoId' => $videoId,
						'title' => $title,
						'description' => $description,
						'publishedAt' => $publishedAt,
						'videoUrl' => $videoUrl,
						'thumbnailUrl' => $thumbnail,
						'fullThumbnailUrl' => $fullThumbnail
					);

					$output[] = $videoInfo;
				}
			}
		} else {

		}

		$response = array(
			'novideomsg' => Text::_( 'COM_APPSCONDA_MOBILE_NO_VIDEOS' ),
			'havevideos' => isset( $data[ 'items' ] ) ? true : false,
			'results' => $output
		);

		header( 'Content-Type: application/json' );
		echo json_encode( $response );
		Factory::getApplication()->close();

	}


	function cartnumber()
		{
		    
$rawData = file_get_contents("php://input");
$data = json_decode($rawData, true);
$userid = isset($data['userid']) ? $data['userid'] : null;
$passwordraw = isset($data['password']) ? $data['password'] : null;
$deviceidlogin = isset($data['deviceidlogin']) ? $data['deviceidlogin'] : null;

            if (!empty($passwordraw) && !empty($userid) && !empty($deviceidlogin)) 
            {
                $options = array('remember' => true);
                $credentials['userid'] = $userid;
                $credentials['password'] = $passwordraw;
				$credentials['deviceidlogin'] = $deviceidlogin;
                $result = Factory::getApplication()->login($credentials, $options);
            }
        
                if ($result) {

                $db = Factory::getDbo();

$query = $db->getQuery(true)
    ->select('cart_data')
    ->from($db->quoteName('#__eshop_carts'))
    ->where($db->quoteName('customer_id') . ' = ' . $db->quote($userid));

$db->setQuery($query);
$hexValue = $db->loadResult();
	
$dataArray = json_decode($hexValue, true);
$totalProducts = 0;
foreach ($dataArray as $value) {
    $lastNumber = intval($value);
    $totalProducts += $lastNumber;
}
header('Content-Type: application/json');
	    http_response_code(200);
        $result = array(
            'number_of_products' => $totalProducts
        );
        echo json_encode($result);
        jexit();
} else {
    header('Content-Type: application/json');
	    http_response_code(200);
        $result = array(
            'number_of_products' => 0
        );
        echo json_encode($result);
        jexit();
}

}
	function productdetailspage()
		{
			$response = array(
				'viewcarttext' => Text::_('VIEW_CART_TEXT')
			);
			header('Content-Type: application/json');
			echo json_encode($response);
			jexit();
		}
	
	public function cartpage()
    {
        $jinput = Factory::getApplication()->input;
		$userid = Factory::getApplication()->input->cookie->get('userid', '', 'INT');
		$deviceidlogin = Factory::getApplication()->input->cookie->get('deviceidlogin', '', 'STRING');
		$passwordraw = Factory::getApplication()->input->cookie->get('password', '', 'STRING');
    
        $user = Factory::getUser();
        
        if ($user->guest) {

            if (!empty($passwordraw) && !empty($userid) && !empty($deviceidlogin)) {
        
                // Authenticate the user using the plugin
                $options = array('remember' => true);
                $credentials['userid'] = $userid;
                $credentials['password'] = $passwordraw;
				$credentials['deviceidlogin'] = $deviceidlogin;
                $result = Factory::getApplication()->login($credentials, $options);
        
                // Process the result
                if ($result) {
                    // User authenticated successfully
                    
                    
        
                $this->setRedirect("index.php?option=com_eshop&view=cart");
                    //Factory::getApplication()->close();
                } else {
                    // Authentication failed
                    $this->setRedirect("index.php?option=com_eshop&view=cart");
                    //Factory::getApplication()->close();
                }
                
        } else {
            $this->setRedirect("index.php?option=com_eshop&view=cart");
        }
    } else {
            // User was already loggedin
            $this->setRedirect("index.php?option=com_eshop&view=cart");
        }
    }

	function isjoomla() {
		header( 'Content-Type: application/json' );
		http_response_code( 200 );
		$result = array(
			'isjoomla' => true
		);
		echo json_encode( $result );
		jexit();
	}

	function joomlasignup() {

		$app = Factory::getApplication();
		$json_str = file_get_contents( 'php://input' );
		$json_obj = json_decode( $json_str, true );
		if ( isset( $json_obj ) ) {
			$name = $json_obj[ 'name' ];

			$email = $json_obj[ 'email' ];

			$password = bin2hex( random_bytes( 12 ) );
		}

		$data[ 'name' ] = $name;
		$data[ 'password' ] = $password;
		$data[ 'email' ] = $email;
		$data[ 'username' ] = $email;
		$params = ComponentHelper::getParams( 'com_users' );
		$data[ 'groups' ] = array();
		$data[ 'groups' ][] = $params->get( 'new_usertype', 2 );
		$user = new User;
		if ( !$user->bind( $data ) ) {
			header( 'Content-Type: application/json' );
			http_response_code( 403 );
			$result = array(
				'result' => 'error',
				'message' => $user->getError()
			);
			echo json_encode( $result );
			jexit();

		}
		if ( $user->save() ) {

			$app = Factory::getApplication();
			$recipient = $email;
			$subject = Text::_( 'COM_APPSCONDA_MOBILE_ACCOUNT_CREATED_SUCCESSFULLY_MAIL_SUBJECT' );
			$body = Text::_( 'COM_APPSCONDA_MOBILE_ACCOUNT_CREATED_SUCCESSFULLY_MAIL_BODY_1' ) . "\n\n";
			$body .= Text::_( 'COM_APPSCONDA_MOBILE_ACCOUNT_CREATED_SUCCESSFULLY_MAIL_BODY_2' ) . " " . $email . " .\n\n";
			$body .= Text::_( 'COM_APPSCONDA_MOBILE_ACCOUNT_CREATED_SUCCESSFULLY_MAIL_BODY_3' ) . " " . $password . " .\n\n";
			$mailfrom = $app->get( 'mailfrom' );
			$fromname = $app->get( 'fromname' );
			$mailer = Factory::getMailer();
			$mailer->setSender(
				array(
					$mailfrom,
					$fromname
				)
			);
			$mailer->addRecipient( $recipient );
			$mailer->setSubject( $subject );
			$mailer->setBody( $body );
			try {
				$send = $mailer->send();
				if ( $send === true ) {
					header( 'Content-Type: application/json' );
					http_response_code( 200 );
					$result = array(
						'result' => 'success',
						'message' => Text::_( 'COM_APPSCONDA_MOBILE_ACCOUNT_CREATED_AND_MAIL_SENT_SUCCESSFULLY' )
					);
					echo json_encode( $result );
					jexit();
				}
			} catch ( \Exception $e ) {

				header( 'Content-Type: application/json' );
				http_response_code( 200 );
				$result = array(
					'result' => 'success',
					'message' => Text::_( 'COM_APPSCONDA_MOBILE_ACCOUNT_CREATED_SUCCESSFULLY_BUT_MAIL_NOT_SENT' ) . ' . ' . $e->getMessage()
				);
				echo json_encode( $result );
				jexit();
			}

		} else {
			header( 'Content-Type: application/json' );
			http_response_code( 403 );
			$result = array(
				'result' => 'error',
				'message' => $user->getError()
			);
			echo json_encode( $result );
			jexit();
		}

	}

}

