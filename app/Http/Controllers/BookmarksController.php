<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookmarksController extends Controller
{
    //
    public function index()
    {
        $data = [];
        if (\Auth::check()) {
            $user = \Auth::user();
            $record = $user->feed_bookmark_records()->orderBy('created_at', 'desc')->paginate(10);
            
            $data = [
                'user' => $user,
                'records' => $records,
                ];
        }
        return view('welcome', $data);
    }
    
    //
    public function store($id)
    {
        
        \Auth::user()->bookmark($id);
        
        return back();
    }
    
    public function destroy($id)
    {
        
        \Auth::user()->unbookmark($id);
        
        return back();
    }
}
