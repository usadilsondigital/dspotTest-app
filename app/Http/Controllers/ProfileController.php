<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Http\Requests\StoreProfileRequest;
use App\Http\Requests\UpdateProfileRequest;

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
            $profile->img = "hardcoded for now";
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function edit(Profile $profile)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profile $profile)
    {
        //
    }

    /**
     * Display all the friend of a profile specified .
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function friends($id)
    {
        $profile = Profile::where('id',$id)->get();
        dd($profile);
    }

}
