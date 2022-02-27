<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $user = User::find($id);
        return view('pages.profile', ['user' => $user]);
    }

    public function showOwnProfile()
    {

        if (Auth::check()) {
            $user = Auth::user();
            return view('pages.profile', ['user' => $user]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $this->authorize('update', $user);

        if (!$this->validateRequest($request)) {
            return redirect('/user?error');
        }

        $validator = Validator::make($request->all(), ['new_password1' => 'required|string|min:6']);


        if (!Hash::check($request->input('actual_password'), $user->password)) {
            return redirect('/user' . '?UpdateUser="wrongPassword"');
        } else if ($request->input('new_password1') != '' && $request->input('new_password2') != '') {
            if ($request->input('new_password1') != $request->input('new_password2')) {
                return redirect('/user' . '?UpdateUser="wrongNewPassword"');
            } else if ($validator->fails()) {
                return redirect('/user' . '?UpdateUser="newPasswordNotValid"');
            } else {
                $user->password = bcrypt($request->input('new_password1'));
            }
        }
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->image_path = $this->uploadImg($request, $user); //$request->input('image_path');

        // $user->image_path = "../assets/product3.jpg"; //$request->input('image_path');
        $user->save();
        return redirect('/user' . '?UpdateUser="success"'); //view('pages.profile', ['user' => $user]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $user = User::find($request->user_id);

        if (Auth::user()->user_id == $user->user_id) {
            $user->delete();
            return ['removed' => true, 'comment_id' => $request->user_id];
        }

        return ['removed' => true, 'user_id' => $request->user_id];
    }

    public function validateRequest(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'first_name' => 'required|string|min:1',
                'last_name' => 'required|string|min:1'

            ]
        );
        if ($validator->fails()) {
            return false;
        }

        return true;
    }

    public function uploadImg(Request $request, $eventPost)
    {
        if ($request->hasFile('image_path')) {

            $filename = $request->image_path->getClientOriginalName();
            $request->image_path->storeAs('images', $filename, 'public');
            return $filename;
        } else return $eventPost->image_path;
    }

    public function inactivate(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();

            if(Hash::check($request->input('password'), $user->password)){
               
                $user->active = false;
                $user->save();
                Auth::logout();
                return redirect('/?accountDeleted');
            }
            else {
                return redirect('/?wrongPassword');
            }
        }
        return abort(403);
    }
}
