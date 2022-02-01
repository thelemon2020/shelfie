<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Symfony\Component\Process\Process;

class Wifi extends Component
{
    public $ssid;
    public $password;

    public $rules = [
        'ssid' => 'required',
        'password' => 'required',
    ];

    public function submit()
    {
        $this->validate();
        $connectProcess = new Process(['wpa_passphrase', $this->ssid, $this->password]);
        $connectProcess->run();
        if (!$connectProcess->isSuccessful()) {
            $this->addError('connection', 'Internal Error');
        } else {
            $response = Http::timeout(10)->get('https://google.com');
            if ($response->status() !== 200) {
                $this->addError('connection', 'Could Not Connect To Internet');
            } else {
                session()->flash('message', 'Connection Successful');
            }
        }

        $this->render();
    }

    public function render()
    {
        return view('livewire.wifi');
    }
}
