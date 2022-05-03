<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Tests\Feature\Auth;

use Faker\Generator as Faker;
use Juzaweb\Backend\Models\EmailList;
use Juzaweb\CMS\Models\User;
use Juzaweb\Tests\TestCase;

class RegisterTest extends TestCase
{
    public function testIndex()
    {
        $this->get('admin-cp/register')->assertStatus(200);
    }

    public function testRegister()
    {
        set_config('user_verification', 0);

        $faker = app(Faker::class);

        $this->json(
            'POST',
            'admin-cp/register',
            [
                'name' => $faker->name,
                'email' => $faker->email,
                "password" => "123456@123",
                "password_confirmation" => "123456@123",
            ]
        )
            ->assertJson(['status' => true]);
    }

    public function testRegisterWithVerify()
    {
        set_config('user_verification', 1);

        $faker = app(Faker::class);

        $email = $faker->email;

        $this->json(
            'POST',
            'admin-cp/register',
            [
                'name' => $faker->name,
                'email' => $email,
                "password" => "123456@123",
                "password_confirmation" => "123456@123",
            ]
        )
            ->assertJson(['status' => true]);

        $this->assertDatabaseHas('users', ['email' => $email, 'status' => 'verification']);

        $this->assertDatabaseHas('email_lists', ['email' => $email]);

        $token = EmailList::whereEmail($email)->first();

        $this->get("admin-cp/verification/{$email}/{$token->data['token']}")
            ->assertStatus(302)
            ->assertRedirect('admin-cp/login');

        $token->delete();
    }
}