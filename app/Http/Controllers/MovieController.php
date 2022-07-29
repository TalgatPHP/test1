<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MovieController extends Controller
{
    public function index()
    {
        $movies=Movie::all();
        return view('index',compact('movies'));
    }

    public function create()
    {
        $genres=Genre::pluck('id','title')->all();
        return view('movies.create',compact('genres'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'=>'required|alpha_num',
            'poster'=>'nullable|image',
            'genres_id.*'=>'integer'
        ]);
        $data=Movie::getData($request);
        $movie=Movie::create($data);
        $movie->genres()->sync($request->genres_id);
        return redirect()->route('movies.index');
    }

    public function show($id)
    {
        $movie=Movie::find($id);
        $genres=$movie->genres;
        return view('movies.show',compact('movie','genres'));
    }

    public function edit($id)
    {
        $movie=Movie::find($id);
        $genres=Genre::pluck('id','title')->all();
        return view('movies.edit',compact('movie','genres'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title'=>'required|alpha_num',
            'poster'=>'nullable|image',
            'genres_id.*'=>'integer'
        ]);

        $movie = Movie::find($id);
        $data=Movie::getData($request,$movie->poster);
        $movie->update($data);
        $movie->genres()->sync($request->genres_id);
        return redirect()->route('movies.index');
    }

    public function destroy($id)
    {
        $movie=Movie::find($id);
        $movie->genres()->sync([]);
        if($movie->poster!='default.png'){
            Storage::delete($movie->poster);
        }
        $movie->delete();
        return redirect()->route('movies.index');
    }

    public function updateStatus($id)
    {
        $movie=Movie::find($id);
        $movie->status=Movie::upStatus($movie);
        $movie->save();
        return redirect()->route('movies.index');
    }
}
