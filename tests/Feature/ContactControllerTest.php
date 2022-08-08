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
            "UserName" => 'Komal',
            "Email" => 'komal@gmail.com',
            "Password" => 'komal123',
            "MobileNumber" => '9089785667',
            "Address" => 'Auranagbad',
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

    public function test_Retreivedata_ID()
    {
        $response = $this->withHeaders([
            'Content-Type' => 'Application/json',
        ])
        ->json('get', '/api/display/3', []
            
        );

        $response->assertStatus(200);
    }

    // Testcase for Updata Data
    public function test_Update()
    {
        $response = $this->withHeaders([
            'Content-Type' => 'Application/json',
        ])
        ->json('POST', '/api/updatebyID/6', 
        [
            "UserName" => 'Aarvik',
            "Email" => 'aarvik@gmail.com',
            "Password" => 'aarvik123',
            "MobileNumber" => '9010000109',
            "Address" => 'Chinchwad',
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
        $response->assertStatus(200)->assertJson(['message' => 'No Data Found with that ID']);
    }

    // Testcase for Delete Data
    public function test_Delete()
    {
        $response = $this->withHeaders([
            'Content-Type' => 'Application/json',
        ])
        ->json('Delete', '/api/deletebyID/9'
        );
        $response->assertStatus(200)->assertJson(['message' => 'Data Deleted Successfully']);
    }

}
