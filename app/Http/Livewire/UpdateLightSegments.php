<?php

namespace App\Http\Livewire;

use App\Models\LightSegment;
use Livewire\Component;

class UpdateLightSegments extends Component
{
    public $segment;

    protected function rules()
    {
        return [
            'segment.name' => 'required|string',
            'segment.shelf_order' => ['required', 'integer', 'max:' . LightSegment::query()->count() + 1],
            'segment.colour' => ['required', 'string', 'regex:/#([a-f0-9]{3}){1,2}\b/i']
        ];
    }

    public function mount($segment = null)
    {
        $this->segment = $segment;
    }

    public function updated()
    {
        $this->emitUp('segmentUpdated', $this->segment);
    }

    public function createNewSegment()
    {
        $this->emitUp('segmentCreated', $this->segment);
    }

    public function render()
    {
        return view('livewire.update-light-segments', ['segment' => $this->segment]);
    }

    public function deleteSegment()
    {
        $this->emitUp('segmentDeleted', $this->segment->id);
    }
}
