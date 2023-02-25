<?php

namespace App\Http\Controllers;

use App\Models\SentenceUser;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SentenceUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::select('*')
            ->addSelect(DB::raw("(SELECT MAX(wpm) FROM sentence_user WHERE user_id = users.id) AS max_wpm"))
            ->addSelect(DB::raw("(SELECT AVG(wpm) FROM sentence_user WHERE user_id = users.id) AS avg_wpm"))
            ->addSelect(DB::raw("(SELECT COUNT(*) FROM sentence_user WHERE user_id = users.id) AS sentence_cnt"))
            ->having('sentence_cnt', '>', 0)
            ->orderBy('sentence_cnt', 'desc')
            ->get();
        return view('rank', compact('users'));
    }

    public function user()
    {
        $user = Auth::User() ? Auth::User() : new User;
        return view('user', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'input'       => 'required|string',
            'length'      => 'required|integer',
            'correct'     => 'integer',
            'wrong'       => 'required|integer',
            'perfect'     => 'required|boolean',
            'started_at'  => 'required',
            'finished_at' => 'required',
            'wpm'         => 'required|integer',
            'difftime'    => 'required|integer',
        ]);

        $validate['started_at'] = date('Y-m-d H:i:s', strtotime($validate['started_at']));
        $validate['finished_at'] = date('Y-m-d H:i:s', strtotime($validate['finished_at']));
        $validate['created_at'] = date('Y-m-d H:i:s');
        $validate['updated_at'] = $validate['created_at'];
        $validate['usetime'] = round(abs(strtotime($validate['finished_at']) - strtotime($validate['started_at'])),2);

        $request->user()->sentences()->attach($request->input('id'), $validate);

        $sentenceUser = SentenceUser::where('user_id', $request->user()->id)
            ->where('sentence_id', $request->input('id'))
            ->orderBy('id', 'desc')
            ->limit(1)->first();

        $sentenceUser->sentenceUserMetas()->createMany($request->input('sentenceArray'));
        return $request->wantsJson() ? $sentenceUser : $sentenceUser;
    }

    /**
     * Display the specified resource.
     */
    public function show(SentenceUser $sentenceUser): Response
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SentenceUser $sentenceUser): Response
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SentenceUser $sentenceUser): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SentenceUser $sentenceUser): RedirectResponse
    {
        //
    }
}
