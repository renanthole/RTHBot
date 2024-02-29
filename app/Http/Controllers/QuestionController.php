<?php

namespace App\Http\Controllers;

use App\Models\{Question, Quiz};
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Quiz $quiz)
    {
        $questions = Question::where('quiz_id', $quiz->id);

        $questions = $questions->paginate(15);

        return view('pages.questions.index', compact(['quiz', 'questions']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Quiz $quiz)
    {
        return view('pages.questions.new', compact(['quiz']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Quiz $quiz, Request $request)
    {
        try {
            DB::beginTransaction();

            Question::create([
                'quiz_id' => $quiz->id,
                'position' => $request->position,
                'title' => $request->title,
                'question' => $request->question,
                'created_at' => now()
            ]);

            DB::commit();
            Alert::toast(__('message.success'), 'success');
            return redirect()->route('questions.index', $quiz->id);
        } catch (Exception $e) {
            logger($e->getMessage());
            DB::rollBack();
            Alert::toast(__('message.error'), 'error')->persistent();
            return redirect()->route('questions.create', $quiz->id)->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Quiz $quiz, Question $question)
    {
        return view('pages.questions.edit', compact(['quiz', 'question']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Quiz $quiz, Question $question)
    {
        try {
            DB::beginTransaction();

            $question->update([
                'quiz_id' => $quiz->id,
                'position' => $request->position,
                'title' => $request->title,
                'question' => $request->question,
                'updated_at' => now()
            ]);

            DB::commit();
            Alert::toast(__('message.update'), 'success');
            return redirect()->route('questions.index', $quiz->id);
        } catch (Exception $e) {
            logger($e->getMessage());
            DB::rollBack();
            Alert::toast(__('message.error'), 'error')->persistent();
            return redirect()->route('questions.edit', [$quiz->id, $question->id])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Quiz $quiz, Question $question)
    {
        try {
            DB::beginTransaction();

            $question->delete();

            DB::commit();
            Alert::toast(__('message.delete'), 'warning');
            return redirect()->route('questions.index', $quiz->id);
        } catch (Exception $e) {
            logger($e->getMessage());
            DB::rollBack();
            Alert::toast(__('message.error'), 'error')->persistent();
            return redirect()->route('questions.index', $quiz->id)->withInput();
        }
    }
}
