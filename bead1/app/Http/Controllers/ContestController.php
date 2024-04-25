<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Place;
use App\Models\Character;
use App\Models\CharacterContest;




class ContestController extends Controller
{

    public function generate(Request $request)
    {
        
        $places=Place::all();
        $contest=Contest::factory()->create([
            'user_id' => Auth::user()->id,
            'place_id' => $places->random()->id,
            'history'=>'',
        ]);
        $hero_hp=20;
        $enemy_hp=20;
     

        $characterId = $request->input('character_id');

        $enemies = Character::whereHas('user', function ($query) {
            $query->where('admin', true);
        })
        ->where('enemy', true)
        ->get();

        if ($enemies->isEmpty()) {
            return redirect()->route('response')->with([
                'response' => 'no enemy to have contest with',
            ]);
        }

        $enemy = $enemies->random();
        
        $match0=CharacterContest::factory()->create([
            'hero_id' => $characterId,
            'enemy_id' => $enemy->id,
            'contest_id' => $contest->id,
            'hero_hp' => $hero_hp,
            'enemy_hp' => $enemy_hp,
        ]);

        return redirect()->route('contest')->with([
            'new'=>true,
            'match0'=>$match0,
        ]);
    }

 
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
     
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */

   
    public function update(Request $request, string $id)
    {
        
    }

    public function processAction(Request $request)
    {
        $matchId = $request->input('matchId');
        $attackType = $request->input('attackType');
        $clickCount = $request->input('clickCount');

        $isPlayer=$clickCount%2==0;

        $match0 = CharacterContest::find($matchId);
        $attacker = $isPlayer ? $match0->hero : $match0->enemy;
        $defender = $isPlayer ? $match0->enemy : $match0->hero;
        $att_hp = $isPlayer ? $match0->hero_hp : $match0->enemy_hp;
        $def_hp = $isPlayer ? $match0->enemy_hp : $match0->hero_hp;
        
        
        $damage0=$this->
            calculateDamage($attackType,$attacker,$defender,$att_hp,$def_hp);

        $hp0=max(0,$def_hp-$damage0);
        $history0=$attacker->name.': '.$attackType.' attack - '.$damage0.' damage|';
        $match0->contest->history.=$history0;
        
        if($isPlayer)
        {
            $match0->enemy_hp= $hp0;
        }
        else
        {
            $match0->hero_hp= $hp0;
        }

        if($match0->hero_hp==0)
        {
            $match0->contest->win=false;
        }
        if($match0->enemy_hp==0)
        {
            $match0->contest->win=true;
        }
        
        $match0->save();
        $match0->contest->save();


        
        return redirect()->route('contest')->with([
            'new'=>false,
            'match0'=>$match0,
        ]);

    }
    private function calculateDamage($attackType, $attacker, $defender, $att_hp, $def_hp)
    {
        $damage = 0;

        switch ($attackType) {
            case 'Melee':
                $damage =  (($attacker->strength * 0.7 + $attacker->accuracy * 0.1 + $attacker->magic * 0.1) - $defender->defence);
                break;
            
            case 'Ranged':
                $damage =  (($attacker->strength * 0.1 + $attacker->accuracy * 0.7 + $attacker->magic * 0.1) - $defender->defence);
                break;
            
            case 'Magic':
                $damage = (($attacker->strength * 0.1 + $attacker->accuracy * 0.1 + $attacker->magic * 0.7) - $defender->defence);
                break;
            
            default:
                break;
        }
        
        $damage = max(0, $damage);

        return $damage;
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

}
