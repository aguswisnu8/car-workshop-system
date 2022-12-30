<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Mail\MechanicNotif;
use App\Mail\NotificationMail;
use App\Models\Proposal;
use App\Models\Service;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ServiceController extends Controller
{
    // Middleware to prevent unauthorized user
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => []]);
    }

    public function all(Request $request)
    {
        try {
            // get spesific service by parameter id
            $id = $request->input('id');
            if ($id) {
                $service = Service::with(['user'])->find($id);
                if ($service) {
                    return response()->json([
                        'status' => 'success get service',
                        'data' => $service
                    ]);
                }else{
                    return response()->json([
                        'status' => 'service not found',
                        'data' => []
                    ]);
                }
            }
            // get all service with mechanic (user)
            $service = Service::with(['user']);

            return response()->json([
                'status' => 'success get service',
                'data' => $service->paginate(10)
            ]);
        } catch (Exception $error) {
            
            return response()->json([
                'status' => 'failed',
                'message' => $error
            ]);
        }
    }

    public function store(Request $request)
    {
        try {
            // Add new Car by their ownner
            $request->validate([
                'name' => ['required', 'string'],
                'type' => ['required', 'string','in:normal,complaint'],
                'price' => ['required', 'integer'],
                'description' => ['nullable', 'string'],
                'proposal_id' =>['required','integer'],
                'mechanic_id' =>['nullable','integer']
            ]);

            $service = Service::create([
                'name'=> $request->name,
                'type'=> $request->type,
                'price'=> $request->price,
                'description'=> $request->description,
                'proposal_id'=> $request->proposal_id,
                'mechanic_id'=> $request->mechanic_id,
            ]);

            return response()->json([
                'status' => 'success get service',
                'data' => $service
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
            // Add new Car by their ownner
            $request->validate([
                'name' => ['nullable', 'string'],
                'type' => ['nullable', 'string','unique:normal,complaint'],
                'price' => ['nullable', 'integer'],
                'status' => ['nullable', 'in:pending,progress,done'],
                'description' => ['nullable', 'string'],
                'proposal_id' =>['nullable','integer'],
                'mechanic_id' =>['nullable','integer']
            ]);
            $user = User::find($request->mechanic_id);
            if (!$user) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Cant find mechanic'
                ]);
            }
            $data = $request->all();
            $service = Service::find($id);
            $service->update($data);

            // if admin update the mechanic, app will send email notif to mechanic email
            $mechanic_id = $request->mechanic_id;
            if ($mechanic_id) {
                $proposal = Proposal::with(['user','car'])->find($service->proposal_id);
                Mail::to($user->email)->send(new MechanicNotif(
                    'New Service Job',
                    $proposal->car->name,
                    $proposal->car->license_plate,
                    $service->name,
                    $service->description
                ));
            }

            return response()->json([
                'status' => 'success get service',
                'data' => $service
            ]);
        } catch (Exception $error) {
            
            return response()->json([
                'status' => 'failed',
                'message' => $error
            ]);
        }
    }

    public function tres()
    {
        # code...
        $proposal = Proposal::with(['user','car'])->find(1);
        return response()->json([
            'status' => 'success get service',
            'data' => $proposal->user->name
        ]);
    }
}
