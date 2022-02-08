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

    protected $listeners = [
        'getNetworks' => 'getNetworks',
        'refreshComponent' => '$refresh'
    ];

    public function getNetworks()
    {
        if ($this->networks === null) {
            $wifiScript = new Process(['/var/www/html/shelfie/resources/getNetworks.sh', config('auth.rp_password')]);
            $wifiScript->run();
            if (!$wifiScript->isSuccessful()) {
                Log::error($wifiScript->getErrorOutput());
                $this->addError('connection', 'Internal Server Error');
                throw new ProcessFailedException($wifiScript);
            }
            $listOfNetworks = $wifiScript->getOutput();
            $this->networks = explode("\n", Str::remove(['ESSID:', '"'], $listOfNetworks));

        }
        $this->emitSelf('refreshComponent');
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
