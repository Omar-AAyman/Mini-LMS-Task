<?php

namespace App\Livewire\Forms;

use Illuminate\Validation\Rule;
use Livewire\Form;

class ProfileForm extends Form
{
    public $name;

    public $email;

    public $password;

    public $password_confirmation;

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required', 
                'string', 
                'email:rfc,dns', 
                'max:255', 
                Rule::unique('users')->ignore(auth()->id())
            ],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ];
    }

    public function setUser($user)
    {
        $this->name = $user->name;
        $this->email = $user->email;
    }

    public function update()
    {
        $this->validate([
            'name' => $this->rules()['name'],
            'email' => $this->rules()['email'],
        ]);

        auth()->user()->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);
    }

    public function updatePassword()
    {
        $this->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = auth()->user();

        if (\Illuminate\Support\Facades\Hash::check($this->password, $user->password)) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'password' => 'The new password cannot be the same as your current password.',
            ]);
        }

        $user->update([
            'password' => \Illuminate\Support\Facades\Hash::make($this->password),
        ]);

        $this->reset(['password', 'password_confirmation']);
    }
}
