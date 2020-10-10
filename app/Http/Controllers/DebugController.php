<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DebugController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        die('here');
    }

    public function clubimport()
    {
        $json = Storage::disk('local')->get('clubs.json');
        $clubs = json_decode($json, true);

        $collection = collect($clubs);
        $unique = $collection->unique('logo');
        $clubs = $unique->values()->all();

        $leagues = $this->getLeagues($clubs, false);
        dd($leagues);


    }

    /**
     * @param $clubs
     * @return array $formattedLeagues
     * @example "English Premier League" => array:1 [0 => "England"]
     */
    private function getLeagues($clubs, $default_format = true) {
        $formattedLeagues = [];
        if ($default_format) {
            foreach ($clubs as $club) {
                $k = $club['league'];
                $formattedLeagues[$k] = [
                    $club['country']
                ];
            }
        } else {
            asort($clubs);
            foreach ($clubs as $club) {
                $k = $club['country'];
                $formattedLeagues[$k][] = [
                    $club['name']
                ];
            }
        }

        dd($formattedLeagues);
        return $formattedLeagues;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
