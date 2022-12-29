<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // Middleware to prevent unauthorized user
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => []]);
    }

    public function me(Request $request)
    {
        // GET CUREENT LOGGED ACCOUNT
        try {
            $user = Auth::user();
            return response()->json([
                'status' => 'success get current user',
                'user' => $user
            ]);
        } catch (Exception $error) {
            
            return response()->json([
                'status' => 'failed',
                'message' => $error
            ]);
        }
    }

    public function getAllUsers(Request $request)
    {   
        try {
            
            // GET USER FILLTERED BY ROLE (CUSTOMER/MECHANIC/ADMIN)
            $role = $request->input('role');
            if ($role) {
                $user = User::where('role',$role)->get();
                if ($user->first()) {
                    return response()->json([
                        'status' => "success get all $role",
                        'user' => $user
                    ]);
                }else{
                    return response()->json([
                        'status' => "$role didnt exist",
                        'user' => []
                    ]);
                }
            }

            $user = User::all();
            return response()->json([
                'status' => 'success get all user',
                'user' => $user
            ]);
        } catch (Exception $error) {
            
            return response()->json([
                'status' => 'get user failed',
                'message' => $error
            ]);
        }
    }

    public function changeRole(Request $request,$id)
    {
        try {
            # Change User Role

            $request->validate([
                'role'=>['string','in:customer,mechanic,admin','required']
            ]);
            
            $user = User::find($id);
            $user->role = $request->role;
            $user->update();
            return response()->json([
                'status' => 'success changing user role',
                'user' => $user
            ]);
        } catch (Exception $error) {
            return response()->json([
                'status' => 'failed',
                'message' => $error
            ]);
        }
        

    }
}
