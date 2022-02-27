<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Comment;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;

class CommentController extends Controller
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
    public function create(Request $request)
    {
        //return $request->content;
        $comment = new Comment();
        $comment->content = $request->content;
        $comment->blog_post_id = $request->blog_post_id;
        $comment->user_id = Auth::user()->user_id;
        $comment->date = new DateTime('now');
        $comment->save();
        $formattedDate = $this->formatDate($comment->date);

        return ['user'=> $comment->user()->get(['first_name', 'last_name', 'image_path'])[0], 'comment'=> $comment, 'formattedDate' => $formattedDate];
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
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        
        $comment = Comment::find($request->comment_id);

        if(Auth::user()->user_id == $comment->user->user_id){
            $comment->content = $request->content;
            $comment->date = new DateTime('now');
            $comment->save();
            $formattedDate = $this->formatDate($comment->date);
            return ['comment'=>$comment,'updated'=>true, 'formattedDate' => $formattedDate];
        }
        return ['content'=> $request->content, 'user'=>$comment->user, 'updated'=>false];
        
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $comment = Comment::find($request->comment_id);

        if(Auth::user()->user_id == $comment->user_id){
            $comment->delete();
            return ['removed'=>true, 'comment_id' => $request->comment_id];
        }

        return ['removed'=>true, 'comment_id' => $request->comment_id];
        
    }

    public function getAllComments($blog_post_id){
        Comment::where('blog_post_id', $blog_post_id)->join('user', 'user.user_id', '=', 'comment.user_id')->orderby('date', 'DESC')->get();
    }

    public function formatDate($date) {
        return $date->locale('pt')->timezone('Europe/Lisbon')->isoFormat('D MMMM, YYYY | H:mm');
    }
}
