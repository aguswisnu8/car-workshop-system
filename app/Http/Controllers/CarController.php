<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarController extends Controller
{
    // Middleware to prevent unauthorized user
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => []]);
    }

    public function store(Request $request)
    {
        try {
            // Add new Car by their ownner
            $request->validate([
                'name' => ['required', 'string'],
                'license_plate' => ['required', 'string','unique:cars,license_plate'],
            ]);

            $car = Car::create([
                'name'=> $request->name,
                'license_plate'=> $request->license_plate,
                'user_id'=> Auth::user()->id,
            ]);

            return response()->json([
                'status' => 'success add new car',
                'car' => $car
            ]);
        } catch (Exception $error) {
            
            return response()->json([
                'status' => 'failed',
                'message' => $error
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            // update car data where the id come from url path
            $request->validate([
                'name' => ['nullable', 'string'],
                'license_plate' => ['nullable', 'string'],
                'user_id' => ['nullable','integer']
            ]);

            $data = $request->all();
            $car = Car::find($id);
            $car->update($data);

            return response()->json([
                'status' => 'success update car',
                'car' => $car
            ]);
        } catch (Exception $error) {
            return response()->json([
                'status' => 'failed',
                'message' => $error
            ]);
        }
    }

    public function all(Request $request)
    {
        try {
            // Get Car by Spesific ID
            $id = $request->input('id');
            if ($id) {
                $car = Car::with(['user'])->find($id);
                if ($car) {
                    return response()->json([
                        'status' => 'success get car',
                        'car' => $car
                    ]);
                }else{
                    return response()->json([
                        'status' => 'car not found',
                        'car' => []
                    ]);
                }
            }

            // Get all Cars
            $car = Car::with(['user']);
            return response()->json([
                'status' => 'success get current user',
                'car' => $car->paginate(10)
            ]);
        } catch (Exception $error) {
            
            return response()->json([
                'status' => 'failed',
                'message' => $error
            ]);
        }
    }
}
