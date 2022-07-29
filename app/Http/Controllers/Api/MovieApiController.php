<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Http\Resources\Movie as MovieResources;
use App\Http\Resources\MovieCollection;
use Illuminate\Http\Request;

class MovieApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $movies=Movie::paginate(10);
        return new MovieCollection($movies);
    }

    public function show($id)
    {
        $movie=Movie::find($id);
        return new MovieResources($movie);
    }

}
