<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;

class UserSettings extends Component
{
    public \App\Models\UserSettings $userSettings;

    protected $rules = [
        'userSettings.wled_ip' => 'sometimes|ip',

    ];

    public function mount()
    {
        $this->userSettings = User::all()->first()->userSettings;
    }

    public function render()
    {
        return view('livewire.user-settings', ['userSettings' => $this->userSettings]);
    }

    public function submit()
    {
        $this->validate();
        $this->userSettings->save();
    }
}
