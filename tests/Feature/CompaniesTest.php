<?php

use Livewire\Livewire;
use Tests\TestCase;
use App\Models\User;
use App\Models\Company;
use function Pest\Laravel\actingAs;
use Livewire\Volt\Volt;

test('test_admin_can_view_companies', function () {
    $user = User::create([
        'name' => 'admin',
        'email' => 'JGZp5@example.com',
        'password' => bcrypt('password'),
    ]);
    $user->assignRole('admin');

    $this->actingAs($user);

    $response = $this->get('/companies');

    $response->assertStatus(200);
    $response->assertViewIs('companies');
});

test('admins can delete companies', function () {
    $admin = User::create([
        'name' => 'admin',
        'email' => 'admin@example.com',
        'password' => bcrypt('password'),
    ]);
    $company = Company::create([
        'title' => 'company',
        'info' => 'info',
        'address' => 'address 123'
    ]);
    $admin->assignRole('admin');

    Livewire::actingAs($admin)
        ->test(\App\Livewire\CompaniesManager::class, ['companies' => [$company]])
        ->assertStatus(200)
        ->assertHasNoErrors()
        ->call('delete', $company->id);

    $this->assertModelMissing($company);
});


/*
    Moderators can do everything that the admins can, but only for their own projects


*/
//test('moderators cannot delete companies', function () {
//    $moderator = User::create([
//        'name' => 'admin',
//        'email' => 'admin@example.com',
//        'password' => bcrypt('password'),
//    ]);
//    $moderator->assignRole('moderator');
//    $company = Company::create([
//        'title' => 'company',
//        'info' => 'info',
//        'address' => 'address 123'
//    ]);
//
//    Livewire::actingAs($moderator)
//        ->test(\App\Livewire\CompaniesManager::class, ['companies' => [$company]])
//        ->assertStatus(200)
//        ->assertHasNoErrors()
//        ->call('delete', $company->id);
//
//    $this->assertDatabaseHas('companies', [
//        'id' => $company->id
//    ]);
//});

test('admins can create companies', function () {
    $admin = User::create([
        'name' => 'admin',
        'email' => 'admin@example.com',
        'password' => bcrypt('password'),
    ]);
    $admin->assignRole('admin');

    $initialCount = Company::count();

    $formData = [
        'title' => 'New Company',
        'info' => 'A new company description',
        'address' => 'address 123',
    ];

    Livewire::actingAs($admin)
        ->test(\App\Livewire\CompaniesManager::class)
        ->set('title', $formData['title'])
        ->set('info', $formData['info'])
        ->set('address', $formData['address'])
        ->call('store')
        ->assertHasNoErrors()
        ->assertStatus(200);

    $this->assertTrue(Company::where('title', 'New Company')->exists());

    $this->assertEquals($initialCount + 1, Company::count(), "The number of companies should increase by 1");
});

test('admins can update companies', function () {
    // Setup: create an admin user and a company
    $admin = User::create([
        'name' => 'admin',
        'email' => 'admin@example.com',
        'password' => bcrypt('password'),
    ]);
    $admin->assignRole('admin');

    $company = Company::create([
        'title' => 'Original Title',
        'info' => 'Original Info',
        'address' => 'Original Address 123'
    ]);

    $updatedData = [
        'title' => 'Updated Company',
        'info' => 'Updated Description',
        'address' => 'Updated Address'
    ];

    Livewire::actingAs($admin)
        ->test(\App\Livewire\CompaniesManager::class)
        ->set('company_id', $company->id)
        ->set('title', $updatedData['title'])
        ->set('info', $updatedData['info'])
        ->set('address', $updatedData['address'])
        ->call('update')
        ->assertHasNoErrors()
        ->assertStatus(200);

    $company->refresh();
    expect($company->title)->toEqual($updatedData['title']);
    expect($company->info)->toEqual($updatedData['info']);
});

