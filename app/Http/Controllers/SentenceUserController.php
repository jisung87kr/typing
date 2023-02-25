<?php

namespace App\Http\Controllers;

use App\Models\SentenceUser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class SentenceUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        DB::enableQueryLog();
        $sentenceUser = SentenceUser::where('user_id', '11')
            ->where('sentence_id', '1')
            ->limit(1)->first();
        $sentenceUser->sentenceUserMetas()->createMany([
           [
               'alphabet' => '1',
               'input' => '1',
               'correct' => true,
           ],
           [
               'alphabet' => '1',
               'input' => '1',
               'correct' => true,
           ]
        ]);
        $query = DB::getQueryLog();

//        dd(SentenceUser::first());
//        $item = $request->user()->sentences()->first();
//        dd($item->pivot->users);

//        dd(SentenceUser::first()->users);
//        $result = DB::select("SELECT * FROM sentence_user");
//        dd($result);
//        $item = $request->user()->sentences()->orderByPivot('id', 'desc')->first();
//        dd($item->pivot->user);
//        $item->pivot->sentenceUserMetas()->create([
//           'alphabet' => 'q',
//           'input' => 'q',
//        ]);

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
