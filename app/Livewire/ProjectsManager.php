<?php
namespace App\Livewire;

use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Throwable;

class ProjectsManager extends Component
{
    public $projects, $project_id, $name, $description, $company_id, $creator_id;
    public $isModalOpen = false;

    private function validateProjectData() {
        return $this->validate([
            'name' => 'required',
            'description' => 'required',
            'company_id' => 'required',
            'creator_id' => 'required'
        ]);
    }

    public function mount()
    {
        $this->loadProjects();
    }

    public function loadProjects()
    {
        $this->projects = Auth::user()->hasRole('admin') ?
            Project::with('creator', 'company')->get() :
            Project::with('creator', 'company')->where('creator_id', Auth::id())->get();
    }

    private function resetInputFields(){
        $this->name = $this->description = $this->company_id = $this->creator_id = null;
    }

    public function store()
    {
        $validatedData = $this->validateProjectData();

        try {
            Project::create($validatedData);
            session()->flash('message', 'Project Created Successfully.');
        } catch (Throwable $e) {
            session()->flash('error', "Error creating project: {$e->getMessage()}");
        }

        $this->resetInputFields();
    }

    public function update()
    {
        $validatedData = $this->validateProjectData();

        try {
            if ($this->project_id && $project = Project::find($this->project_id)) {
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
        try {
            Project::findOrFail($id)->delete();
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
