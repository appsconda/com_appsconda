<?php
/**
 * @package     com_appsconda
 * @version     1.0.0
 * @copyright   Copyright (C) 2023. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author     AppsConda ApS <support@appsconda.com> - https://appsconda.com
 */

namespace Joomla\Component\Appsconda\Site\Controller;

defined( '_JEXEC' )or die;

use Joomla\CMS\MVC\Controller\FormController;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;

class NotificationqueueController extends FormController {
	protected $view_list = 'notificationqueues';

	public

	function pushmanagement() {

		$db = Factory::getDbo();
		$app = Factory::getApplication();

		function fetchDevicesFromFirebase() {
			$app = Factory::getApplication();
			$db = Factory::getDbo();
			file_put_contents(__DIR__ . '/debug_log.txt', '');
			$lastRunFile = __DIR__ . '/last_run.txt';

			if ( !file_exists( $lastRunFile ) ) {
				$lastRunTimestamp = '1970-01-01T00:00:00Z';
			} else {
				$lastRunTimestamp = file_get_contents( $lastRunFile );
			}
			
			$lastRunTimestamp = strtotime( $lastRunTimestamp );
			
			$query = $db->getQuery( true );
			$query->select( $db->quoteName( 'firebasejson' ) )->from( $db->quoteName( '#__appsconda_mobileconfigs' ) )->where( $db->quoteName( 'id' ) . ' = 1' );
			$db->setQuery( $query );
			$firebasejson = $db->loadResult();
			$serviceAccount = json_decode( $firebasejson, true );
			$projectId = $serviceAccount['project_id'];

			$token = [
				'iss' => $serviceAccount[ 'client_email' ],
				'scope' => 'https://www.googleapis.com/auth/datastore',
				'aud' => 'https://www.googleapis.com/oauth2/v4/token',
				'exp' => time() + 3600,
				'iat' => time(),
			];
			$header = json_encode( [ 'alg' => 'RS256', 'typ' => 'JWT' ] );
			$claimSet = json_encode( $token );
			$signatureInput = base64_encode( $header ) . '.' . base64_encode( $claimSet );
			$privateKey = openssl_pkey_get_private( $serviceAccount[ 'private_key' ] );
			if ( !openssl_sign( $signatureInput, $signature, $privateKey, 'sha256' ) ) {
				while ( $msg = openssl_error_string() ) {
					echo $msg . "\n";
				}
				die( 'Failed to sign JWT' );
			}
			$jwt = $signatureInput . '.' . base64_encode( $signature );
			
			$tokenUrl = "https://www.googleapis.com/oauth2/v4/token";
			$tokenData = [
				'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
				'assertion' => $jwt,
			];
			$ch = curl_init( $tokenUrl );
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
			curl_setopt( $ch, CURLOPT_POST, true );
			curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query( $tokenData ) );
			curl_setopt( $ch, CURLOPT_HTTPHEADER, [ 'Content-Type: application/x-www-form-urlencoded' ] );
			$response = curl_exec( $ch );

			if ( curl_errno( $ch ) ) {
				die( 'Authentication Error: ' . curl_error( $ch ) );
			}

			$tokenResponse = json_decode( $response, true );
			
			if ( isset( $tokenResponse[ 'access_token' ] ) ) {
				$accessToken = $tokenResponse[ 'access_token' ];
			} else {
				die( 'Failed to obtain access token. Response: ' . $response );
			}
			
			$url = "https://firestore.googleapis.com/v1/projects/$projectId/databases/(default)/documents/users";
			$ch = curl_init( $url );
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
			curl_setopt( $ch, CURLOPT_HTTPHEADER, [
				'Authorization: Bearer ' . $accessToken,
				'Accept: application/json',
			] );
			$response = curl_exec( $ch );

			if ( curl_errno( $ch ) ) {
				die( 'Firestore Error: ' . curl_error( $ch ) );
			}
			$documents = json_decode( $response, true );
			if ( isset( $documents[ 'error' ] ) ) {
				die( 'Error in Firestore Response: ' . json_encode( $documents[ 'error' ] ) );
			}
			
			if ( !isset( $documents[ 'documents' ] ) ) {
				die( 'No documents found or an error occurred. Response: ' . json_encode( $documents ) );
			}

			$allResults = [];
			file_put_contents( __DIR__ . '/debug_log.txt', "Timestamp to compare: $lastRunTimestamp\n", FILE_APPEND );

			foreach ( $documents[ 'documents' ] as $document ) {
				file_put_contents( __DIR__ . '/debug_log.txt', "Processing document: " . json_encode( $document ) . "\n\n", FILE_APPEND );

				if ( isset( $document[ 'fields' ][ 'modified_time' ][ 'timestampValue' ] ) ) {
					$modifiedTimeStr = $document[ 'fields' ][ 'modified_time' ][ 'timestampValue' ];
					$modifiedTime = strtotime( $modifiedTimeStr );
					file_put_contents( __DIR__ . '/debug_log.txt', "Found modified_time: $modifiedTimeStr converted to $modifiedTime\n", FILE_APPEND );

					if ( !$modifiedTime ) {
						file_put_contents( __DIR__ . '/debug_log.txt', "Error: Failed to convert $modifiedTimeStr to timestamp. Skipping document.\n", FILE_APPEND );
						continue;
					}

					if ( $modifiedTime <= $lastRunTimestamp ) {
						file_put_contents( __DIR__ . '/debug_log.txt', "Skipping document as its modified time ($modifiedTime) is less than or equal to $lastRunTimestamp.\n", FILE_APPEND );
						continue;
					}
				} else {
					file_put_contents( __DIR__ . '/debug_log.txt', "Warning: modified_time field not found for a document. Processing it anyway.\n", FILE_APPEND );
				}
				$juserid = isset( $document[ 'fields' ][ 'juserid' ][ 'stringValue' ] ) ? $document[ 'fields' ][ 'juserid' ][ 'stringValue' ] : 'Not found';
				$push = isset( $document[ 'fields' ][ 'push' ][ 'booleanValue' ] ) ? $document[ 'fields' ][ 'push' ][ 'booleanValue' ] : 'Not found';
				$modifiedtime = isset( $document[ 'fields' ][ 'modified_time' ][ 'timestampValue' ] ) ? $document[ 'fields' ][ 'modified_time' ][ 'timestampValue' ] : 'Not found';
				$createdtime = isset( $document[ 'fields' ][ 'created_time' ][ 'timestampValue' ] ) ? $document[ 'fields' ][ 'created_time' ][ 'timestampValue' ] : 'Not found';
				$email = isset( $document[ 'fields' ][ 'email' ][ 'stringValue' ] ) ? $document[ 'fields' ][ 'email' ][ 'stringValue' ] : 'Not found';

				$userDocumentPath = $document[ 'name' ];
				$fcmTokensUrl = "https://firestore.googleapis.com/v1/$userDocumentPath/fcm_tokens";

				$ch = curl_init( $fcmTokensUrl );
				curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
				curl_setopt( $ch, CURLOPT_HTTPHEADER, [
					"Authorization: Bearer $accessToken",
					'Content-Type: application/json',
				] );
				$fcmTokensResponse = curl_exec( $ch );

				if ( curl_errno( $ch ) ) {
					echo 'Error fetching fcm_tokens: ' . curl_error( $ch ) . "\n";
					continue;
				}

				$fcmTokens = json_decode( $fcmTokensResponse, true );

				if ( json_last_error() !== JSON_ERROR_NONE ) {
					echo "Error decoding JSON for juserid: $juserid\n";
					continue;
				}

				if ( !isset( $fcmTokens[ 'documents' ] ) || !is_array( $fcmTokens[ 'documents' ] ) ) {
					continue;
				}

				foreach ( $fcmTokens[ 'documents' ] as $fcmDocument ) {
					$devicetoken = isset( $fcmDocument[ 'fields' ][ 'fcm_token' ][ 'stringValue' ] ) ?
						$fcmDocument[ 'fields' ][ 'fcm_token' ][ 'stringValue' ] :
						'Not found';

					$allResults[] = [
						'juserid' => $juserid,
						'email' => $email,
						'push' => $push,
						'created_time' => $createdtime,
						'modified_time' => $modifiedtime,
						'devicetoken' => $devicetoken

					];
				}
			}
			//echo json_encode( $allResults, JSON_PRETTY_PRINT );
			$app->enqueueMessage( count($allResults). ' ' . Text::_( 'RECORDS_FETCHED_FROM_FIREBASE' ), 'message' );
			file_put_contents( $lastRunFile, gmdate( 'Y-m-d\TH:i:s\Z' ) );
			curl_close( $ch );
			
			foreach ( $allResults as $record ) {
				$query = $db->getQuery( true );

				// Define the columns and values
				$columns = [ 'juserid', 'push', 'created_time', 'modified_time', 'devicetoken', 'created_by', 'state', 'ordering' ];

				$values = [
					$db->quote( $record[ 'juserid' ] ),
					$db->quote( $record[ 'push' ] ? 'true' : 'false' ),
					$db->quote( $record[ 'created_time' ] ),
					$db->quote( $record[ 'modified_time' ] ),
					$db->quote( $record[ 'devicetoken' ] ),
					0,
					1,
					0
				];

				// Prepare the INSERT statement
				$query
					->insert( $db->quoteName( '#__appsconda_mobiledevices' ) )->columns( $db->quoteName( $columns ) )->values( implode( ',', $values ) );

				// Execute the query
				$db->setQuery( $query );
				$db->execute();
			}

		}
		
