<?php

namespace Modules\Auth\Tests\Feature\Http\Controller;

use Tests\TestCase;

class AuthControllerTest extends TestCase
{

    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get(route('auth.show-otp-form'));

        $response->assertStatus(200);
        $response->assertViewIs('auth_module::otp');
    }

    public function test_example_2(): void
    {
        $response = $this->post(route('auth.otp', []));

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['user_name']);
    }

    public function test_example_3(): void
    {
        $response = $this->post(route('auth.otp', ['user_name' => '091jh07507825']));

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['user_name']);
    }
    public function test_example4(): void
    {
        $response = $this->post(route('auth.otp', ['user_name' => '09033333333']));

        $response->assertStatus(302);
//        $response->assertRedirect(route('auth.show-confirm-form', ['token' => Str::random(60)]));
    }
}
