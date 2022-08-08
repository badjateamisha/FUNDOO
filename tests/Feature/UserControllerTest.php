<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
//use PHPUnit\Framework\TestCase;

class UserControllerTest extends TestCase
{
    /* Successfull Registration
     * This test is to check user Registered Successfully or not
     * by using name, email and password as credentials
     * 
     * @test
     */
    public function test_registration()
    {
        $response = $this->withHeaders([
            'Content-Type' => 'Application/json',
        ])
        ->json('POST', '/api/registration', [
            "name" => "sasha",            
            "email" => "sasha@gmail.com",
            "password" => "sasha123",          
        ]);
        $response->assertStatus(200)->assertJson(['Message' => 'User successfully registered']);
    }

    public function test_userAlreadyRegistered()
    {
        $response = $this->withHeaders([
            'Content-Type' => 'Application/json',
        ])
            ->json('post', '/api/registration', [
                "name" => "sasha",
                "email" => "sasha@gmail.com",
                "password" => "sasha123"
            ]);
            $response->assertStatus(422)->assertJson(['message' => 'The email has already been taken.']);
            }

    public function test_successfulLogin()
    {
        $response = $this->withHeaders([
            'Content-Type' => 'Application/json',
        ])
        ->json('POST', '/api/login',
            [
                "email" => "pooja@gmail.com",
                "password" => "pooja123"
            ]
        );
        $response->assertStatus(200);   
     }

     public function test_login_Failed()
     {
         $response = $this->withHeaders([
             'Content-Type' => 'Application/json',
         ])
         ->json('POST', '/api/login',
             [
                 "email" => "pooja@gmail.com",
                 "password" => "p123" //giving a wrong password fails to login
             ]
         );
         $response->assertStatus(401)->assertJson(['message' => 'Invalid Credentials']);
     }
    }



