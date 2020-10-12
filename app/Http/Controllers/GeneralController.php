<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;

class GeneralController extends Controller
{
    public function store(Request $request)
    {
        
        if ($request->hasFile('image')) {
            $validated = $request->validate([
                'name' => 'string|max:40',
                //The image is not a file but an array of files
                'image' => ['required','array'],
                'image.*' => ['mimes:jpeg,png', 'max:1014']
            ]);
            $selectImages = $request->file('image');
            // dd($selectImages);
            foreach ($selectImages as $files) {
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
                return redirect('view-uploads');
        
            abort(500, 'Could not upload image :(');
        }
    }
    public function viewUploads()
    {
        $images = File::all();
        return view('components.view_uploads')->with('images', $images);
    }
    public function deleteImage($id)
    {
        $imageDelete = File::find($id);
        $imageDelete->delete();
        return redirect('/view-uploads')->with('imageDelete', $imageDelete);
    }
    public function pixabay(Request $imageUrl)
    {
    
        $selectImages = $imageUrl->input('img');
        // dd($selectImages);
        $data = Http::get("https://pixabay.com/api/?key=18581546-a8aa82035e877bc6424f56709&q=$selectImages+sea&image_type=photo")->json();
    
        foreach ($data['hits'] as $items) {
            $fetchedData[] = $items['previewURL'];
            $id[] = $items['id'];
        }
        return view('components.pixa_upload', ['fetchedData' => $fetchedData, 'id' => $id, 'selectImages' => $selectImages]);
    }
    public function addPixabay(Request $request)
    {
        $pixaName = $request->pixaName;
        $pixaURL = $request->pixaURL;

        foreach ($pixaURL as $url) {
            $save = File::create([
                        'name' => $pixaName,
                        'url' => $url
                    ]);
        }

        if (!$save) {
            return 'not saved';
        }

       return view('components.view-uploads');
    }
}
