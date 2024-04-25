<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Place;
use App\Models\Character;
use App\Models\CharacterContest;
use Illuminate\Support\Facades\Storage;


class PlaceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    const IMAGE_PATH = 'public/images';
   
    public function index()
    {
        // Check if the user is authenticated and is an admin
        if (Auth::check() && Auth::user()->admin) {
            $places = Place::all();
            return view('webpages.place.placelist');

        } else {
            abort(403, 'Unauthorized action.');
        }
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::check() && Auth::user()->admin) {
            $places = Place::all();
            return view('webpages.place.create_place', ['place0' => null]);


        } else {
            abort(403, 'Unauthorized action.');
        }
    }   

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'required|image|max:2048', // Assuming you're uploading an image
        ]);

        $imagePath = $request->file('image')->store(self::IMAGE_PATH);

        $place=Place::create([
            'name' => $validatedData['name'],
            'kep' =>  $imagePath,
        ]);
        return redirect()->route('response')->with([
            'response' => 'place created successfully',
            'place'=>$place,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (Auth::check() && Auth::user()->admin) {
            $place = Place::find($id);
            return view('webpages.place.create_place', ['place0' => $place]);

        } else {
            abort(403, 'Unauthorized action.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255', // Example validation rule for the name field
            'image' => 'image|max:2048', // Validation rule for the image field
        ]);

        $place = Place::findOrFail($id);
        if ($request->has('name')) {
            $place->name = $request->input('name');
        }

        if ($request->has('image')) {
            $imagePath = $request->file('image')->store(self::IMAGE_PATH);
            Storage::delete($place->kep); 
            $place->kep = $imagePath;
        }
        $place->save();

        return redirect()->route('response')->with([
            'response' => 'place updated successfully',
            'place'=>$place,
        ]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $place = Place::findOrFail($id);
        $name=$place->name;
        Storage::delete($place->kep); 

        $place->delete();

        return redirect()->route('response')->with([
            'response' => 'place with (id:'.$id.', name:'.$name.') deleted successfully',
        ]);
    }
}
