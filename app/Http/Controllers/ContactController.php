<?php

namespace App\Http\Controllers;

use Illuminate\support\Facades\Hash;
use Illuminate\support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\contact;
use App\Models\User;
use App\Mail\sendmail;
use Illuminate\Support\Facades\Log;


class ContactController extends Controller
{
    public function store(Request $request)
    {
        //validating the data to make it not to be null
        $request->validate([
            'UserName'=>'required | max:200',
            'Email'=>'required | max:200',
            'Password'=>'required | max:200',
            'MobileNumber'=>'required | max:12',
            'Address'=>'required | max:200',
        ]);
        $contact = new Contact;
        $contact->UserName = $request->UserName;
        $contact->Email = $request->Email;
        //Password Encrytion using HASH methodd
        $contact->Password = $request->Password;
        $contact->Password = Hash::make($contact->Password);

        $contact->MobileNumber = $request->MobileNumber;
        $contact->Address = $request->Address;

        $contact ->save();
        Log::channel('custom')->info("Data Added Successfully");
        return response()->json(['message'=>'Data Added Successfully'],200);

    }

    //Function to Retreive Data 
    public function display()
    {
        $contact = contact::all();
        return response()->json(['success' => $contact]);
    }

    //Function to Retreive Data Based on ID 
    public function display_by_id($id)
    {
        $contact = contact::find($id);
        if($contact)
        {
            return response()->json(['success' => $contact]);
        }
        else{
            Log::channel('custom')->error(" No Data found with that ID");
            return response()->json(['Message' => "No data Found with That ID"]);
        }

    }


    public function update_by_id(Request $request, $id)
    {
        //validating the data to make it not to be null
        $request->validate([
            'UserName'=>'required | max:200',
            'Email'=>'required | max:200',
            'Password'=>'required | max:200',
            'MobileNumber'=>'required | max:12',
            'Address'=>'required | max:200',
        ]);
        $contact=contact::find($id);
        if($contact)
        {
            $contact->UserName = $request->UserName;
            $contact->Email = $request->Email;
            //Password Encrytion using HASH methodd
            $contact->Password = $request->Password;
            $contact->Password = Hash::make($contact->password);
            $contact->MobileNumber = $request->MobileNumber;
            $contact->Address = $request->Address;

            $contact ->update();
            return response()->json(['message'=>'Data Updated Successfully'],200);
        }
        else
        {
            Log::channel('custom')->error("No Data Found with that ID");
            return response()->json(['message'=>'No Data Found with that ID'],404);
        }
    }

    //Function to Delete Data based on ID
   public function delete_by_id(Request $request, $id)
   {
      
       $contact = contact::find($id);
       if($contact)
       {
           $contact ->delete();
           return response()->json(['message'=>'Data Deleted Successfully'],200);
       }
       else
       {
           Log::channel('custom')->error("No Data Found with that ID");
           return response()->json(['message'=>'No Data Found with that ID'],404);
       }
   }


   //API to change password in postman
   
   public function changePassword(Request $request){
    $request->validate([
        'email' => 'required',
        'password' =>'required',
        'newPassword' => 'required'
    ]);
    $result = Auth::attempt(['email' => $request->email, 'password' => $request->password]);
    if($result){
        User::where('id', $request->userId)->update(['password' => Hash::make($request->newPassword)]);
        return response()->json(['message'=>"password updated successfully", 'status'=>200]);
        
    }
    else{
        Log::channel('custom')->error("You have Entered the wrong password");
        return response()->json(['message'=>"Check your old password", 'status'=>400]);
    }
}

    }
