<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class ProposalController extends Controller
{
    // Middleware to prevent unauthorized user
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => []]);
    }

    public function all(Request $request)
    {
        try {
            // get spesific proposal by parameter id
            $id = $request->input('id');
            if ($id) {
                $proposal = Proposal::with(['user'])->find($id);
                if ($proposal) {
                    return response()->json([
                        'status' => 'success get proposal',
                        'proposal' => $proposal
                    ]);
                }else{
                    return response()->json([
                        'status' => 'proposal not found',
                        'proposal' => []
                    ]);
                }
            }
            // get all proposal with car information, car owner, services, and mechanic
            $proposal = Proposal::with(['car.user','services']);

            return response()->json([
                'status' => 'success get proposal',
                'proposal' => $proposal->paginate(10)
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
            // add new proposal
            $request->validate([
                'total_price' => ['required', 'integer'],
                'status'=>['nullable','in:pending,progress,feedback,done'],
                'car_id' => ['required','integer'],
            ]);
            $proposal = Proposal::create([
                'total_price' => $request->total_price,
                'car_in' => Carbon::now(),
                'status' => $request->status,
                'car_id' => $request->car_id,
            ]);
            return response()->json([
                'status' => 'success add new proposal',
                'proposal' => $proposal
            ]);
        } catch (Exception $error) {
            
            return response()->json([
                'status' => 'failed',
                'message' => $error
            ]);
        }
    }
    public function update(Request $request,$id)
    {
        try {
            // update proposal status
            // pending (on suggested service)
            // progress (progressing the service by mechanic)
            // feedback (customer review)
            // done (repair done)
            $request->validate([
                'repair_status' => ['required','in:pending,progress,feedback,done'],
            ]);
            $data = $request->all();
            $proposal = Proposal::find($id);
            $proposal->update($data);

            return response()->json([
                'status' => 'success update proposal',
                'proposal' => $proposal
            ]);
        } catch (Exception $error) {
            
            return response()->json([
                'status' => 'failed',
                'message' => $error
            ]);
        }
    }
}
