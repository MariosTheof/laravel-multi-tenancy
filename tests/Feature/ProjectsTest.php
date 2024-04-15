<?php

use Livewire\Livewire;
use Tests\TestCase;
use App\Models\User;
use App\Models\Company;
use App\Models\Project;
use function Pest\Laravel\actingAs;

test('test_admin_can_view_projects', function () {
    $admin = User::create([
        'name' => 'admin',
        'email' => 'admin@example.com',
        'password' => bcrypt('password'),
    ]);
    $admin->assignRole('admin');

    $this->actingAs($admin);

    $response = $this->get('/projects');

    $response->assertStatus(200);
    $response->assertViewIs('projects');
});

test('admins can delete projects', function () {
    $admin = User::create([
        'name' => 'admin',
        'email' => 'admin@example.com',
        'password' => bcrypt('password'),
    ]);
    $company = Company::create([
        'title' => 'Test Company',
        'address' => '123 Test St',
        'info' => 'Just a test company'
    ]);
    $project = Project::create([
        'name' => 'project',
        'description' => 'info',
        'creator_id' => $admin->id,
        'company_id' => $company->id
    ]);
    $admin->assignRole('admin');

    Livewire::actingAs($admin)
        ->test(\App\Livewire\ProjectsManager::class, ['projects' => [$project]])
        ->assertStatus(200)
        ->assertHasNoErrors()
        ->call('delete', $project->id);

    $this->assertModelMissing($project);
});

test('admins can create projects', function () {
    $admin = User::create([
        'name' => 'admin',
        'email' => 'admin@example.com',
        'password' => bcrypt('password'),
    ]);
    $admin->assignRole('admin');
    $company = Company::create(['title' => 'Another Test Company', 'info' => 'Test Company', 'address' => 'address 123']);

    $initialCount = Project::count();

    $formData = [
        'name' => 'New Project',
        'description' => 'A new project description',
        'creator_id' => $admin->id,
        'company_id' => $company->id,
    ];

    Livewire::actingAs($admin)
        ->test(\App\Livewire\ProjectsManager::class)
        ->set('name', $formData['name'])
        ->set('description', $formData['description'])
        ->set('creator_id', $formData['creator_id'])
        ->set('company_id', $formData['company_id'])
        ->call('store')
        ->assertHasNoErrors()
        ->assertStatus(200);

    $this->assertTrue(Project::where('name', 'New Project')->exists());

    $this->assertEquals($initialCount + 1, Project::count(), "The number of projects should increase by 1");
});

test('admins can update projects', function () {
    $admin = User::create([
        'name' => 'admin',
        'email' => 'admin@example.com',
        'password' => bcrypt('password'),
    ]);
    $admin->assignRole('admin');
    $company = Company::create(['id' => 10, 'title' => 'Another Test Company', 'info' => 'Test Company', 'address' => 'address 123']);
    $project = Project::create([
        'name' => 'Original Project',
        'description' => 'Original Description',
        'creator_id' => $admin->id,
        'company_id' => $company->id
    ]);

    $updatedData = [
        'name' => 'Updated Project',
        'description' => 'Updated Description',
    ];

    Livewire::actingAs($admin)
        ->test(\App\Livewire\ProjectsManager::class)
        ->set('company_id', $company->id)
        ->set('name', $updatedData['name'])
        ->set('description', $updatedData['description'])
        ->set('creator_id', $admin->id)
        ->call('update')
        ->assertHasNoErrors()
        ->assertStatus(200);
});
