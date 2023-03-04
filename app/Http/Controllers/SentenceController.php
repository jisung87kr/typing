<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Sentence;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SentenceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = request(['category_id']);
        $filters['limit'] = $request->input('limit') ? $request->input('limit') : 20;
        $sentences = Sentence::filter($filters)->inRandomOrder()->get();
        $categories = Category::all();
        $data = [
            'sentences' => $sentences,
            'categories' => $categories,
        ];
        return $request->wantsJson() ? $data : $data;
    }

    public function adminIndex(Request $request)
    {
        $filters = request(['category_id']);
        $sentences = Sentence::filter($filters)->paginate(30);
        return view('admin.sentence.index', compact('sentences'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sentence = new Sentence();
        return view('admin.sentence.create', compact('sentence'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'sentence' => 'required|string',
        ]);

        $sentence = Sentence::create($validate);

        return redirect()->route('admin.sentences.show', $sentence);
    }

    /**
     * Display the specified resource.
     */
    public function show(Sentence $sentence)
    {
        return view('admin.sentence.show', compact('sentence'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sentence $sentence)
    {
        return view('admin.sentence.edit', compact('sentence'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sentence $sentence)
    {
        $validate = $request->validate([
           'sentence' => 'required|string',
        ]);

        $sentence->update($validate);

        return redirect()->route('admin.sentences.show', compact('sentence'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Sentence $sentence)
    {
        $sentence->delete();

        return $request->wantsJson() ? route('admin.sentences') : redirect()->route('admin.sentences');
    }
}
