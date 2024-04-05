<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostStore;
use App\Models\post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data=post::all();
        return view('posts.showall',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostStore $request)
    {
        $input = $request-> validated();
        post::create($input);
        return redirect()->back()->withSuccess('post created');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        post::destroy($id);
        return redirect()->back()->withSuccess('post is deleted');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = post::find($id);
        return view('posts.editUser',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserStore $request, string $id)
    {
        $input = $request-> validated();
        Post::where('id',$id)->update($input);
        return redirect()->back()->withSuccess('post updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

    }
}
