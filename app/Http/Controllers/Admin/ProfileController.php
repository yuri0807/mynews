<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Profile;

class ProfileController extends Controller
{
    //
    public function add()
    {
        return view('admin.profile.create');
    }
    
     public function create (Request $request)
    {
    // Validationを行う
        $this->validate($request, Profile::$rules);

        $profile = new Profile;
        $form = $request->all();
        
        $profile->fill($form);
        $profile->save();

        return redirect('admin/profile/create');
    }
 
    // 以下を追記
    public function edit (Request $request)
    {
        // Modelからデータを取得する
        $profile = Profile::find($request->id);
        if (empty($profile)) {
            abort(404);
        }
        return view('admin/profile/edit', ['profile_form' => $profile]);
    }

    public function update(Request $request)
    {
       // Validationをかける
        $this->validate($request, Profile::$rules);
        // News Modelからデータを取得する
        $profile = Profile::find($request->id);
        // 送信されてきたフォームデータを格納する
        $profile_form = $request->all();
        
        // 該当するデータを上書きして保存する
        $profile->fill($profile_form)->save();

        return redirect('admin/profile');
    }
// 以下を追記

    public function delete(Request $request)
    {
        // 該当するNews Modelを取得
        $profile = Profile::find($request->id);

        // 削除する
        $profile->delete();

        return redirect('admin/profile/');
    }
}
