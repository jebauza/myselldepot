<?php

namespace Tests\Feature\CmsApi;

use App\User;
use Tests\TestCase;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function get_user_index_paginate_and_filters_ok()
    {
        Artisan::call('launch:deploy');
        $users = factory(User::class, 10)->create();
        $auth_user = $users->first();
        $search_user = $users->last();
        $auth_user->syncPermissions(['users.index']);

        $response = $this->withHeaders(['X-Requested-With' => 'XMLHttpRequest',])->actingAs($auth_user)
                    ->json('GET', route('cmsapi.user.index'), [
                        'page' => 1,
                        'email' => $search_user->email
                    ]);

        $response->assertStatus(200)
                    ->assertJson([
                        'current_page' => 1,
                        'data' => [$search_user->toArray()],
                        'total' => 1
                    ]);

        $this->assertAuthenticatedAs($auth_user);
    }

    /** @test */
    public function get_user_index_paginate_permission_error()
    {
        $users = factory(User::class, 2)->create();
        $auth_user = $users->first();

        $response = $this->withHeaders(['X-Requested-With' => 'XMLHttpRequest',])->actingAs($auth_user)
                    ->json('GET', route('cmsapi.user.index'), [
                        'page' => 1,
                        'email' => $users->last()->email
                    ]);

        $response->assertStatus(403);

        $this->assertAuthenticatedAs($auth_user);
    }

    /** @test */
    public function post_user_store_ok()
    {
        Artisan::call('launch:deploy');
        $auth_user = factory(User::class)->create();
        $auth_user->syncPermissions(['users.store']);

        $new_user = [
            'firstname' => 'Name_Test',
            'secondname' => 'Secondname_Test',
            'lastname' => 'Lastname_Test',
            'username' => 'username_Test',
            'email' => 'email_test@test.com',
            'password' => Hash::make('password'),
            'image' => '',
            'roles' => [],
            'permissions' => [],
        ];
        $response = $this->withHeaders(['X-Requested-With' => 'XMLHttpRequest',])->actingAs($auth_user)
                    ->postJson(route('cmsapi.user.store'), $new_user);

        $response->assertStatus(201)
                ->assertJson([
                    'msg' => __('Save successfully'),
                    'user' => [
                        'firstname' => $new_user['firstname'],
                        'secondname' => 'Secondname_Test',
                        'lastname' => 'Lastname_Test',
                        'username' => 'username_Test',
                        'email' => $new_user['email']
                    ]
                ]);

        $this->assertDatabaseHas('users', [
            'firstname' => $new_user['firstname'],
            'email' => $new_user['email']
        ]);

        $this->assertAuthenticatedAs($auth_user);
    }

    /** @test */
    public function post_user_store_permission_error()
    {
        $auth_user = factory(User::class)->create();

        $new_user = [
            'firstname' => 'Name_Test',
            'secondname' => 'Secondname_Test',
            'lastname' => 'Lastname_Test',
            'username' => 'username_Test',
            'email' => 'email_test@test.com',
            'password' => Hash::make('password'),
            'image' => '',
            'roles' => [],
            'permissions' => [],
        ];
        $response = $this->withHeaders(['X-Requested-With' => 'XMLHttpRequest',])->actingAs($auth_user)
                    ->postJson(route('cmsapi.user.store'), $new_user);

        $response->assertStatus(403);

        $this->assertDatabaseMissing('users', [
            'firstname' => $new_user['firstname'],
            'email' => $new_user['email']
        ]);

        $this->assertAuthenticatedAs($auth_user);
    }

    /** @test */
    public function post_user_store_validate_error()
    {
        Artisan::call('launch:deploy');
        $auth_user = factory(User::class)->create();
        $auth_user->syncPermissions(['users.store']);

        $new_user = [
            'firstname' => Str::random(256),
            'secondname' => Str::random(256),
            'username' => 'username_Test',
            'email' => 'email_testtest.com',
            'password' => Hash::make('password'),
            'image' => '',
            'roles' => [],
            'permissions' => [],
        ];
        $response = $this->withHeaders(['X-Requested-With' => 'XMLHttpRequest',])->actingAs($auth_user)
                    ->postJson(route('cmsapi.user.store'), $new_user);

        $response->assertStatus(422)
                ->assertJson(['message' => 'The given data was invalid.'])
                ->assertJsonStructure([
                    'message',
                    'errors' => [
                        'firstname',
                        'secondname',
                        'lastname',
                        'email'
                    ]
                ]);

        $this->assertDatabaseMissing('users', [
            'firstname' => $new_user['firstname'],
            'email' => $new_user['email']
        ]);

        $this->assertAuthenticatedAs($auth_user);
    }

    /** @test */
    public function post_user_update_ok()
    {
        Artisan::call('launch:deploy');
        $auth_user = factory(User::class)->create();
        $auth_user->syncPermissions(['users.update']);

        $update_user = factory(User::class)->create();
        $response = $this->withHeaders(['X-Requested-With' => 'XMLHttpRequest',])->actingAs($auth_user)
                    ->postJson(route('cmsapi.user.update', ['user_id' => $update_user->id]), [
                        'firstname' => $update_user->firstname,
                        'secondname' => $update_user->secondname,
                        'lastname' => $update_user->lastname,
                        'username' => 'username_new',
                        'email' => 'email_new@test.com'
                    ]);

        //dd($response->getData());

        $response->assertStatus(200)
                ->assertJson(['msg' => __('Save successfully')])
                ->assertJsonStructure(['msg', 'user']);

        $this->assertDatabaseHas('users', [
            'username' => 'username_new',
            'email' => 'email_new@test.com'
        ]);

        $this->assertAuthenticatedAs($auth_user);
    }

    /** @test */
    public function post_user_update_permission_error()
    {
        $auth_user = factory(User::class)->create();

        $update_user = factory(User::class)->create();
        $response = $this->withHeaders(['X-Requested-With' => 'XMLHttpRequest',])->actingAs($auth_user)
                    ->postJson(route('cmsapi.user.update', ['user_id' => $update_user->id]), [
                        'firstname' => $update_user->firstname,
                        'secondname' => $update_user->secondname,
                        'lastname' => $update_user->lastname,
                        'username' => 'username_new',
                        'email' => 'email_new@test.com'
                    ]);

        $response->assertStatus(403);

        $this->assertDatabaseMissing('users', [
            'username' => 'username_new',
            'email' => 'email_new@test.com'
        ]);

        $this->assertAuthenticatedAs($auth_user);
    }

    /** @test */
    public function post_user_update_validate_error()
    {
        Artisan::call('launch:deploy');
        $auth_user = factory(User::class)->create();
        $auth_user->syncPermissions(['users.store']);

        $update_user = factory(User::class)->create();
        $response = $this->withHeaders(['X-Requested-With' => 'XMLHttpRequest',])->actingAs($auth_user)
                    ->postJson(route('cmsapi.user.store', ['user_id' => $update_user->id]), [
                        'firstname' => Str::random(256),
                        'secondname' => Str::random(256),
                        'username' => 'username_Test',
                        'email' => 'email_testtest.com',
                        'image' => '',
                        'roles' => [],
                        'permissions' => [],
                    ]);

        $response->assertStatus(422)
                ->assertJson(['message' => 'The given data was invalid.'])
                ->assertJsonStructure([
                    'message',
                    'errors' => [
                        'firstname',
                        'secondname',
                        'lastname',
                        'email'
                    ]
                ]);

        $this->assertDatabaseMissing('users', [
            'username' => 'username_Test',
            'email' => 'email_testtest.com'
        ]);

        $this->assertAuthenticatedAs($auth_user);
    }

    /** @test */
    public function post_user_set_state_ok()
    {
        Artisan::call('launch:deploy');
        $auth_user = factory(User::class)->create();
        $auth_user->syncPermissions(['users.activate', '']);

        $update_user = factory(User::class)->create();
        $response = $this->withHeaders(['X-Requested-With' => 'XMLHttpRequest',])->actingAs($auth_user)
                    ->postJson(route('cmsapi.user.update', ['user_id' => $update_user->id]), [
                        'firstname' => $update_user->firstname,
                        'secondname' => $update_user->secondname,
                        'lastname' => $update_user->lastname,
                        'username' => 'username_new',
                        'email' => 'email_new@test.com'
                    ]);

        //dd($response->getData());

        $response->assertStatus(200)
                ->assertJson(['msg' => __('Save successfully')])
                ->assertJsonStructure(['msg', 'user']);

        $this->assertDatabaseHas('users', [
            'username' => 'username_new',
            'email' => 'email_new@test.com'
        ]);

        $this->assertAuthenticatedAs($auth_user);
    }
}
