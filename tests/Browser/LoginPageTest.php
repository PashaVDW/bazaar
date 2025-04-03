<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginPageTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function test_login_page_displays_correctly()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->waitForText('Welcome back', 5)
                ->assertSee('Welcome back')
                ->assertInputPresent('email')
                ->assertInputPresent('password')
                ->assertPresent('button[type="submit"]');
        });
    }

    public function test_user_can_login_with_valid_credentials()
    {
        $this->browse(function (Browser $browser) {
            $password = 'secret123';
            $email = 'test'.uniqid().'@example.com';

            $user = User::factory()->create([
                'email' => $email,
                'password' => bcrypt($password),
            ]);

            $browser->visit('/login')
                ->type('email', $email)
                ->type('password', $password)
                ->press('Login')
                ->pause(1000)
                ->assertPathIs('/')
                ->assertSee($user->name);
        });
    }

    public function test_error_shown_on_invalid_login()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->type('email', 'wrong@example.com')
                ->type('password', 'wrongpassword')
                ->press('Login')
                ->waitForText('Error', 5)
                ->assertSee('Error');
        });
    }

    public function test_login_page_inputs_exist()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->assertInputPresent('email')
                ->assertInputPresent('password')
                ->assertPresent('button[type="submit"]');
        });
    }
}
