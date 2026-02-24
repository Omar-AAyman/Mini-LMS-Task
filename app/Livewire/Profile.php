<?php

namespace App\Livewire;

use App\Livewire\Forms\ProfileForm;
use App\Traits\WithRateLimiting;
use Livewire\Component;

class Profile extends Component
{
    public ProfileForm $form;

    public function mount()
    {
        $this->form->setUser(auth()->user());
    }

    public function updateProfile()
    {
        $this->form->update();

        $this->dispatch('notify', message: 'Profile updated successfully!', type: 'success');
    }

    public function updatePassword()
    {
        try {
            $this->form->updatePassword();
            $this->dispatch('notify', message: 'Password changed successfully!', type: 'success');
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        }
    }

    public function render()
    {
        return view('livewire.profile')->layout('layouts.app');
    }
}
