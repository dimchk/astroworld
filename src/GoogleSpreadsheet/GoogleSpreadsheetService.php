<?php

namespace App\GoogleSpreadsheet;

use App\Entity\Order;
use Google_Client;
use Google_Service_Datastore;
use Google_Service_Datastore_Query;
use Google_Service_Datastore_RunQueryRequest;
use Google_Service_Sheets;
use Google_Service_Sheets_Spreadsheet;
use Google_Service_Sheets_ValueRange;
use Symfony\Component\Config\Definition\Exception\Exception;

class GoogleSpreadsheetService
{
    /**
     * Returns an authorized API client.
     * @return Google_Client the authorized client object
     * @throws Google_Exception
     */
    private function getClient()
    {
        $client = new Google_Client();
        $client->setApplicationName('Google Sheets API PHP Quickstart');
        $client->setScopes(Google_Service_Sheets::SPREADSHEETS_READONLY);
        $client->setAuthConfig(__DIR__ . '/credentials.json');
        $client->setAccessType('offline');
        $client->setPrompt('select_account consent');

        // Load previously authorized token from a file, if it exists.
        // The file token.json stores the user's access and refresh tokens, and is
        // created automatically when the authorization flow completes for the first
        // time.
        $tokenPath = '/token.json';
        if (file_exists(__DIR__ . '/' . $tokenPath)) {
            $accessToken = json_decode(file_get_contents(__DIR__ . '/' . $tokenPath), true);
            $client->setAccessToken($accessToken);
        }

        // If there is no previous token or it's expired.
        if ($client->isAccessTokenExpired()) {
            // Refresh the token if possible, else fetch a new one.
            if ($client->getRefreshToken()) {
                $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            } else {
                // Request authorization from the user.
                $authUrl = $client->createAuthUrl();
                printf("Open the following link in your browser:\n%s\n", $authUrl);
                print 'Enter verification code: ';
                $authCode = trim(fgets(STDIN));

                // Exchange authorization code for an access token.
                $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
                $client->setAccessToken($accessToken);

                // Check to see if there was an error.
                if (array_key_exists('error', $accessToken)) {
                    throw new Exception(join(', ', $accessToken));
                }
            }
            // Save the token to a file.
            if (!file_exists(dirname($tokenPath))) {
                mkdir(dirname($tokenPath), 0700, true);
            }
            file_put_contents($tokenPath, json_encode($client->getAccessToken()));
        }

        return $client;
    }

    public function createNewOrderRow(Order $order)
    {
        $client = $this->getClient();
        $service = new Google_Service_Sheets($client);
        $spreadsheetId = '1_0jESKknpOivlKpsinVfLlQu0jPmqIMcVjp3T4mrFwo';
        $range = 'A1';
        $valueRange = new Google_Service_Sheets_ValueRange();
        $valueRange->setValues([
            "values" => [
                $order->getClientName(),
                $order->getClientEmail(),
                $order->getService()->getProduct()->getName(),
                $order->getService()->getAstrologer()->getName(),
                $order->getService()->getPrice()
            ]
        ]); // Add two values
        $conf = ["valueInputOption" => "RAW"];

        $response = $service->spreadsheets_values->append($spreadsheetId, $range, $valueRange, $conf);

    }

}
