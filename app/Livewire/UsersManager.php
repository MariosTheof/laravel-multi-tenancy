<?php
namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Throwable;

class UsersManager extends Component
{
    // Properties
    public $users, $user_id, $name, $email, $password;
    public $isModalOpen = false;

    private function validateUserData() {
        return $this->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($this->user_id)],
        ]);
    }

    public function mount()
    {
        $this->loadUsers();
    }

    public function loadUsers()
    {
        $this->users = Auth::user()->hasRole('admin') ? User::all() : [];
    }

    private function resetInputFields(){
        $this->name = $this->email = $this->password = $this->user_id = null;
    }

    public function store()
    {
        $validatedData = $this->validateUserData();

        try {
            $validatedData['password'] = bcrypt($validatedData['password']);
            User::create($validatedData);
            session()->flash('message', 'User Created Successfully.');
        } catch (Throwable $e) {
            session()->flash('error', "Error creating user: {$e->getMessage()}");
        }

        $this->resetInputFields();
    }

    public function update()
    {
        $validatedData = $this->validateUserData();

        try {
            if ($this->user_id && $user = User::find($this->user_id)) {
                $user->update($validatedData);
                session()->flash('message', 'User Updated Successfully.');
            } else {
                throw new \Exception('User not found.');
            }
        } catch (Throwable $e) {
            session()->flash('error', "Error updating user: {$e->getMessage()}");
        }

        $this->resetInputFields();
    }

    public function delete($id)
    {
        try {
            User::findOrFail($id)->delete();
            session()->flash('message', 'User Deleted Successfully.');
        } catch (Throwable $e) {
            session()->flash('error', "Error deleting user: {$e->getMessage()}");
        }

        $this->loadUsers();
    }

    public function render()
    {
        return view('livewire.users.index');
    }
}
