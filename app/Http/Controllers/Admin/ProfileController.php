<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Profile;

use App\Models\ProfileHistory;
use Carbon\Carbon;

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
        
        unset($form['_token']);
        
        $profile->fill($form);
        $profile->save();

        return redirect('admin/profile/create');
    }
    
    public function index(Request $request)
    {
        $cond_name = $request->cond_name;
        if ($cond_name != '') {
            $profiles = Profile::where('name', $cond_name)->get();
        } else {
            $profiles = Profile::all();
        }
        return view('admin.profile.index', ['profiles' => $profiles, 'cond_name' => $cond_name]);
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
        
        unset($profile_form['remove']);
        unset($profile_form['_token']);
        
        $profile->fill($profile_form)->save();
        
        // 以下を追記
        $profileHistory = new ProfileHistory();
        $profileHistory->profile_id = $profile->id;
        $profileHistory->edited_at = Carbon::now();
        $profileHistory->save();

        return redirect('admin/profile');
    }
// 以下を追記

    public function delete(Request $request)
    {
        // 該当するNews Modelを取得
        $profile = Profile::find($request->id);

        // 削除する
        $profile->delete();

        return redirect('admin/profile');
    }
}
