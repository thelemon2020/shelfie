<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Symfony\Component\Process\Exception\ProcessFailedException;
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
        $wifiScript = new Process(['/var/www/html/shelfie/resources/wifiScript.sh', $this->ssid, $this->password, config('auth.rp_password')]);
        $wifiScript->run();
        if ($wifiScript->getStatus() !== '255') {
            Log::error($wifiScript->getErrorOutput());
            $this->addError('connection', 'Internal Server Error');
            throw new ProcessFailedException($wifiScript);
        }

        $this->render();
    }

    public function render()
    {
        return view('livewire.wifi');
    }
}
