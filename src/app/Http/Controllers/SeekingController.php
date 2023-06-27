<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Seeking;
use Illuminate\Http\Request;
use App\Http\Requests\SeekingRequest;
use Illuminate\Support\Facades\Auth;

class SeekingController extends Controller
{
    public function index()
    {
      //ログインしている場合 自分の募集は表示しない
      if (auth()->check()) {
        $canLike = true;
        $seekings = Seeking::where('user_id', '!=', auth()->user()->id)
            ->with(['likes' => function ($query) {
                $query->where('user_id', auth()->user()->id);
            }])
            ->with('user')
            ->get();
      } else {
        $canLike = false;
        $seekings = Seeking::all();
      }

        return view('seeking.seekings', compact('seekings', 'canLike'));
    }

    public function create()
    {
        if (!Auth::check()) {
          return redirect()->route('login')->with('message', '投稿するにはログインが必要です。');
        }
      

        return view('seeking.create');
    }

    public function store(SeekingRequest $request)
    {
        $imagePath = $request->file('seeking_thumbnail')->store('seeking_thumbnail', 'public');

        $seeking = new Seeking;
        $seeking->user_id = auth()->user()->id;
        $seeking->title = $request->title;
        $seeking->content = $request->content;
        $seeking->seeking_thumbnail = $imagePath;

        // ファイルが送信された場合、DBに保存する
        if ($request->hasFile('seeking_thumbnail')) {
            $seeking_thumbnail = $request->file('seeking_thumbnail');
            $filename = time() . '.' . $seeking_thumbnail->getClientOriginalExtension();
            $seeking_thumbnail->storeAs('public/seeking_thumbnail', $filename); // ファイルを保存するディレクトリを指定する
            $seeking->seeking_thumbnail = $filename;
        }


        $seeking->save();

        return redirect()->back()->with('success', 'Seeking created successfully.');
    }

    public function show($id)
    {
        $seeking = Seeking::findOrFail($id);
        $my_seeking = false;
        $my_like_check = false;
        $logged_in = false;

        //ログインしている場合
        if (Auth::check()) {
          $logged_in = true;

          //ユーザー取得
          $user = Auth::user();
          $user_id = $user->id;

          //自分の募集かどうか
          $my_seeking = ($seeking->user_id === $user_id) ? true : false;

          //自分は気になるを押してある募集か判別
          $my_like_check = (Like::where('seeking_id', $id)->where('user_id', $user->id)->count() > 0);

          return view('seeking.show', compact('seeking', 'logged_in', 'my_seeking', 'my_like_check'));

        } else {
          //ログインしていない場合
          return view('seeking.show', compact('seeking', 'logged_in', 'my_seeking', 'my_like_check'));
        }



        //自分の募集は編集可能、気になる不可能
        $canEdit = false;
        $canLike = true;

        if (Auth::check() && $seeking->user_id === Auth::user()->id) {
            $canEdit = true;
            $canLike = false;
        }

      


        return view('seeking.show', compact('seeking', 'canEdit', 'canLike', 'user_id', 'my_like_check'));
    }

    public function edit($id)
    {
        $seeking = Seeking::findOrFail($id);

        return view('seeking.edit', compact('seeking'));
    }

    public function update(Request $request, $id)
    {
        $seeking = Seeking::findOrFail($id);

        $seeking->title = $request->input('title');
        $seeking->content = $request->input('content');

        // ファイルが送信された場合、DBに保存する
        if ($request->hasFile('seeking_thumbnail')) {
            $seeking_thumbnail = $request->file('seeking_thumbnail');
            $filename = time() . '.' . $seeking_thumbnail->getClientOriginalExtension();
            $seeking_thumbnail->storeAs('public/seeking_thumbnail', $filename); // ファイルを保存するディレクトリを指定する
            $seeking->seeking_thumbnail = $filename;
        }

        $seeking->save();

        return redirect()->route('seeking.show', $seeking->id);
    }
}