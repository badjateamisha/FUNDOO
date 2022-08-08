<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LableControllerTest extends TestCase
{
    //Testcase case for creatingLable
    public function test_NewLable()
    {
        $response = $this->withHeaders([
            'Content-Type' => 'Application/json',
        ])
        ->json('post', '/api/CreateLable', [
            "notes_id" => "2",            
            "lable" => "school",
                     
        ]);
        $response->assertStatus(200)->assertJson(['message' => 'Lable Added successfully']);
    }
    

    //Testcase case for Update Lable
    public function test_UpdatingLable()
    {
        $response = $this->withHeaders([
            'Content-Type' => 'Application/json',
        ])
        ->json('post', '/api/updateLable/21', [
            "notes_id" => "6",
            "lable" => "acbsdfd",
                
            ]);
        $response->assertStatus(200)->assertJson(['message' => 'Lable Updated Successfully']);
    }


    //Testcase case for invalid Update Lable
    public function test_UpdateLable_invalid()
    {
        $response = $this->withHeaders([
            'Content-Type' => 'Application/json',
        ])
            ->json('post', '/api/updateLable/25', [
                "notes_id" => "6",
                "lable" => "abc",
                
            ]);
        $response->assertStatus(404)->assertJson(['message' => 'No Lable Found with that ID']);
    }
    

    //Testcase case for delete createLable
    public function test_DeleteLable()
    {
        $response = $this->withHeaders([
            'Content-Type' => 'Application/json',
        ])
            ->json('delete', '/api/deleteLable/21', [
                 
        ]);
        $response->assertStatus(200)->assertJson(['message' => 'Lable Deleted Successfully']);
    }
}