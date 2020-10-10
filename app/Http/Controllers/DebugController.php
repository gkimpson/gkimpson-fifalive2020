<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\League;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DebugController extends Controller
{
    const CONFEDERATIONS = ['AFC', 'CAF', 'CONCACAF', 'CONMEBOL', 'OFC', 'UEFA'];
    const CONFEDERATION_MAPPINGS = [
        'Argentina' => 'CONMEBOL',
        'Australia' => 'AFC',
        'Austria' => 'UEFA',
        'Belgium' => 'UEFA',
        'Bolivia' => 'CONMEBOL',
        'Brazil' => 'CONMEBOL',
        'Chile' => 'CONMEBOL',
        'China PR' => 'AFC',
        'Colombia' => 'CONMEBOL',
        'Croatia' => 'UEFA',
        'Czech Republic' => 'UEFA',
        'Denmark' => 'UEFA',
        'Ecuador' => 'CONMEBOL',
        'England' => 'UEFA',
        'Finland' => 'UEFA',
        'France' => 'UEFA',
        'Germany' => 'UEFA',
        'Greece' => 'UEFA',
        'Italy' => 'UEFA',
        'Japan' => 'AFC',
        'Korea Republic' => 'AFC',
        'Mexico' => 'CONCACAF',
        'Netherlands' => 'UEFA',
        'Norway' => 'UEFA',
        'Paraguay' => 'CONMEBOL',
        'Peru' => 'CONMEBOL',
        'Poland' => 'UEFA',
        'Portugal' => 'UEFA',
        'Republic of Ireland' => 'UEFA',
        'Romania' => 'UEFA',
        'Russia' => 'UEFA',
        'Saudi Arabia' => 'AFC',
        'Scotland' => 'UEFA',
        'South Africa' => 'CAF',
        'Spain' => 'UEFA',
        'Sweden' => 'UEFA',
        'Switzerland' => 'UEFA',
        'Turkey' => 'UEFA',
        'Ukraine' => 'UEFA',
        'United Arab Emirates' => 'AFC',
        'United States' => 'CONCACAF',
        'Uruguay' => 'CONMEBOL',
        'Venezuela' => 'CONMEBOL',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    public function clubimport()
    {
        $json = Storage::disk('local')->get('clubs.json');
        $clubs = json_decode($json, true);

        $collection = collect($clubs);
        $unique = $collection->unique('logo');
        $clubs = $unique->values()->all();

        $leagues = $this->getLeagues($clubs, true);

        $this->insertLeagues($leagues);
        $this->insertClubs($clubs);
    }

    public function getCountries($leagues) {

    }

    /**
     * insert leagues into db if they don't already exisr
     * @param $leagues
     */
    public function insertLeagues($leagues) {
        foreach ($leagues as $key => $country) {
            $league = new League;
            $league->name = trim($key);
            $league->country = $country;
            $league->confederation = self::CONFEDERATION_MAPPINGS[$country];
            if (League::where('name', $key)->first() == false) {
                $league->save();
            }
        }
    }

    public function insertClubs($clubs) {
        try {
            foreach ($clubs as $key => $club) {
//                if (!$club['name']) {
//                    die('h');
//                }
                $club = new Club;
                $club->league_id = null;
                $club->name = $club['name'];
                $club->defence = $club['def'];
                $club->midfield = $club['mid'];
                $club->attack = $club['att'];
                $club->overall = $club['ova'];
                $club->logo = $club['logo'];
                $club->alt_logos = $club['srcset'];
                $club->save();
            }
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }

    }

    /**
     * @param $clubs
     * @return array $formattedLeagues
     * @example "English Premier League" => array[0 => "England"]
     */
    private function getLeagues($clubs, $default_format = true) {
        // need to add some logic for getting the confederation data...

        $formattedLeagues = [];
        if ($default_format) {
            foreach ($clubs as $club) {
                $formattedLeagues[$club['league']] = $club['country'];
            }
        } else {
            foreach ($clubs as $club) {
                $k = $club['country'];
                $formattedLeagues[$k][$club['league']][] = $club['name'];
            }
        }

//        foreach ($formattedLeagues as $k => $v) {
//            if ($insert) {
//                if (League::where('name', $club['league'])->first()) {
//                    //die('league exists');
//                } else {
//                    $league = new League;
//                    $league->name = $club['league'];
//                    $league->confederation = 'UEFA';
//                    $league->save();
//                }
//            }
//        }

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
