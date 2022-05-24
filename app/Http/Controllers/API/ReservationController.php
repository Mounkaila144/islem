<?php

namespace App\Http\Controllers\API;

use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Reservation as ReservationResource;

class ReservationController extends BaseController
{

    public function index()
    {
        $blogs = Reservation::all();
        return $this->sendResponse(ReservationResource::collection($blogs), 'Posts fetched.');
    }


    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'dateDebut' => 'required',
            'dateFin' => 'required',
            'etat' => 'required'
        ]);
        if($validator->fails()){
            return $this->sendError($validator->errors());
        }
        $blog = Reservation::create($input);
        return $this->sendResponse(new ReservationResource($blog), 'Post created.');
    }


    public function show($id)
    {
        $blog = Reservation::find($id);
        if (is_null($blog)) {
            return $this->sendError('Post does not exist.');
        }
        return $this->sendResponse(new ReservationResource($blog), 'Post fetched.');
    }


    public function update(Request $request, Reservation $blog)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'dateDebut' => 'required',
            'dateFin' => 'required',
            'etat' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError($validator->errors());
        }

        $blog->dateDebut = $input['dateDebut'];
        $blog->dateFin = $input['dateFin'];
        $blog->etat = $input['etat'];
        $blog->save();

        return $this->sendResponse(new ReservationResource($blog), 'Post updated.');
    }

    public function destroy(Reservation $blog)
    {
        $blog->delete();
        return $this->sendResponse([], 'Post deleted.');
    }
}
