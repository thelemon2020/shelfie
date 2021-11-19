<?php

namespace App\Http\Livewire;

use App\Models\LightSegment;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class ManageLightSegments extends Component
{

    public $segments;

    protected $listeners = [
        'segmentUpdated' => 'segmentUpdated',
        'segmentDeleted' => 'segmentDeleted',
        'refreshPage' => '$refresh',
        'refreshSegments' => 'reloadSegments'
    ];

    public function mount()
    {
        $this->segments = LightSegment::all()->sortBy('shelf_order');
    }

    public function render()
    {
        return view('livewire.manage-light-segments', ['segments' => $this->segments]);
    }

    public function segmentUpdated($segment)
    {
        $segmentToUpdate = $this->segments->where('id', $segment['id'])->first();
        $segmentToUpdate->name = $segment['name'];
        $segmentToUpdate->colour = $segment['colour'];
        $segmentToUpdate->shelf_order = $segment['shelf_order'];
    }

    public function submit()
    {
        foreach ($this->segments as $segment) {
            $segment->save();
        }
        Http::get(route('api.lights.segments.turn-on'));
        $this->dispatchBrowserEvent('reloadPage');
    }

    protected function rules()
    {
        return [
            'segments.*.name' => 'required|string',
            'segments.*.shelf_order' => ['required', 'integer', 'max:' . LightSegment::query()->count() + 1],
            'segments.*.colour' => ['required', 'string', 'regex:/#([a-f0-9]{3}){1,2}\b/i'],
            'segments.*.size' => ['required']
        ];
    }

    public function segmentDeleted($segmentToDelete)
    {
        $segmentToUpdate = $this->segments->where('id', $segmentToDelete)->first();
        $segmentToUpdate->delete();
        $this->emit('refreshPage');
    }

    public function createSegment()
    {
        $newSegment = LightSegment::query()->create([
            'name' => '',
            'shelf_order' => LightSegment::all()->count() - 1,
            'size' => 0,
        ]);
        $this->segments->push($newSegment);
    }

    public function reloadSegments()
    {
        $this->segments = LightSegment::all();
        $this->render();
    }
}
