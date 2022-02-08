<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Livewire\Component;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class Wifi extends Component
{
    public $ssid;
    public $password;
    public $networks;

    public $rules = [
        'ssid' => 'required',
        'password' => 'required',
    ];

    public function mount()
    {
        $wifiScript = new Process(['/var/www/html/shelfie/resources/getNetworks.sh', config('auth.rp_password')]);
        $wifiScript->run();
        if (!$wifiScript->isSuccessful()) {
            Log::error($wifiScript->getErrorOutput());
            $this->addError('connection', 'Internal Server Error');
            throw new ProcessFailedException($wifiScript);
        }
        $listOfNetworks = $wifiScript->getOutput();
        dd($listOfNetworks);
        $this->networks = explode("\n", Str::remove('ESSID:', $listOfNetworks));
    }

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
        $rebootScript = new Process(['/var/www/html/shelfie/resources/reboot.sh', config('auth.rp_password')]);
        $rebootScript->run();
    }

    public function render()
    {
        return view('livewire.wifi');
    }
}
