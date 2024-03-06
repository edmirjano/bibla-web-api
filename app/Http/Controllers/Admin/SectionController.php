<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book\Book;
use App\Models\Section\Section;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\Topic\Topic;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $sections = Section::with('topic')->get();

        return view('section.index', compact('sections'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        session(['previous_url' => url()->previous()]);
        $topicId = $request->input('topic_id');
        if (isset($topicId)) {
            $topics = [Topic::find($topicId)];
            return view('section.edit', compact('topics'));
        }
        $topics = Topic::all();
        return view('section.edit', compact('topics'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'topic_id' => 'required|exists:topics,id',
        ]);

        Section::create([
            'name' => $request->name,
            'description' => $request->description,
            'topic_id' => $request->topic_id,
        ]);
        $session = session('previous_url');
        session()->forget('previous_url');
        return redirect()->to($session);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Section $section)
    {
        session(['previous_url' => url()->previous()]);

        $topics = Topic::all();
        return view('section.edit', compact('topics', 'section'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Section $section)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'topic_id' => 'required|exists:topics,id',
        ]);

        $section->update([
            'name' => $request->name,
            'description' => $request->description,
            'topic_id' => $request->topic_id,
        ]);
        $session = session('previous_url');
        session()->forget('previous_url');
        return redirect()->to($session);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Section $section): RedirectResponse
    {
        // Delete the Section
        $section->delete();

        // Redirect to the books index page
        return redirect()->back();

    }
}
