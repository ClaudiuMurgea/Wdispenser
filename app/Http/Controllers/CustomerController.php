<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomerController extends Controller{
    public function index(){
        return response()->json(Customer::all());
    }

    public function getCustomer($type, $id){
        if(strtolower(trim($type)) !== 'cnp' || empty($id)){
            return response()->json(['message' => 'Invalid or missing customer unique identifier!'], 422);
        }

        $customerExist = $this->getCustomerByUniqeReference($type, $id);

        if(empty($customerExist)){
            return response()->json(['message' => 'Resource not found!'], 422);
        }
        else{
            return response()->json($customerExist, 200);
        }
    }

    public function addCustomer(Request $request){
        $customerIdType = $request->get('customerIdType') ?? 'CNP';
        $customerIdCode = trim($request->get('customerIdCode')) ?? 0;

        if($customerIdCode == 0){
            return response()->json(['message' => 'Missing customer unique identifier!'], 422);
        }

        $customerExist = $this->getCustomerByUniqeReference($customerIdType, $customerIdCode);
        $customerExist = json_decode(json_encode($customerExist), true);

        if(empty($customerExist)){// customer not found: save it
            $insertedId = DB::select("select(MasterOnlyDB.MasterOnlyAddCustomer(
                'OnlineBetting',
                '0',
                '0',
                '',
                '1',
                '',
                '',
                '" . $request->get('customerFirstName') . "',
                '" . $request->get('customerLastName') . "',
                '" . $request->get('customerNickName') . "',
                '" . $request->get('customerBirthDate') . "',
                '" . $request->get('customerGender') . "',
                '0',
                '{$customerIdCode}',
                '" . $request->get('addressStreetName') . "',
                '" . $request->get('addressZipCode') . "',
                '" . $request->get('addressStreetnumber') . "',
                '" . $request->get('addressCity') . "',
                '" . $request->get('addressCountry') . "',
                '" . $request->get('customerPhoneMobile') . "',
                '" . $request->get('customerEmail') . "',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '1',
                '0',
                '0',
                '1',
                '00000000'
            )) as insertedId");

            if(!empty($insertedId[0]->insertedId)){
                return response()->json(['message' => 'Customer recorded', 'inserted_id' => $insertedId[0]->insertedId], 201);
            }
            else{
                return response()->json(['message' => 'Customer not recorded'], 500);
            }
        }
        else{
            $customerData = [
                'idx'           => $customerExist['EntryID'],
                'creation_date' => $customerExist['CreationDate'],
                'first_name'    => $customerExist['CreationDate'],
                'last_name'     => $customerExist['Name'],
                'id_card_serial'=> $customerExist['IDCardSerial'],
                'addr_street'   => $customerExist['StreetAddress'],
                'addr_city'     => $customerExist['Town']
            ];

            return response()->json(['message' => 'Customer already recorded', 'customer_data' => $customerData], 409);
        }
    }

    public function updateCustomer(Request $request){
        $customerIdType = $request->get('customerIdType') ?? 'CNP';
        $customerIdCode = trim($request->get('customerIdCode')) ?? 0;

        if($customerIdCode == 0){
            return response()->json(['Missing customer unique identifier!'], 422);
        }

        $customerExist = $this->getCustomerByUniqeReference($customerIdType, $customerIdCode);
        $customerExist = json_decode(json_encode($customerExist), true);

        if(!empty($customerExist)){// customer found: update
            $updatedId = DB::select("select(MasterOnlyDB.MasterOnlyEditCustomer(
                'OnlineBetting',
                'EntryID',
                '{$customerExist['EntryID']}',
                '{$customerIdCode}',
                0,
                '1',
                '1',
                '',
                '',
                '" . $request->get('customerLastName') . "',
                '" . $request->get('customerFirstName') . "',
                '" . $request->get('customerNickName') . "',
                '" . $request->get('customerBirthDate') . "',
                '" . $request->get('customerGender') . "',
                '0',
                '{$customerIdCode}',
                '" . $request->get('addressStreetName') . "',
                '" . $request->get('addressZipCode') . "',
                '" . $request->get('addressStreetnumber') . "',
                '" . $request->get('addressCity') . "',
                '" . $request->get('addressCountry') . "',
                '" . $request->get('customerPhoneMobile') . "',
                '" . $request->get('customerEmail') . "',
                '0',
                '0',
                '0',
                '0',
                '1',
                '0',
                '1',
                '0',
                '0',
                '1',
                '00000000'
            )) as updatedId");

            if(!empty($updatedId[0]->updatedId)){
                return response()->json(['message' => 'Customer updated!', 'updated_id' => $updatedId[0]->updatedId], 200);
            }
            else{
                return response()->json(['message' => 'Customer not updated'], 500);
            }
        }
        else{// customer not found: return error
            return response()->json(['message' => 'Resource not found!'], 422);
        }
    }

    private function getCustomerByUniqeReference($reference, $uniqueQuee){
        if(strtolower(trim($reference)) == 'cnp') {
            $query = "SELECT * FROM PlayerTracking.Customers WHERE IDCardType=0 AND IDCardSerial={$uniqueQuee} LIMIT 1";
        }

        $customer = DB::select($query)[0] ?? null;

        return $customer;
    }
}
