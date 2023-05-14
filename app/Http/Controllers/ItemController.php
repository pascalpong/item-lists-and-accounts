<?php

namespace App\Http\Controllers;

use App\Models\RandomList;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public $items ;
    public $store_selected_items ;

    public function __construct()
    {
        $this->store_selected_items = collect();
        $this->items = collect(json_decode('[
            {"name" : "Small Potion Heal" , "game_item_id": 1050 , "chance" : 0.12 , "stock" : 1000 },
            {"name" : "Medium Potion Heal" , "game_item_id": 3315 , "chance" : 0.08 , "stock" : 80 },
            {"name" : "Big Potion Heal" , "game_item_id": 5830 , "chance" : 0.06 , "stock" : 15 },
            {"name" : "Full Potion Heal" , "game_item_id": 1650 , "chance" : 0.04 , "stock" : 10 },
            {"name" : "Small MP Potion" , "game_item_id": 10235 , "chance" : 0.12 , "stock" : 1000 },
            {"name" : "Medium MP Potion" , "game_item_id": 892 , "chance" : 0.08 , "stock" : 80 },
            {"name" : "Big MP Potion" , "game_item_id": 14736 , "chance" : 0.06 , "stock" : 15 },
            {"name" : "Full MP Potion" , "game_item_id": 19001 , "chance" : 0.04 , "stock" : 8 },
            {"name" : "Attack Ring" , "game_item_id": 135007 , "chance" : 0.05 , "stock" : 10 },
            {"name" : "Defense Ring" , "game_item_id": 68411 , "chance" : 0.05 , "stock" : 10 },
            {"name" : "Lucky Key" , "game_item_id": 118930 , "chance" : 0.15 , "stock" : 1000 },
            {"name" : "Silver Key" , "game_item_id": 117462 , "chance" : 0.15 , "stock" : 1000 }
        ]'));

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $random_lists = RandomList::all();

        foreach ($this->items as $key => $item) {
            $item_lists[$key] = [
                'item_name' => $item->name ?? null,
                'amount_spawned' => $random_lists->where('game_item_id', $item->game_item_id)->sum('amount') ?? 0,
                'latest_spawn' => $random_lists->where('game_item_id', $item->game_item_id)->last()->created_at ?? null,
            ];
        }

        return view('items', [
            'item_lists' => $item_lists
        ]);
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
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function random(Request $request)
    {

        for($i = 0 ; $i < 100 ; $i++) {
            $this->store_selected_items->push($this->_randomTimes());
            // Save the spawn in DB
            $random_list = new RandomList();
            $random_list->game_item_id = $this->_randomTimes()->game_item_id;
            $random_list->amount = 1;
            $random_list->save();
        }

        return redirect("/items");
    }

    private function _randomTimes ()
    {
        // Get a random item
        $randomed_item = collect($this->items)->random(1)->first();
        // Look for percentage this for this random
        $random = mt_rand() / mt_getrandmax();

        // check if random is lower than randomed item's chance or not
        if($random <= $randomed_item->chance)
            if($this->_checkStock($randomed_item))
                return $randomed_item;
            else
                return $this->_randomTimes();
        else
            return $this->_randomTimes();

    }

    private function _checkStock($item)
    {
        $total_amount_spawned = RandomList::where('game_item_id', $item->game_item_id)->sum('amount');
        return (int)$total_amount_spawned < $item->stock ? true : false;
    }
}
