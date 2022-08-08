<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;
use Illuminate\support\Facades\Hash;
use Illuminate\support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\User;
use App\Mail\sendmail;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\PasswordReset;
use App\Notifications\PasswordResetRequest;

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

//--- sending token to mail to change password ------- 
public function forgotPassword(Request $request)
{  
    
     $request->validate([
        'email'=>'required | max:200',         
    ]);

    $email = $request->email;
    $user = User::where('email', $email)->first();
    if (!$user) {
        Log::channel('custom')->error("Email does not exists");
        return response()->json(['Message' => "Email does not exists", 'status' => 404]);
        
    } 
    else {

        $token = Str::random(10);
        $reset = new PasswordReset();

        PasswordReset::create([
            'email' => $request->email,
            'token' => $token
        ]);

        Mail::to($email)->send(new SendMail($token, $email));
        
        return "Token Sent to Mail to Reset Password";
        
    }

}

    }
