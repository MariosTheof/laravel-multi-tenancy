<?php
namespace App\Livewire;

use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Throwable;

class ProjectsManager extends Component
{
    public $projects, $project_id, $name, $description, $company_id, $creator_id;
    public $isModalOpen = false;

    private function validateProjectData() {
        return $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:2048',
            'company_id' => ['required', Rule::exists('companies', 'id')],
            'creator_id' => ['required', Rule::exists('users', 'id')]
        ]);
    }

    public function mount()
    {
        $this->loadProjects();
    }

    public function loadProjects()
    {
        if(Auth::user()->hasPermissionTo('view projects')) {
            $this->projects = Project::with('creator', 'company')->get();
        } else {
            $this->projects = Project::with('creator', 'company')->where('creator_id', Auth::id())->get();
        }
    }

    private function resetInputFields(){
        $this->name = $this->description = $this->company_id = $this->creator_id = null;
        $this->isModalOpen = false;
    }

    public function store()
    {
        if (!Auth::user()->hasPermissionTo('create projects')) {
            session()->flash('error', "You do not have permission to create projects.");
            return;
        }

        $validatedData = $this->validateProjectData();
        $validatedData['creator_id'] = Auth::id();  // Set the creator ID to the current user

        try {
            Project::create($validatedData);
            session()->flash('message', 'Project Created Successfully.');
        } catch (Throwable $e) {
            session()->flash('error', "Error creating project: {$e->getMessage()}");
        }

        $this->resetInputFields();
    }

    public function edit($id)
    {
        $project = Project::findOrFail($id);
        if (!Auth::user()->hasPermissionTo('edit projects') || $project->creator_id != Auth::id()) {
            session()->flash('error', "You do not have permission to edit this project.");
            return;
        }

        $this->project_id = $id;
        $this->name = $project->name;
        $this->description = $project->description;
        $this->company_id = $project->company_id;
        $this->creator_id = $project->creator_id;
        $this->isModalOpen = true;
    }

    public function update()
    {
        if (!Auth::user()->hasPermissionTo('edit projects')) {
            session()->flash('error', "You do not have permission to update projects.");
            return;
        }

        $validatedData = $this->validateProjectData();

        try {
            if ($this->project_id && $project = Project::find($this->project_id)) {
                if ($project->creator_id != Auth::id()) {
                    throw new \Exception('You are not authorized to update this project.');
                }
                $project->update($validatedData);
                session()->flash('message', 'Project Updated Successfully.');
            } else {
                throw new \Exception('Project not found.');
            }
        } catch (Throwable $e) {
            session()->flash('error', "Error updating project: {$e->getMessage()}");
        }

        $this->resetInputFields();
    }

    public function delete($id)
    {
        $project = Project::findOrFail($id);
        if (!Auth::user()->hasPermissionTo('delete projects') || $project->creator_id != Auth::id()) {
            session()->flash('error', "You do not have permission to delete this project.");
            return;
        }

        try {
            $project->delete();
            session()->flash('message', 'Project Deleted Successfully.');
        } catch (Throwable $e) {
            session()->flash('error', "Error deleting project: {$e->getMessage()}");
        }

        $this->loadProjects();
    }

    public function render()
    {
        return view('livewire.projects.index');
    }
}
