<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Validator;
use App\Models\Profesional;
use App\Http\Resources\Profesional as ProfesionalResource;

class ProfesionalController extends BaseController
{

    public function index()
    {
        $blogs = Profesional::all();
        return $this->sendResponse(ProfesionalResource::collection($blogs), 'Posts fetched.');
    }


    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'nom' => 'required',

        ]);
        if($validator->fails()){
            return $this->sendError($validator->errors());
        }
        $blog = Profesional::create($input);
        return $this->sendResponse(new ProfesionalResource($blog), 'Post created.');
    }


    public function show($id)
    {
        $blog = Profesional::find($id);
        if (is_null($blog)) {
            return $this->sendError('Post does not exist.');
        }
        return $this->sendResponse(new ProfesionalResource($blog), 'Post fetched.');
    }


    public function update(Request $request, Profesional $blog)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'nom' => 'required',

        ]);

        if($validator->fails()){
            return $this->sendError($validator->errors());
        }

        $blog->nom = $input['nom'];

        $blog->save();

        return $this->sendResponse(new ProfesionalResource($blog), 'Post updated.');
    }

    public function destroy(Profesional $blog)
    {
        $blog->delete();
        return $this->sendResponse([], 'Post deleted.');
    }
}
