<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use Larafor\Bloodgroup\Models\BloodGroup;

Route::get('/bloodgroup', function () {

    $bloodgroupsData = config('bloodgroup.bloodgroups');
    foreach ($bloodgroupsData as $bloodgroup) {
        BloodGroup::firstOrCreate(['name' => $bloodgroup['name']], $bloodgroup);
    }

    $bloodgroups = BloodGroup::all();
    return $bloodgroups;
});

Route::get('/bloodgroup/{id}', function ($id) {
    $bloodgroup = BloodGroup::find($id);
    return $bloodgroup;
});

Route::get('/bloodgroup/name/{name}', function ($name) {
    $bloodgroup = BloodGroup::where('name', $name)->first();
    return $bloodgroup;
});

Route::get('/bloodgroup/model/{model}', function ($model) {
    $bloodgroups = BloodGroup::with($model)->get();
    return $bloodgroups;
});
// $users = User::with('bloodgroup')->get();
// dd($users);
// return $users;