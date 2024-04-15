<?php
namespace App\Livewire;

use Livewire\Component;
use App\Livewire\Modal;

class ContactModal extends Modal
{
    protected $listeners = ['showModal' => 'openModal'];



    public function render()
    {
        return view('livewire.contact-modal');
    }
}
