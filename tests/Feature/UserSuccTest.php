<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserSuccTest extends TestCase
{
    /**
     *function to test get all users
     * @author samehelshal
     * @todo assert json response
     */
    public function testGetAllUserSuccessfully()
    {


        $data = [

        ];

        $this->json('GET', 'api/v1/users', $data, ['Accept' => 'application/json'])
            ->assertStatus(200);

    }

    /**
     *function to test get all users By Provider
     * @author samehelshal
     * @todo assert json response
     */
    public function testGetAllUserByProviderSuccessfully()
    {


        $data = [
            "providers" =>"DataProviderX"

        ];

        $this->json('POST', 'api/v1/users_provider', $data, ['Accept' => 'application/json'])
            ->assertStatus(200);

    }


    /**
     *function to test get all users By Status Code
     * @author samehelshal
     * @todo assert json response
     */
    public function testGetAllUserByStatusCodeSuccessfully()
    {


        $data = [
            "statusCode" =>"decline"

        ];

        $this->json('POST', 'api/v1/users_status', $data, ['Accept' => 'application/json'])
            ->assertStatus(200);

    }

    /**
     *function to test get all users By Currency
     * @author samehelshal
     * @todo assert json response
     */
    public function testGetAllUserByCurrencySuccessfully()
    {


        $data = [
            "currency" => "USD"

        ];

        $this->json('POST', 'api/v1/users_currency', $data, ['Accept' => 'application/json'])
            ->assertStatus(200);

    }
}
