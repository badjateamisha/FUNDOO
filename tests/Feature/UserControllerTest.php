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
     * by using first_name, last_name, email and password as credentials
     * 
     * @test
     */
    public function successfulRegistrationTest()
    {
        $response = $this->withHeaders([
            'Content-Type' => 'Application/json',
        ])
            ->json('POST', '/api/register', [
                "name" => "amisha",
                "email" => "amishabadjate175@gmail.com",
                "password" => "amisha123",
            ]);
        $response->assertStatus(200);
    }
}
