<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Validator;
use App\Models\Service;
use App\Http\Resources\Service as ServiceResource;

class ServiceController extends BaseController
{

    public function index()
    {
        $blogs = Service::all();
        return $this->sendResponse(ServiceResource::collection($blogs), 'Posts fetched.');
    }


    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'nom' => 'required',
            'prix' => 'required',
            'description' => 'required'
        ]);
        if($validator->fails()){
            return $this->sendError($validator->errors());
        }
        $blog = Service::create($input);
        return $this->sendResponse(new ServiceResource($blog), 'Post created.');
    }


    public function show($id)
    {
        $blog = Service::find($id);
        if (is_null($blog)) {
            return $this->sendError('Post does not exist.');
        }
        return $this->sendResponse(new ServiceResource($blog), 'Post fetched.');
    }


    public function update(Request $request, Service $blog)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'nom' => 'required',
            'prix' => 'required',
            'description' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError($validator->errors());
        }

        $blog->nom = $input['nom'];
        $blog->prix = $input['prix'];
        $blog->description = $input['description'];
        $blog->save();

        return $this->sendResponse(new ServiceResource($blog), 'Post updated.');
    }

    public function destroy(Service $blog)
    {
        $blog->delete();
        return $this->sendResponse([], 'Post deleted.');
    }
}
