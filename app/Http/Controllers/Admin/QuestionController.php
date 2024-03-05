<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question\Question;
use App\Models\Section\Section;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $questions = Question::with('section')->get();
        return view('question.index', compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        session(['previous_url' => url()->previous()]);
        $sections = Section::all();
        return view('question.edit', compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'description' => 'required|string|max:255',
            'section_id' => 'required|exists:sections,id',
        ]);

        Question::create($request->all());
        $session=session('previous_url');
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
    public function edit(Question $question)
    {
        session(['previous_url' => url()->previous()]);

        $sections = Section::all();
        return view('question.edit', compact('sections', 'question'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Question $question)
    {
        $request->validate([
            'description' => 'required|string|max:255',
            'section_id' => 'required|exists:sections,id',
        ]);
        $question->update(['description' => $request->description, "section_id" => $request->section_id]);
        $session=session('previous_url');
        session()->forget('previous_url');
        return redirect()->to($session);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question)
    {
        $question->delete();
        return redirect()->route('question.index');
    }
}
