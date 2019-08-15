<?php

namespace App\Http\Controllers;
require base_path('/newpkg/autoload.php');
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Google_Client;
use Google_Service_Drive;
use Google_Service_Sheets;
use Google\Spreadsheet\ServiceRequestFactory;
use Google\Spreadsheet\DefaultServiceRequest;

class SecondAttempt extends Controller
{
    //
    function __construct()
    {
        $this->client = new Google_Client;
        // $this->client->setAuthConfig(Config::get('constants.GOOGLE_APPLICATION_CREDENTIALS'));
        $this->client->setAuthConfig(base_path('client_secret.json'));
        $this->client->addScope(Google_Service_Drive::DRIVE);

        $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/getsheet';
        $this->client->setRedirectUri($redirect_uri);

    if (isset($_GET['code'])) {
    $this->token = $this->client->fetchAccessTokenWithAuthCode($_GET['code']);
    }
    }

    function index(){
        $service = new Google_Service_Sheets($this->client); 
        
        $spreadsheetId = '1DjBRxhS3j3ZcZud8yiEctD_nblkMExKhn-8BMF_jpS8';
      $range = 'Sheet1!A2:E';
      $response = $service->spreadsheets_values->get($spreadsheetId, $range);
      $values = $response->getValues();
  
      if (empty($values)) {
          echo( "No data found");
      } else {
          dd($values);
          echo( "Name, Major");
          foreach ($values as $row) {
              // Print columns A and E, which correspond to indices 0 and 4.
              echo( $row[0] . ' '. $row[4]);
          }
  }
  
      }
}
