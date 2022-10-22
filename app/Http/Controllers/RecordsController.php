<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Storage;
use App\Record;

class RecordsController extends Controller
{
    //
    public function index()
    {
        $data = [];
        if (\Auth::check()) { // 認証済みの場合
            // 認証済みユーザを取得
            $user = \Auth::user();
            // ユーザの投稿の一覧を作成日時の降順で取得
            // （後のChapterで他ユーザの投稿も取得するように変更しますが、現時点ではこのユーザの投稿のみ取得します）
            $records = $user->feed_records()->orderBy('created_at', 'desc')->paginate(10);

            $data = [
                'user' => $user,
                'records' => $records,
            ];
        }

        // Welcomeビューでそれらを表示
        return view('welcome', $data);
    }
    
    //public function add()
  //{
    //  return view('records.form');
  //}
    
    public function store(Request $request)
    {
        // バリデーション
        $request->validate([
            'content' => 'required|max:255',
            'file' => 'required',
        ]);
        //s3アップロード開始
      $image = $request->file('image');
      // バケットの`myprefix`フォルダへアップロード
      $path = Storage::disk('s3')->putFile('myprefix', $image, 'public');
      // アップロードした画像のフルパスを取得
      $image_path = Storage::disk('s3')->url($path);

      
      //return redirect('records/form');

        // 認証済みユーザ（閲覧者）の投稿として作成（リクエストされた値をもとに作成）
        $request->user()->records()->create([
            'content' => $request->content,
            'image_path' => $image_path,
        ]);

        // 前のURLへリダイレクトさせる
        return back();
    }
    
    public function destroy($id)
    {
        // idの値で投稿を検索して取得
        $record = \App\Record::findOrFail($id);

        // 認証済みユーザ（閲覧者）がその投稿の所有者である場合は、投稿を削除
        if (\Auth::id() === $record->user_id) {
            $record->delete();
        }

        // 前のURLへリダイレクトさせる
        return back();
    }
}