		fetchDevicesFromFirebase();

		function sendMessageViaFCM( $title, $message, $cleanimageurl ) {
			$app = Factory::getApplication();

			$db = Factory::getDbo();
			$query = $db->getQuery( true );
			$query->select( $db->quoteName( 'firebasejson' ) )->from( $db->quoteName( '#__appsconda_mobileconfigs' ) )->where( $db->quoteName( 'id' ) . ' = 1' );
			$db->setQuery( $query );
			$firebasejson = $db->loadResult();

			$serviceAccount = json_decode( $firebasejson, true );
			$projectId = $serviceAccount['project_id'];

			$token = [
				'iss' => $serviceAccount[ 'client_email' ],
				'scope' => 'https://www.googleapis.com/auth/firebase.messaging',
				'aud' => 'https://www.googleapis.com/oauth2/v4/token',
				'exp' => time() + 3600,
				'iat' => time(),
			];

			$header = json_encode( [ 'alg' => 'RS256', 'typ' => 'JWT' ] );
			$claimSet = json_encode( $token );

			$signatureInput = base64_encode( $header ) . '.' . base64_encode( $claimSet );

			$privateKey = openssl_pkey_get_private( $serviceAccount[ 'private_key' ] );
			if ( !openssl_sign( $signatureInput, $signature, $privateKey, 'sha256' ) ) {
				while ( $msg = openssl_error_string() ) {
					echo $msg . "\n";
				}
				$app->enqueueMessage( Text::_( 'FAILED_TO_SIGN_JWT_PUSH_NOT_SENT' ), 'error' );
				return false;
			}
			$jwt = $signatureInput . '.' . base64_encode( $signature );

			$tokenData = [
				'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
				'assertion' => $jwt,
			];

			$ch = curl_init( 'https://www.googleapis.com/oauth2/v4/token' );
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
			curl_setopt( $ch, CURLOPT_POST, true );
			curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query( $tokenData ) );
			curl_setopt( $ch, CURLOPT_HTTPHEADER, [ 'Content-Type: application/x-www-form-urlencoded' ] );
			$response = curl_exec( $ch );

