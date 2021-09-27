<?php

namespace App\Http\Controllers\Release\Update;

use App\Http\Controllers\Controller;
use App\Models\Release;
use Illuminate\Http\Request;

class Update extends Controller
{
    public function __invoke(Request $request, $id)
    {
        foreach ($request->all() as $key => $value) {
            if (!$value) {
                $request->request->remove($key);
            }
        }
        $release = Release::query()->where('id', $id)->first();
        $originalPosition = $release->shelf_order;
        if ($request->input('shelf_order') != $originalPosition) {
            $this->changeShelfOrder($originalPosition, $request->input('shelf_order'));
        }
        $release->update($request->all());
        return redirect(route('release.edit.show', $release->id));
    }

    private function changeShelfOrder($originalPosition, $newPosition)
    {
        $releasesToLowerInOrder = Release::query()->whereBetween('shelf_order', [$originalPosition + 1, $newPosition])->get();
        $releasesToLowerInOrder->each(fn($release) => $release->update(['shelf_order' => (int)$release->shelf_order - 1]));
    }
}
