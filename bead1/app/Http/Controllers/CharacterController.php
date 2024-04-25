<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Character;
use Illuminate\Support\Facades\Auth;
use App\Rules\SumOfAttributes;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;





class CharacterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(string $id)
    {
        //
    }
    public function toCreateForm()
    {
        if (Auth::check()) {
            return view('webpages.character.create_character');

        } else {
            return redirect()->route('login')->with('error', 'You must be logged in to create a contest.');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'strength' => 'required|integer',
            'defence' => 'required|integer',
            'magic' => 'required|integer',
            'accuracy' => 'required|integer',
        ]);
        
        if ($validator->passes()) {
            $sum = $request->strength + $request->defence + $request->magic + $request->accuracy;
            if($sum>20)
            {
                return redirect()->back()->withInput()
                ->withErrors(['sum' => 'The total sum of strength, defence, magic, and accuracy must be at least 20.'])
                ->withInput();
            }
    
            $character = new Character([
                'name' => $request->name,
                'strength' => $request->strength,
                'defence' => $request->defence,
                'magic' => $request->magic,
                'accuracy' => $request->accuracy,
                'user_id'=>Auth::user()->id,
                'enemy' => $request->enemy ?? false,
            ]);
            $character->save();
            $foundCharacter = Character::find($character->id);

            if ($foundCharacter) {
                $response = 'Character with ID ' . $foundCharacter->id . ' created succesfully.';
            } else {
                return redirect()->back()->withInput()
                ->withErrors(['sum' => 'failed to add character to database.'])
                ->withInput();
            }

            return redirect()->route('response')->with([
                'response' => $response,
                'character' => $foundCharacter,
            ]);
        } else {
            return redirect()->back()->withErrors($validator)->withInput();
        }



    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if (Auth::check()) {
            $character = Auth::user()->characters()->find($id);

            if ($character) {
                return view('webpages.character.show_character', ['character' => $character]);

            } else {
                // If the character is not found, return a message indicating so
                return view('webpages.character.show_character')->withErrors(['error' => 'Character not found.']);
            }
        } else {
            return redirect()->route('login')->with('error', 'You must be logged in to view characters.');
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (Auth::check()) {
            $character = Auth::user()->characters()->find($id);

            if ($character) {
                return view('webpages.character.create_character', ['character' => $character]);

            } else {
                return view('webpages.character.create_character')->withErrors(['error' => 'Character not found.']);
            }
        } else {
            return redirect()->route('login')->with('error', 'You must be logged in to view characters.');
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255',
            'strength' => 'integer',
            'defence' => 'integer',
            'magic' => 'integer',
            'accuracy' =>'integer',
            'enemy' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
    
    
        $character = Character::findOrFail($id);
        $this->assignCharacterProperties($character, $request);
        
        $sum = $character->strength + $character->defence + $character->magic + $character->accuracy;
        if ($sum > 20) {
            return redirect()->back()
                ->withErrors(['sum' => 'The total sum of strength, defence, magic, and accuracy must not exceed 20.'])
                ->withInput();
        }


        $character->save();

   

        $response = 'Character with ID ' . $character->id . ' updated succesfully.';
        return redirect()->route('response')->with([
            'response' => $response,
            'character' => $character,
        ]);
   
    }

    private function assignCharacterProperties(Character $character, Request $request)
    {
        $character->name = $request->input('name', $character->name);
        $character->strength = $request->input('strength', $character->strength);
        $character->defence = $request->input('defence', $character->defence);
        $character->magic = $request->input('magic', $character->magic);
        $character->accuracy = $request->input('accuracy', $character->accuracy);
        $character->enemy = $request->input('enemy', $character->enemy);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $character = Character::findOrFail($id);
        $name=$character->name;
        if ($character->delete()) {
            $response = 'Character with (ID:' . $id .', name:'.$name. ') deleted succesfully.';
            return redirect()->route('response')->with([
                'response' => $response,
            ]);
        } else {
            return redirect()->back()->with('error', 'Failed to delete character.');
        }
      
    }


}
