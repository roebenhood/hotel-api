<?php

namespace App\Http\Controllers\Api;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    public function getAllEmployees(){
        $employees = Employee::all();
        if($employees->count() > 0){
            $data = [
                'status' => 200,
                'employees' => $employees
            ];
            return response()->json($data, 200);
        }
        else {
            return response()->json(['status' => 404, 'message' => 'No employees found'], 404);
        }
    }

    public function addNewEmployee(Request $request){
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
                return response()->json([
                    'status' => 200,
                    'message' => 'Employee created successfully',
                ], 200);
            } else {
                return response()->json([
                    'status' => 500,
                    'message' => 'Something went wrong.',
                ], 500);
            }
        }
        
    }

    public function getEmployee($id){
        $employee = Employee::find($id);
        if($employee){
            return response()->json([
                'status'=>200,
                'employee'=>$employee
            ],200);
        } else {
            return response()->json([
                'status'=>404,
                'message'=>"No such record found!"
            ],404);
        }
    }

    public function editEmployee($id){
        $employee = Employee::find($id);
        if($employee){
            return response()->json([
                'status'=>200,
                'employee'=>$employee
            ],200);
        } else {
            return response()->json([
                'status'=>404,
                'message'=>"No such record found!"
            ],404);
        }
    }

    public function updateEmployee(Request $request, int $id){
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
                return response()->json([
                    'status' => 200,
                    'message' => 'Employee record updated successfully',
                ], 200);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'No such record found.',
                ], 404);
            }
        }
    }

    public function deleteEmployee($id){
        $employee = Employee::find($id);
        if($employee){
            $employee->delete();
            return response()->json([
                'status'=> 200,
                'message'=> "Deleted successfully"
            ],404);
        } else {
            return response()->json([
                'status'=> 404,
                'message'=> "No such record found"
            ],404);
        }
    }
}

