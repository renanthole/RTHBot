<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Quiz;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class AnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Quiz $quiz)
    {
        $answers = Answer::where('quiz_id', $quiz->id);

        $answers = $answers->paginate(15);

        return view('pages.answers.index', compact(['quiz', 'answers']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Quiz $quiz)
    {
        $questions = Question::quizId($quiz->id)->get();

        return view('pages.answers.new', compact(['quiz', 'questions']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Quiz $quiz)
    {
        try {
            DB::beginTransaction();

            Answer::create([
                'quiz_id' => $quiz->id,
                'question_id' => $request->question,
                'next_id' => $request->next_question == 'finish' ? null : $request->next_question,
                'free' => is_null($request->option) ? true : false,
                'option' => $request->option,
                'created_at' => now()
            ]);

            DB::commit();
            Alert::toast(__('message.success'), 'success');
            return redirect()->route('answers.index', $quiz->id);
        } catch (Exception $e) {
            logger($e->getMessage());
            DB::rollBack();
            Alert::toast(__('message.error'), 'error')->persistent();
            return redirect()->route('answers.create', $quiz->id)->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function show(Answer $answer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function edit(Quiz $quiz, Answer $answer)
    {
        $questions = Question::quizId($quiz->id)->get();

        return view('pages.answers.edit', compact(['quiz', 'answer', 'questions']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Quiz $quiz, Answer $answer)
    {
        try {
            DB::beginTransaction();

            $answer->update([
                'quiz_id' => $quiz->id,
                'question_id' => $request->question,
                'next_id' => $request->next_question == 'finish' ? null : $request->next_question,
                'free' => is_null($request->option) ? true : false,
                'option' => $request->option,
                'updated_at' => now()
            ]);

            DB::commit();
            Alert::toast(__('message.update'), 'success');
            return redirect()->route('answers.index', $quiz->id);
        } catch (Exception $e) {
            logger($e->getMessage());
            DB::rollBack();
            Alert::toast(__('message.error'), 'error')->persistent();
            return redirect()->route('answers.edit', [$quiz->id, $answer->id])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Quiz $quiz, Answer $answer)
    {
        try {
            DB::beginTransaction();

            $answer->delete();

            DB::commit();
            Alert::toast(__('message.delete'), 'warning');
            return redirect()->route('answers.index', $quiz->id);
        } catch (Exception $e) {
            logger($e->getMessage());
            DB::rollBack();
            Alert::toast(__('message.error'), 'error')->persistent();
            return redirect()->route('answers.index', $quiz->id)->withInput();
        }
    }
}
