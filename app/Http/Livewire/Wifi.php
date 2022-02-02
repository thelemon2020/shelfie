<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

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
        $error = '';
        $runstatus = exec('/var/www/html/shelfie/resources/wifiScript.sh ' . $this->ssid . ' ' . $this->password . ' ' . config('auth.rp_password'), $error);
//        $wifiScript = new Process(['sudo', '/var/www/html/shelfie/resources/wifiScript.sh', $this->ssid, $this->password, config('auth.rp_password')]);
//        $wifiScript->run();
        if (!$runstatus) {
            Log::error($error);
            $this->addError('connection', 'Internal Server Error');
            //throw new ProcessFailedException($wifiScript);
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
