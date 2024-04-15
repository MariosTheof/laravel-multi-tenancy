<?php
namespace App\Http\Livewire;
use App\Models\Company;
use Livewire\Component;

new class extends Component
{
    public Company $company;

    public function updateCompany()
    {
        $this->validate([
            'company.name' => 'required',
            'company.email' => 'required|email',
            'company.address' => 'required',
        ]);

        $this->company->save();

        return redirect()->to('/companies');
    }
}
?>

<div>
    <form wire:submit.prevent="updateCompany">
        <input type="text" wire:model="company.name" required>
        <input type="email" wire:model="company.email" required>
        <textarea wire:model="company.address" required></textarea>
        <button type="submit">Update</button>
    </form>
</div>

