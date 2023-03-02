<?php

namespace App\Http\Controllers\Api;

use App\Models\Rooms;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\RoomsController;
use Illuminate\Support\Facades\Validator;
use Hash;
use Session;


class RoomsController extends Controller
{
    protected $apiResponse;
    public function __construct(ApiResponse $apiResponse) {
        $this->apiResponse = $apiResponse;
    }

    public function getAllRooms(){
        try {
            $rooms = Rooms::all();
            if($rooms->count() > 0){
                return $this->apiResponse->responseWithStatusAndMessage(200,$rooms);
            }
            else {
                return response()->json(['status' => 404, 'message' => 'No employees found'], 404);
            }
        } catch (\Exception $e) {
            return $this->apiResponse->responseWithStatusAndMessage(500, 'Something went wrong.');
        }
    }

    public function addNewRoom(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'roomName' => 'required|string|max:191',
                'roomDescription' => 'required|string|max:191',
                'roomCapacity' => 'required|string|max:191',
                'roomPrice' => 'required|string|max:191',
            ]);
    
            if ($validator->fails()) {
                return $this->apiResponse->responseWithStatusAndMessage(422, $validator->messages()->all());
            } else {
                $room = Rooms::create([
                    'roomName' => $request->roomName,
                    'roomDescription' => $request->roomDescription,
                    'roomCapacity' => $request->roomCapacity,
                    'roomPrice' => $request->roomPrice,
                    'createdOn' => now(),
                    'updatedOn' => now(),
                ]);
    
                if ($room) {
                    return $this->apiResponse->responseWithStatusAndMessage(200);
                } else {
                    return $this->apiResponse->responseWithStatusAndMessage(500);
                }
            }
        } catch (\Exception $e) {
            return $this->apiResponse->responseWithStatusAndMessage(500);
        }
    }

    public function updateRoom (Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'roomName' => 'required|string|max:191',
                'roomDescription' => 'required|string|max:191',
                'roomCapacity' => 'required|string|max:191',
                'roomPrice' => 'required|string|max:191',
            ]);

            if ($validator->fails()) {
                return $this->apiResponse->responseWithStatusAndMessage(422, $validator->message()->all());
            }else{
                $room = Rooms::find($request->id);

                if ($room) {
                    $room-> update([
                        'roomName' => $request->roomName,
                        'roomDescription' => $request->roomDescription,
                        'roomCapacity' => $request->roomCapacity,
                        'roomPrice' => $request->roomPrice,
                        'updatedOn' => now(),
                    ]);
                    return $this->apiResponse->responseWithStatusAndMessage(200);
                }else{
                    return $this->apiResponse->responseWithStatusAndMessage(404);
                }
            }
        } catch (\Exepction $e) {
            return $this->apiResponse->responseWithStatusAndMessage(500);
        }
    }

    public function deleteRoom (Request $request) {
        try {
            $room = Rooms::find($request->id);

            if ($room) {
                $room->delete();
                return $this->apiResponse->responseWithStatusAndMessage(200);
            }else{
                return $this->apiResponse->responseWithStatusAndMessage(404);
            }
        } catch (\Exception $e) {
            return $this->apiResponse->responseWithStatusAndMessage(500);
        }
    }
}
