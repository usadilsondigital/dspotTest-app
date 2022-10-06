<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Http\Requests\StoreProfileRequest;
use App\Http\Requests\UpdateProfileRequest;

use App\Graph;

class ProfileController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $profiles = Profile::all();
        return view('profilesview.index', ['profiles' => $profiles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('profilesview.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProfileRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProfileRequest $request)
    {
        
            try {
                $firstNameX = $request->first_name;
                $lastNameX = $request->last_name;
                $phoneX = $request->phone;
                $addressX = $request->address;
                $cityX = $request->city;
                $stateX = $request->state;
                $zipcodeX = $request->zipcode;
                $availableX = $request->available;

                $profile = Profile::firstOrNew(['first_name' =>  $firstNameX]);  
                if ($request->hasFile('image')) {              
                $profile->img = request()->file('image')->store('public/images');
                }
                else{
                    $profile->img = "https://images.pexels.com/photos/220453/pexels-photo-220453.jpeg?auto=compress&cs=tinys
                    rgb&dpr=1&w=500";
                }
                $profile->first_name = $firstNameX;
                $profile->last_name = $lastNameX;
                $profile->phone = $phoneX;
                $profile->address = $addressX;
                $profile->city = $cityX;
                $profile->state = $stateX;
                $profile->zipcode = $zipcodeX;
                $profile->available = $availableX;
                $profile->save();
                return redirect('/profiles');
            } catch (\Exception $e) {
                echo 'Message: ' . $e->getMessage();
            }
       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function show(Profile $profile)
    {
        //$exists = \Storage::disk('public')->exists('images/'."SSsrZtP9HT4c1HRU0LK1bhvCgeKSv0hGvxK0jWTO.jpg");
        //dd($exists);
        $str = $profile->img;
        $imglocal = 0;
        if (str_contains($profile->img, 'public/images/')) { 
            $str = str_replace("public/images/","",$str);
            $imglocal = 1;
        }
        
        return view('profilesview.show', ['profile' => $profile,'str'=>$str,'imglocal'=>$imglocal]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function edit(Profile $profile)
    {
        return view('profilesview.edit', ['profile' => $profile]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProfileRequest  $request
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProfileRequest $request, Profile $profile)
    {
        try {
            $firstNameX = $request->first_name;
            $lastNameX = $request->last_name;
            $phoneX = $request->phone;
            $addressX = $request->address;
            $cityX = $request->city;
            $stateX = $request->state;
            $zipcodeX = $request->zipcode;
            $availableX = $request->available;

            $profilePatched = Profile::Where(['id' => $profile->id])->first(); //FindorFail

            if ($request->hasFile('image')) {              
                $profilePatched->img = request()->file('image')->store('public/images');
                }
                else{
                    $profilePatched->img = "https://images.pexels.com/photos/220453/pexels-photo-220453.jpeg?auto=compress&cs=tinys
                    rgb&dpr=1&w=500";
                }

            $profilePatched->first_name = $firstNameX;
            $profilePatched->last_name = $lastNameX;
            $profilePatched->phone = $phoneX;
            $profilePatched->address = $addressX;
            $profilePatched->city = $cityX;
            $profilePatched->state = $stateX;
            $profilePatched->zipcode = $zipcodeX;
            $profilePatched->available = $availableX;
            $profilePatched->save();
            return redirect('/profiles');
        } catch (\Exception $e) {
            echo 'Message: ' . $e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profile $profile)
    {
        $profileToDelete = Profile::Where(['id' => $profile->id])->first();

        /*//THIS VERSION IS SHORTER BUT DOESN'T USE DETACH
        $deleted  = \DB::table('friend_profiles')
            ->where('profile_id', $profile->id)
            ->orWhere('friend_id', $profile->id)
            ->delete();*/

        //DETACH VERSION IS LONGER
        foreach ($profileToDelete->friends as $friend) {
            $this->removeFriend($profileToDelete, $friend);
        }
        $pluckIds = \DB::table('friend_profiles')->where('friend_id', $profile->id)->pluck('profile_id');
        foreach ($pluckIds as $value) {
            $profileStarter = Profile::Where(['id' => $value])->first();
            foreach ($profileStarter->friends as $friendSeached) {
                if ($friendSeached->id == $profile->id) {
                    $this->removeFriend($profileStarter, $profile->id);
                }
            }
        }

        $profileToDelete->delete();
        return redirect('/profiles');
    }


    public function arrayNotFriends(Profile $profile)
    {
        $profileAllIds = Profile::all()->pluck('id');
        $notfriends = [];
        $arraySociables = [];
        $pivot = \DB::table('friend_profiles')->where('profile_id', $profile->id)->orWhere('friend_id', $profile->id)->get();
        if (count($pivot) > 0) {
            foreach ($pivot as $key => $value) {
                $idAuxiliar = $value->profile_id;
                $idAuxiliar2 = $value->friend_id;
                if (!in_array($idAuxiliar, $arraySociables)) {
                    $arraySociables[] = $idAuxiliar;
                }
                if (!in_array($idAuxiliar2, $arraySociables)) {
                    $arraySociables[] = $idAuxiliar2;
                }
            }
        }
        $collection  = collect($arraySociables);
        $diff = $profileAllIds->diff($collection);
        $notfriends = $diff->all();
        if (($key = array_search($profile->id, $notfriends)) !== false) {
            unset($notfriends[$key]);
        }
        return ($notfriends);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createFriend(Profile $profile)
    {
        $notfriends = $this->arrayNotFriends($profile);
        $profilesNotFriends = collect([]);
        foreach ($notfriends as $key => $value) {
            $profilesNotFriends->push(Profile::where('id', $value)->first());
        }
        return view('profilesview.createfriend', [
            'profile' => $profile,
            'profilesNotFriends' => $profilesNotFriends
        ]);
    }

    public function addFriend(Profile $profile, $id)
    {
        $profile->friends()->attach($id);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProfileRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function newFriend(StoreProfileRequest $request, Profile $profile)
    {
        try {
            $idX = $request->newfriend;
            $profile->friends()->attach($idX);
            return redirect('/profiles');
        } catch (\Exception $e) {
            echo 'Message: ' . $e->getMessage();
        }
    }

    public function removeFriend(Profile $profile, $id)
    {
        $profile->friends()->detach($id);
    }

    /**
     * Given a profileId, return all the friends
     *
     * @param  $profileId
     * @return \Illuminate\Http\Response
     */
    public function allFriends($profileId)
    {

        $profiles = null;
        $arrStarters = [];
        //one solution approach
        $profileFounded = Profile::Where(['id' => $profileId])->first();
        $pluckIds = \DB::table('friend_profiles')->where('friend_id', $profileId)->pluck('profile_id');

        foreach ($pluckIds as $value) {
            $profileStarter = Profile::Where(['id' => $value])->first();
            array_push($arrStarters, $profileStarter);
        }
        foreach ($profileFounded->friends as $friend) {
            array_push($arrStarters, $friend);
        }
        $profiles = collect($arrStarters);
        return view('profilesview.friends', ['profiles' => $profiles, 'sociable' => $profileFounded]);
    }

    /*Given 2 ids, shortest connection between */
    public function shortestPath($id1, $id2)
    {
        $profiles = Profile::all();
        $graph = null;
        foreach ($profiles as $p) {
            $first = $p->first_name;
            $result1 = [];
            $pluckIds = \DB::table('friend_profiles')->where('friend_id', $p->id)->pluck('profile_id');
            foreach ($pluckIds as $value) {
                $profileStarter = Profile::Where(['id' => $value])->first();
                array_push($result1, $profileStarter->first_name);
            }

            foreach ($p->friends as $f) {
                array_push($result1, $f->first_name);
            }

            $graph[$first] = $result1;
        }
        $g = new Graph($graph);
        $nameTosearch1 = Profile::findorFail($id1)->first_name;
        $nameTosearch2 = Profile::findorFail($id2)->first_name;

        $message = ($g->breadthFirstSearch($nameTosearch1, $nameTosearch2));
        echo $message;
    }

    public function collectionOfNonFriends(Profile $profile)
    {
        $va = \DB::table('friend_profiles')
            ->where('profile_id', $profile->id)
            ->orWhere('friend_id', $profile->id)
            ->get();

        dd($va);
    }


    /*API */

    /**
     * Display a listing of the resource.
     *
     * @return \App\Models\Profile  $profiles
     */
    public function api_index()
    {
        $profiles = Profile::all();
        return $profiles;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Profile  $profile
     * @return \App\Models\Profile  $profile
     */
    public function api_show(Profile  $profile)
    {
        return $profile;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProfileRequest  $request
     * @return \App\Models\Profile  $profile
     */
    public function api_store($imgX, $firstNameX, $lastNameX, $phoneX, $addressX, $cityX, $stateX, $zipcodeX, $availableX)
    {
        try {
            $profile = Profile::firstOrNew(['first_name' =>  $firstNameX]);
            $profile->img = $imgX;
            $profile->last_name = $lastNameX;
            $profile->phone = $phoneX;
            $profile->address = $addressX;
            $profile->city = $cityX;
            $profile->state = $stateX;
            $profile->zipcode = $zipcodeX;
            $profile->available = $availableX;
            $profile->save();
            return redirect('/api/profiles');
        } catch (\Exception $e) {
            echo 'Message: ' . $e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Profile  $profile
     * @return \App\Models\Profile  $profile
     */
    public function api_destroy(Profile $profile)
    {
        $profileToDelete = Profile::Where(['id' => $profile->id])->first();
        $profileToDelete->delete();
        return redirect('/api/profiles');
    }
}
