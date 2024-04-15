<?php
namespace App\Livewire;

use App\Models\Company;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CompaniesManager extends Component
{
    public $companies, $company_id, $title, $info, $address;
    public $isModalOpen = false;

    private function validateCompanyData() {
        return $this->validate([
            'title' => 'required|string|max:100',
            'info' => 'required|string',
            'address' => 'required|string|max:100',
        ]);
    }

    public function mount()
    {
        $this->loadCompanies();
    }

    public function loadCompanies()
    {
        if (Auth::user()->hasRole('admin')) {
            $this->companies = Company::all();
        } else if (Auth::user()->hasRole('moderator')) {
            $this->companies = Auth::user()->companies;
        }
    }

    private function resetInputFields(){
        $this->name = '';
        $this->description = '';
        $this->company_id = null;
    }

    public function store()
    {
        $validatedData = $this->validateCompanyData();
        try {
            Company::create($validatedData);
            session()->flash('message', 'Company Created Successfully.');
        } catch (\Exception $e) {
            session()->flash('error', 'Error creating company: ' . $e->getMessage());
        }

        $this->resetInputFields();
    }

    public function edit($id)
    {
        $this->isModalOpen = true;

        $this->resetInput();
        $company = Company::findOrFail($id);
        $this->company_id = $id;
        $this->name = $company->name;
        $this->description = $company->description;
    }

    public function resetInput()
    {
        $this->name = '';
        $this->description = '';
    }

    public function cancel()
    {
        $this->updateMode = false;
        $this->resetInputFields();
    }

    public function update()
    {
        $validatedData = $this->validateCompanyData();

        if ($this->company_id) {
            $company = Company::find($this->company_id);
            $company->update([
                'title' => $this->title,
                'info' => $this->info,
                'address' => $this->address,
            ]);
            $company->save();
            $this->updateMode = false;
            session()->flash('message', 'Company Updated Successfully.');
            $this->resetInputFields();
        }
    }

    public function delete($id)
    {
        try {
            Company::findOrFail($id)->delete();
            $this->loadCompanies();
            session()->flash('message', 'Company Deleted Successfully.');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to delete company.');
        }
    }

    public function render()
    {
        return view('livewire.companies.index'); // Assume the view path is adjusted accordingly
    }
}
