<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\lable;
use App\Models\notes;
use Illuminate\support\Facades\Hash;
use Illuminate\support\Facades\DB;

class LableController extends Controller
{
    //API Function to Create Lable

    public function CreateLable(Request $request)
    {
        $request->validate( [
            'lable_id' => 'required | integer ',
            'lable' => 'required | string |max:100',
        ]);
        
        $lable = lable::create([
            'lable_id' => $request->lable_id,
            'lable' => $request->lable,
        ]);
        return response()->json([
            'message' => 'Lable Added successfully',
            'lable' => $lable
        ], 200);

    }

    // API Function to display Lable
    public function displayLable()
    {
        $lable = lable::all();
        return response()->json(['success' => $lable]);
    }

    // API Function to display Lable by ID
    public function displayLable_ID($id)
    {
        $lable = lable::find($id);
        if($lable)
        {
            return response()->json(['success' => $lable]);
        }
        else
        {
            Log::channel('custom')->info("No Lable Found with that ID");
            return response()->json(['Message' => "No Lable Found with that ID"]);
        }
    }

    // API Function to Update Lable by ID
    public function updateLable_ID(Request $request, $id)
    {
       
        //validating the data to make it not to be null
        $request->validate( [
            'lable_id' => 'required | integer ',
            'lable' => 'required | string |max:100',
        ]);
        
        $lable = lable::find($id);
        if($lable)
        {
            $lable->lable_id = $request->lable_id;
            $lable->lable = $request->lable;
            
            $lable ->update();
            return response()->json(['message'=>'Lable Updated Successfully'],200);
        }
        else
        {
            Log::channel('custom')->info("No Lable Found with that ID");
            return response()->json(['message'=>'No Lable Found with that ID'],404);
        }
      
    }

    //API function to delete lable by ID
    public function deleteLable_ID(Request $request, $id)
    {       
        $lable = lable::find($id);
        if($lable)
        {
            $lable ->delete();
            return response()->json(['message'=>'Lable Deleted Successfully'],200);
        }
        else
        {
            Log::channel('custom')->info("No Lable Found with that ID");
            return response()->json(['message'=>'No Lable Found with that ID'],404);
        }
    }


        // API Function to JoinTable  by ID
    public function JoinTables()
    {
        $join = DB::table('notes')->join('lables', 'notes.id','=','lables.lable_id')->select('notes.*','lables.lable')->get();
        return $join;
    }
}