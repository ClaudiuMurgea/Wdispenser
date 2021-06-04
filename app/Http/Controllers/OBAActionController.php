<?php

namespace App\Http\Controllers;

use App\Models\OBAction;
use Illuminate\Http\Request;

class OBAActionController extends Controller
{
    public function index(){
        return response()->json(OBAction::all());
    }

    public function checkForNewActions()
    {
        $newActions = OBAction::all();
        $actionsArray = $newActions->toArray();

        if (!empty($actionsArray)) {
            foreach ($actionsArray as $actionData) {
                // add
                if ($actionData['ActionEnum'] == 'Add') {
                    $dataAfter = json_decode($actionData['DataAfter'], true);

                    $response = $this->apiPostCustomer($dataAfter, $responseData);

                    print_r($responseData);

                    if ($response) {
                        // clear action
                        $this->deleteObAction($actionData['ID']);
                    } else {

                    }
                }

                // edit
                if ($actionData['ActionEnum'] == 'Edit') {
                    $dataBefore = json_decode($actionData['DataBefore'], true);
                    $dataAfter = json_decode($actionData['DataAfter'], true);

                    // flag 5 change
                    if ($dataBefore['Flags5'] != $dataAfter['Flags5']) {
                        if ($dataBefore['Flags5'] == 0 && $dataAfter['Flags5'] == 1) { // client request online account after
                            if ($this->apiPostCustomer($dataAfter)) {
                                // clear action

                                $this->deleteObAction($actionsArray['ID']);
                            }
                        }

                        if ($dataBefore['Flags5'] == 1 && $dataAfter['Flags5'] == 0) { // client request online account to be removed
                            if ($this->apiDeleteCustomer($dataAfter)) {
                                // clear action
                            }
                        }
                    } else {
                        // update customer
                        if ($this->apiPutCustomer($dataAfter)) {
                            // clear action
                        }
                    }

                }

                // delete
                if ($actionData['ActionEnum'] == 'Delete') {
                    if ($this->apiDeleteCustomer($dataAfter)) {
                        // clear action
                    }
                }

                // undo delete
                if ($actionData['ActionEnum'] == 'UndoDelete') {

                }
            }
        }

        return;
    }

    private function apiPostCustomer($customerData, &$responseData){
        $postDataArray = [
            "customerIdType"        => $customerData['IDCardType'] == 0 ? 'CNP' : '',
            "customerIdCode"        => $customerData['IDCardSerial'],
            "customerIdCodeNew"     => $customerData['IDCardSerial'],
            "customerLastName"      => $customerData['Name'],
            "customerFirstName"     => $customerData['Firstname'],
            "customerNickName"      => $customerData['Nickname'],
            "customerGender"        => $customerData['Gender'],
            "customerBirthDate"     => $customerData['BirthDate'],
            "customerPhoneMobile"   => $customerData['Mobile'],
            "customerEmail"         => $customerData['Mail'],
            "addressCity"           => $customerData['Town'],
            "addressCountry"        => $customerData['Country'],
            "addressStreetName"     => $customerData['StreetAddress'],
            "addressStreetnumber"   => $customerData['StreetAdditional'],
            "addressZipCode"        => $customerData['ZIPCode']
        ];

        $response = Http::withHeaders(["Content-Type" => "application/json"])->post(env('PER_API_URL') . '/api/customer/add', $postDataArray);
        $responseData = $response->json();

        if($response->successful()){
            return true;
        }
        else{
            return false;
        }
    }

    private function apiPutCustomer($customerData){
        $postDataArray = [
            "customerIdType"        => $customerData['IDCardType'] == 0 ? 'CNP' : '',
            "customerIdCode"        => $customerData['IDCardSerial'],
            "customerIdCodeNew"     => $customerData['IDCardSerial'],
            "customerLastName"      => $customerData['Name'],
            "customerFirstName"     => $customerData['Firstname'],
            "customerNickName"      => $customerData['Nickname'],
            "customerGender"        => $customerData['Gender'],
            "customerBirthDate"     => $customerData['BirthDate'],
            "customerPhoneMobile"   => $customerData['Mobile'],
            "customerEmail"         => $customerData['Mail'],
            "addressCity"           => $customerData['Town'],
            "addressCountry"        => $customerData['Country'],
            "addressStreetName"     => $customerData['StreetAddress'],
            "addressStreetnumber"   => $customerData['StreetAdditional'],
            "addressZipCode"        => $customerData['ZIPCode']
        ];

        $response = Http::withHeaders(["Content-Type" => "application/json"])->post(env('PER_API_URL') . '/api/customer/update', $postDataArray);
        $responseData = $response->json();

        if($response->successful()){
            return true;
        }
        else{
            return false;
        }
    }

    private function apiDeleteCustomer(){

    }

    private function deleteObAction($idx){
        //OBAction::destroy($idx);

        DB::table('MasterOnlyDB.OB_Actions')->where('ID', '=', $idx)->delete();
    }
}
