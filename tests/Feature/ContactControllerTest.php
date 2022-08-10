<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ContactControllerTest extends TestCase
{
    // Testcase for Create
    public function test_Create()
    {
        $response = $this->withHeaders([
            'Content-Type' => 'Application/json',
        ])
        ->json('POST', '/api/create', [
            "UserName" => 'zxc',
            "Email" => 'zxc@gmail.com',
            "Password" => 'zxc123',
            "MobileNumber" => '1234512345',
            "Address" => 'asd',
        ]);

        $response->assertStatus(200)->assertJson(['message' => 'Data Added Successfully']);
    }

    // Testcase for Retreiving all data
    public function test_Retreive()
    {
        $response = $this->withHeaders([
            'Content-Type' => 'Application/json',
        ])
        ->json('get', '/api/display', []
            
        );
        $response->assertStatus(200);
    }

    public function test_Retrievedata_ID()
    {
        $response = $this->withHeaders([
            'Content-Type' => 'Application/json',
        ])
        ->json('get', '/api/display/3', []
            
        );

        $response->assertStatus(200);
    }

    // Testcase for Updata Data
    public function test_Updata()
    {
        $response = $this->withHeaders([
            'Content-Type' => 'Application/json',
        ])
        ->json('POST', '/api/updatebyID/3', 
        [
            "UserName" => 'zxc',
            "Email" => 'zxc@gmail.com',
            "Password" => 'zxc123',
            "MobileNumber" => '1212121212',
            "Address" => 'qwe',
        ]);
        $response->assertStatus(200)->assertJson(['message' => 'Data Updated Successfully']);
    }

    public function test_Update_invalid()
    {
        $response = $this->withHeaders([
            'Content-Type' => 'Application/json',
        ])
        ->json('POST', '/api/updatebyID/15', //ID15 is not created so data can't be updated with that id
        [
           
            "UserName" => 'abc',
            "Email" => 'abc@gmail.com',
            "Password" => 'abc',
            "MobileNumber" => '1234567890',
            "Address" => 'nagar',
        ]);
        $response->assertStatus(404)->assertJson(['message' => 'No Data Found with that ID']);
    }

    // Testcase for Delete Data
    public function test_Deletee()
    {
        $response = $this->withHeaders([
            'Content-Type' => 'Application/json',
        ])
        ->json('Delete', '/api/deletebyID/3'
        );
        $response->assertStatus(200)->assertJson(['message' => 'Data Deleted Successfully']);
    }

//Test case for changing password
    public function test_Change_Password()
    {
        $response = $this->withHeaders([
            'Content-Type' => 'Application/json',
        ])
        ->json('POST', '/api/changePassword', 
        [
            'email' => 'alia@gmail.com',
            'password' =>'alia123',
            'newPassword' => 'alia1234',
            
        ]);
        $response->assertStatus(200)->assertJson(['message' => 'password updated successfully']);
    }


    public function test_Forgot_Password()
    {
        $response = $this->withHeaders([
            'Content-Type' => 'Application/json',
        ])
        ->json('POST', '/api/forgotPassword', 
        [
            'email' => 'amishabadjate175@gmail.com',
            
            
        ]);
        $response->assertStatus(200);
    }


    public function test_Reset_Password()
    {
        $response = $this->withHeaders([
            'Content-Type' => 'Application/json',
        ])
        ->json('POST', '/api/resetPassword', 
        [
            'email' => 'amishabadjate175@gmail.com',
            'password' => 'amisha12345',
            'token' => 'tFDLVVmlB9'
                        
        ]);
        $response->assertStatus(200);
    }


}
