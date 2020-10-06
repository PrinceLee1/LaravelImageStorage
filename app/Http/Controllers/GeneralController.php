<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;

class GeneralController extends Controller
{
    public function store (Request $request) {
  
        if ($request->hasFile('image')) {
            $validated = $request->validate([
                'name' => 'string|max:40',
                //The image is not a file but an array of files
                'image' => ['required','array'],
                'image.*' => ['mimes:jpeg,png', 'max:1014']
            ]);
            $selectImages = $request->file('image');
                foreach($selectImages as $files){
                        $extension = $files->extension();
                       $file_name = $files->storeAs('/public/files', $validated['name'].".".$extension);
                        $url = Storage::url($validated['name'].".".$extension);
                        $data[] = $file_name;
                       File::create([
                        'name' => $file_name,
                            'url' => $url,
                        ]);
                }
               
                Session::flash('success', "Success!");
                return \Redirect::back();
        
        abort(500, 'Could not upload image :(');
    }
    }
    public function viewUploads () {
        $images = File::all();
        return view('components.view_uploads')->with('images', $images);
    }
    public function deleteImage(){
        echo 'Ok';
    }
}