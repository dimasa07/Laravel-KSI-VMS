<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testLogin()
    {
        $this->post('/user/login', [
            'username' => 'admin',
            'password' => 'admin'
        ])->assertSessionHas('username', 'admin')
            ->assertSessionHas('role', 'ADMIN');
    }

    public function testLogout()
    {
        $this->post('/user/login', [
            'username' => 'admin',
            'password' => 'admin'
        ])->assertSessionHas('username', 'admin')
            ->assertSessionHas('role', 'ADMIN');

        $this->get("/user/logout")->assertSessionMissing('username')
            ->assertSessionMissing('role');
    }

    public function testDaftar()
    {
        $this->post('/user/daftar', [
            'nik' => '123',
            'role' => 'TAMU',
            'username' => 'user123',
            'password' => 'user123'
        ])->assertJson([
            'nik' => '123',
            'role' => 'TAMU',
            'username' => 'user123',
            'password' => 'user123'
        ]);
    }
}
