<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('view', Auth::user());
        if (!Auth::user()->isAdmin())
            return view('errors.403');
        $users = User::where('active', true)->get();
        return view('pages.administration', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Auth::user());
        if (!Auth::user()->isAdmin())
            return view('errors.403');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('update', Auth::user());
        if (!Auth::user()->isAdmin())
            return view('errors.403');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('view', Auth::user());
        if (!Auth::user()->isAdmin())
            return view('errors.403');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('update', Auth::user());
        if (!Auth::user()->isAdmin())
            return view('errors.403');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->authorize('update', Auth::user());
        if (!Auth::user()->isAdmin())
            return view('errors.403');
        $user = User::find($request->user_id);
        $user->role = $request->role;
        $user->save();
        return true;
    }

    public function inactivate(Request $request)
    {
        if (Auth::check() && Auth::user()->isAdmin()) {
            $user = User::find($request->user_id);
            $user->active = false;
            $user->save();
            return ['user_id' => $user->user_id];
        }
        return abort(403);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete', Auth::user());
        if (!Auth::user()->isAdmin())
            return view('errors.403');
    }
}
