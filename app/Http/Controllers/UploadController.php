<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadController extends Controller
{
    //
    public function add()
  {
      return view('records.form');
  }

  public function create(Request $request)
  {
      $record = new Record;
      $form = $request->all();

      //s3アップロード開始
      $image = $request->file('image');
      // バケットの`myprefix`フォルダへアップロード
      $path = Storage::disk('s3')->putFile('myprefix', $image, 'public');
      // アップロードした画像のフルパスを取得
      $record->image_path = Storage::disk('s3')->url($path);

      $record->save();

      return redirect('records/form');
  }
}
