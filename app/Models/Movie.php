<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class Movie extends Model
{
    use HasFactory;
    protected $fillable=['title','status','poster'];
    public function genres()
    {
        return $this->belongsToMany(Genre::class);
    }

    static function upStatus($movie)
    {
        if($movie->status==0)
            return 1;
        return 0;
    }


    static function getData(Request $request,$poster=null)
    {
        $data=[];
        if($request->hasFile('poster')){
            if($poster && $poster!='default.png'){
                Storage::delete($poster);
            }
            $data['poster']=$request->file('poster')->store("images/");
        }
        $data['title']=$request->title;
        return $data;
    }
}
