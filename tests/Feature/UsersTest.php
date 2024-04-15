<?php

use Livewire\Livewire;
use App\Models\User;
use function Pest\Laravel\actingAs;

test('test_admin_can_view_users', function () {
    $admin = User::create([
        'name' => 'admin',
        'email' => 'admin@example.com',
        'password' => bcrypt('password'),
    ]);
    $admin->assignRole('admin');

    $this->actingAs($admin);

    $response = $this->get('/users');

    $response->assertStatus(200);
    $response->assertViewIs('users');
});

test('admins can delete users', function () {
    $admin = User::create([
        'name' => 'admin',
        'email' => 'admin@example.com',
        'password' => bcrypt('password'),
    ]);
    $user = User::create([
        'name' => 'Test User',
        'email' => 'testuser@example.com',
        'password' => bcrypt('password')
    ]);
    $admin->assignRole('admin');

    Livewire::actingAs($admin)
        ->test(\App\Livewire\UsersManager::class, ['users' => [$user]])
        ->assertStatus(200)
        ->assertHasNoErrors()
        ->call('delete', $user->id);

    $this->assertModelMissing($user);
});

test('admins can create users', function () {
    $admin = User::create([
        'name' => 'admin',
        'email' => 'admin@example.com',
        'password' => bcrypt('password'),
    ]);
    $admin->assignRole('admin');

    $initialCount = User::count();

    $formData = [
        'name' => 'New User',
        'email' => 'newuser@example.com',
        'password' => 'secret',
    ];

    Livewire::actingAs($admin)
        ->test(\App\Livewire\UsersManager::class)
        ->set('name', $formData['name'])
        ->set('email', $formData['email'])
        ->set('password', $formData['password'])
        ->call('store')
        ->assertHasNoErrors()
        ->assertStatus(200);
});

test('admins can update users', function () {
    $admin = User::create([
        'name' => 'admin',
        'email' => 'admin@example.com',
        'password' => bcrypt('password'),
    ]);
    $admin->assignRole('admin');

    $user = User::create([
        'name' => 'Original User',
        'email' => 'original@example.com',
        'password' => bcrypt('password')
    ]);

    $updatedData = [
        'name' => 'Updated User',
        'email' => 'updated@example.com',
        'password' => bcrypt('secret'),
    ];

    Livewire::actingAs($admin)
        ->test(\App\Livewire\UsersManager::class)
        ->set('user_id', $user->id)
        ->set('name', $updatedData['name'])
        ->set('email', $updatedData['email'])
        ->set('password', $updatedData['password'])
        ->call('update')
        ->assertHasNoErrors()
        ->assertStatus(200);

    $user->refresh();
    expect($user->name)->toEqual($updatedData['name']);
    expect($user->email)->toEqual($updatedData['email']);
});
