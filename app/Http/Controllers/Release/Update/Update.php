<?php

namespace App\Http\Controllers\Release\Update;

use App\Http\Controllers\Controller;
use App\Models\Release;
use Illuminate\Http\Request;

class Update extends Controller
{
    public function __invoke(Request $request, $id)
    {
        foreach ($request->all() as $key => $value){
            if (!$value){
                $request->request->remove($key);
            }
        }
        $release = Release::query()->where('id', $id)->first();
        $release->update($request->all());
        return redirect(route('release.edit.show', $release->id));
    }
}
