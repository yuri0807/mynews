<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// 追記
use App\Models\Profile;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $profiles = Profile::all()->sortByDesc('updated_at');

        if (count($profiles) > 0) {
            $headline = $profiles->shift();
        } else {
            $headline = null;
        }

        // news/index.blade.php ファイルを渡している
        // また View テンプレートに headline、 posts、という変数を渡している
        return view('profile.index', ['headline' => $headline, 'profiles' => $profiles]);
    }
}