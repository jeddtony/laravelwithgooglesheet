<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

use Google_Client;
use Google_Service_Drive;
use Google_Service_Sheets;
use Google_Service_Sheets_ValueRange;

/**
 * Main GoogleSheetController 
 * 
 * @category Controller
 * @package LaravelwithGoogleSheet
 * 
 */
class GoogleSheetController extends Controller
{
    private $client;
    private $token;
    private $service;
    private $spreadsheetId;
    /**
     * prepare preset data
     *
     * @author Jed Tony
     */
    public function __construct()
    {
        $this->client = new Google_Client();
        $this->client->setAuthConfig(Config::get('constants.googlesheet_credential'));
        // $this->client->setAuthConfig(base_path('client_secret.json'));
        $this->client->addScope(Google_Service_Drive::DRIVE);
        
        $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/getsheet';
        $this->client->setRedirectUri($redirect_uri);

        if (isset($_GET['code'])) {
            $this->token = $this->client->fetchAccessTokenWithAuthCode($_GET['code']);
        }

        $this->service = new Google_Service_Sheets($this->client);
        // $this->spreadsheetId = '1DjBRxhS3j3ZcZud8yiEctD_nblkMExKhn-8BMF_jpS8';
        $this->spreadsheetId = '1xDwcZwue56DsRPkCdVVwDrWAcivqmSP7wRp8VDpQM1Q';
    }

    /** 
     * Displays all the names in the sheet
     * 
     * @return list
     */
    public function index()
    {
      
        $range = 'Sheet1!A2:H';
        $response = $this->service->spreadsheets_values->get($this->spreadsheetId, $range);
        $legislators = $response->getValues();

        if (empty($legislators)) {
            //    return  view('showList', "No data found");
            dd('No data found');
        } else {
            // return view('showList', compact('legislators'));
            dd($legislators);
        }
    }

    /**
     * Updates a values in the field 
     * 
     * @return integer
     */
    public function update()
    {
        $range = 'Sheet1!A2:F';
        $values = [
            ["Item", "Cost", "Stocked", "Ship Date"],
            ["Wheel", "$20.50", "4", "3/1/2016"],
            ["Door", "$15", "2", "3/15/2016"],
            ["Engine", "$100", "1", "3/20/2016"],
        ];
        $body = new Google_Service_Sheets_ValueRange([
            'values' => $values
        ]);
        $valueInputOption = 'RAW';
        $params = [
            'valueInputOption' => $valueInputOption
        ];
        $response = $this->service->spreadsheets_values->update($this->spreadsheetId, $range, $body, $params);
        dd($response->getUpdatedCells());
    }

    /**
     * Inserts the New values to the sheet
     * 
     * @return integer
     */

    public function insert()
    {
        $range = 'Sheet1!A2:F';
        $values = [
            ["Mite", "Cost", "Stocked", "Ship Date"],
            ["Eel", "$20.50", "4", "3/1/2019"],
            ["Rod", "$15", "2", "3/15/2019"],
            ["Engine", "$100", "1", "3/20/2019"],
        ];
        $body = new Google_Service_Sheets_ValueRange([
            'values' => $values,

        ]);
        $valueInputOption = 'RAW';
        $params = [
            'valueInputOption' => $valueInputOption
        ];
        $response = $this->service->spreadsheets_values->append($this->spreadsheetId, $range, $body, $params);
        dd($response->getUpdates()->getUpdatedCells());
    }
}