			if ( curl_errno( $ch ) ) {
				$app->enqueueMessage( Text::_( 'AUTHENTICATION_ERROR_PUSH_NOT_SENT' ), 'error' );
				return false;
			}

			$tokenResponse = json_decode( $response, true );
			if ( isset( $tokenResponse[ 'access_token' ] ) ) {
				$accessToken = $tokenResponse[ 'access_token' ];
			} else {
				$app->enqueueMessage( Text::_( 'FAILED_TO_OBTAIN_ACCESS_TOKEN_PUSH_NOT_SENT' ), 'error' );
				return false;
			}

			$query = $db->getQuery( true )->select( $db->quoteName( 'notification_id' ) )->from( $db->quoteName( '#__appsconda_notificationqueues' ) )->where( $db->quoteName( 'send_date' ) . ' < NOW()' )->setLimit( 1 );
			$db->setQuery( $query );

			$notificationID = $db->loadResult();

			$tokenArray = [];
			$idsToDelete = [];
			$messagePayload = [];
			$records = [];

			if ( $notificationID ) {
				$recordsQuery = $db->getQuery( true )->select( '*' )->from( $db->quoteName( '#__appsconda_notificationqueues' ) )->where( $db->quoteName( 'send_date' ) . ' < NOW()' )->where( $db->quoteName( 'notification_id' ) . ' = ' . $db->quote( $notificationID ) )->setLimit( 450 );
				$db->setQuery( $recordsQuery );

				$records = $db->loadObjectList();

				foreach ( $records as $record ) {
					$token = $record->token;
					$idToDelete = $record->id;

					$messagePayload = [
						'message' => [
							'notification' => [
								'title' => $record->title,
								'body' => $record->body,
								'image' => $record->image
							],
							'token' => $token,
						],
					];

					$ch = curl_init( "https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send" );
					curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
					curl_setopt( $ch, CURLOPT_POST, true );
					curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $messagePayload ) );
					curl_setopt( $ch, CURLOPT_HTTPHEADER, [
						'Content-Type: application/json',
						"Authorization: Bearer $accessToken",
					] );

					$response = curl_exec( $ch );
					if ( curl_errno( $ch ) ) {
						$app->enqueueMessage( curl_error( $ch ), 'error' );
					}

					if ( !empty( $idToDelete ) ) {
						$deleteQuery = $db->getQuery( true )->delete( $db->quoteName( '#__appsconda_notificationqueues' ) )->where( $db->quoteName( 'id' ) . ' = ' . $db->quote( $idToDelete ) );
						$db->setQuery( $deleteQuery );
						$db->execute();
					}

				}
				
				$app->enqueueMessage( count($records) . ' ' . Text::_( 'PUSH_TO_BE_SENT_SUCCESSFULLY' ), 'message' );

				return true;

			}
			$app->enqueueMessage( count($records) . ' ' . Text::_( 'PUSH_TO_BE_SENT_SUCCESSFULLY' ), 'message' );


		}

		if ( sendMessageViaFCM( $title, $message, $cleanimageurl ) ) {

			//$app->enqueueMessage( Text::_( 'PUSH_SENT_SUCCESSFULLY' ), 'message' );

		}




	}
}