<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;

class UserSettings extends Component
{
    public \App\Models\UserSettings $userSettings;
    public $originalSortMethod;
    public $originalSsid;
    public $password;

    protected $rules = [
        'userSettings.wled_ip' => 'sometimes|ip',

    ];

    public function mount()
    {
        $this->userSettings = User::all()->first()->userSettings;
        $this->originalSortMethod = $this->userSettings->sort_method;

    }

    public function render()
    {
        return view('livewire.user-settings', ['userSettings' => $this->userSettings]);
    }
}
