<?php

namespace App\Http\Controllers;

use App\Models\Seeking;
use Illuminate\Http\Request;
use App\Http\Requests\SeekingRequest;

class SeekingController extends Controller
{
    public function index()
    {
        $seekings = Seeking::with('user')->get();

        return view('seeking.seekings', compact('seekings'));
    }

    public function create()
    {
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


    public function getMySeekings()
    {
        $user = auth()->user();

        // 自分の募集を取得するクエリ
        $seekings = Seeking::where('user_id', $user->id)->get();

        return view('seeking.my_seekings', compact('seekings'));
    }
}