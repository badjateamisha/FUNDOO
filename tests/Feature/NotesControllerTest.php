<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NotesControllerTest extends TestCase
{
    //Testcase case for creatingNotes
    public function test_NewNotes()
    {
        $response = $this->withHeaders([
            'Content-Type' => 'Application/json',
        ])
        ->json('post', '/api/CreateNotes', [
            'Title' => 'abc',
            'Description' => 'abc',
        ]);
        $response->assertStatus(200)->assertJson(['message' => 'Notes created successfully']);
    }
    

    //Testcase case for Update createNotes
    public function test_UpdatingNotes()
    {
        $response = $this->withHeaders([
            'Content-Type' => 'Application/json',
        ])
            ->json('POST', '/api/updateNotes/27', [
                'Title' => 'abc',
                'Description' => 'BridgeLabz is a recruiting agency that focuses on technical employability at zero cost.',
            ]);
        $response->assertStatus(200)->assertJson(['message' => 'Notes Updated Successfully']);
    }

    //Testcase case for Update invalid createNotes
    public function test_UpdatesNotes_invalid()
    {
        $response = $this->withHeaders([
            'Content-Type' => 'Application/json',
        ])
            ->json('post', '/api/updateNotes/26', [
                'Title' => 'Company',
                'Description' => 'BridgeLabz is a recruiting agency that focuses on technical employability at zero cost.',
                    
            ]);
        $response->assertStatus(404)->assertJson(['message' => 'No Notes Found with that ID']);
    }
    

    //Testcase case for delete createNotes
    public function test_DeleteNotes()
    {
        $response = $this->withHeaders([
            'Content-Type' => 'Application/json',
        ])
            ->json('DELETE', '/api/deleteNotes/27', [
                'Title' => 'abc',
                'Description' => 'BridgeLabz is a recruiting agency that focuses on technical employability at zero cost.',
                
            ]);
        $response->assertStatus(200)->assertJson(['message' => 'Data Deleted Successfully']);
    }
}