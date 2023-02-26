<?php

namespace App\Http\Controllers\Api;


use App\Models\Employee;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Hash;
use Session;

class EmployeeController extends Controller
{
    protected $apiResponse;
    public function __construct(ApiResponse $apiResponse) {
        $this->apiResponse = $apiResponse;
    }

    public function getAllEmployees(){
        try {
            $employees = Employee::all();
            if($employees->count() > 0){
                return $this->apiResponse->responseWithStatusAndMessage(200,$employees);
            }
            else {
                return response()->json(['status' => 404, 'message' => 'No employees found'], 404);
            }
        } catch (\Exception $e) {
            return $this->apiResponse->responseWithStatusAndMessage(500, 'Something went wrong.');
        }
    }

    public function addNewEmployee(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'employee_id' => 'required|string|max:191',
                'firstName' => 'required|string|max:191',
                'lastName' => 'required|string|max:191',
                'username' => 'required|string|unique:employee,username',
                'email' => 'required|email|max:191',
                'contactNo' => 'required|digits:10',
                'password' => 'required|string|min:8|max:191',
            ]);

            if ($validator->fails()) {
                return $this->apiResponse->responseWithStatusAndMessage(422, $validator->messages()->all());
            } else {
                $employee = Employee::create([
                    'employee_id' => $request->employee_id,
                    'firstName' => $request->firstName,
                    'lastName' => $request->lastName,
                    'username' => $request->username,
                    'email' => $request->email,
                    'contactNo' => $request->contactNo,
                    'password' => bcrypt($request->password)
                ]);

                if ($employee) {
                    return $this->apiResponse->responseWithStatusAndMessage(200);
                } else {
                    return $this->apiResponse->responseWithStatusAndMessage(500);
                }
            }
        } catch (\Exception $e) {
            return $this->apiResponse->responseWithStatusAndMessage(500);
        }
    }

    public function getEmployee($id){
        try {
            $employee = Employee::find($id);
            if($employee){
                return $this->apiResponse->responseWithStatusAndMessage(200,$employee);
            } else {
                return $this->apiResponse->responseWithStatusAndMessage(404);
            }
        } catch (\Exception $e) {
            return $this->apiResponse->responseWithStatusAndMessage(500, 'Something went wrong.');
        }
    }

    public function editEmployee($id){
        return $this->getEmployee($id);
    }

    public function updateEmployee(Request $request, int $id){
        try {
            $validator = Validator::make($request->all(), [
                'employee_id' => 'required|string|max:191',
                'firstName' => 'required|string|max:191',
                'lastName' => 'required|string|max:191',
                'username' => 'required|string|max:191',
                'email' => 'required|email|max:191',
                'contactNo' => 'required|digits:10',
                'password' => 'required|string|max:191',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => 422,
                    'errors' => $validator->messages(),
                ], 422);
            } else {
                $employee = Employee::find($id);
                if ($employee) {
                    $employee->update([
                        'employee_id' => $request->employee_id,
                        'firstName' => $request->firstName,
                        'lastName' => $request->lastName,
                        'username' => $request->username,
                        'email' => $request->email,
                        'contactNo' => $request->contactNo,
                        'password' => bcrypt($request->password)
                    ]);
                    return $this->apiResponse->responseWithStatusAndMessage(200);
                } else {
                    return $this->apiResponse->responseWithStatusAndMessage(404);
                }
            }
        } catch (\Exception $e) {
            return $this->apiResponse->responseWithStatusAndMessage(500);
        }
    }

    public function deleteEmployee($id){
        try {
            $employee = Employee::find($id);
            if($employee){
                $employee->delete();
                return $this->apiResponse->responseWithStatusAndMessage(200);

            } else {
                return $this->apiResponse->responseWithStatusAndMessage(404);
            }
        } catch (\Exception $e) {
            return $this->apiResponse->responseWithStatusAndMessage(500);
        }
    }

    public function employeeLogin(Request $request){

        try {
            $validator = Validator::make($request->all(), [
                'username' => 'required|string|max:191',
                'password' => 'required|string|max:191',
            ]);
            
            if ($validator->fails()) {
                return response()->json([
                    'status' => 422,
                    'errors' => $validator->messages(),
                ], 422);
            }else{
                $employee = Employee::where('username', '=', $request->username)->first();
                if($employee){
                    if(Hash::check($request->password, $employee->password)){
                        // $request->session()->put('loginId', $employee->id);
                        return $this->apiResponse->responseWithStatusAndMessage(200 ,'You shall pass!');
                    }else{
                        return $this->apiResponse->responseWithStatusAndMessage(422, 'Invalid Password.');
                    }
                } else {
                    return $this->apiResponse->responseWithStatusAndMessage(404);
                }
            }
        } catch (\Exception $e) {
            return $this->apiResponse->responseWithStatusAndMessage(500, 'Something went wrong.');
        }
    }
}

