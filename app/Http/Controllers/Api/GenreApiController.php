<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\Genre as GenreResources;
use App\Http\Resources\GenreCollection;
use App\Http\Resources\Movie;
use App\Http\Resources\MovieCollection;
use App\Models\Genre;

class GenreApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $genres=Genre::paginate(5);
        return new GenreCollection($genres);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $genre=Genre::find($id);
        $movies=$genre->movies()->paginate(5);
        return new MovieCollection($movies);
    }

}
