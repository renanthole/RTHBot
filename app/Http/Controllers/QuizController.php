<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuizRequest;
use App\Models\Quiz;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $quizzes = new Quiz;

        $quizzes = $quizzes->paginate(15);

        return view('pages.quizzes.index', compact(['quizzes']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.quizzes.new');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(QuizRequest $request)
    {
        try {
            DB::beginTransaction();

            Quiz::create([
                'title' => $request->title,
                'description' => $request->description,
                'created_at' => now()
            ]);

            DB::commit();
            Alert::toast(__('message.success'), 'success');
            return redirect()->route('quizzes.index');
        } catch (Exception $e) {
            logger($e->getMessage());
            DB::rollBack();
            Alert::toast(__('message.error'), 'error')->persistent();
            return redirect()->route('quizzes.create')->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function show(Quiz $quiz)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function edit(Quiz $quiz)
    {
        return view('pages.quizzes.edit', compact(['quiz']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function update(QuizRequest $request, Quiz $quiz)
    {
        try {
            DB::beginTransaction();

            $quiz->update([
                'title' => $request->title,
                'description' => $request->description,
                'updated_at' => now()
            ]);

            DB::commit();
            Alert::toast(__('message.update'), 'success');
            return redirect()->route('quizzes.index');
        } catch (Exception $e) {
            logger($e->getMessage());
            DB::rollBack();
            Alert::toast(__('message.error'), 'error')->persistent();
            return redirect()->route('quizzes.edit', $quiz->id)->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function destroy(Quiz $quiz)
    {
        try {
            DB::beginTransaction();

            $quiz->delete();

            DB::commit();
            Alert::toast(__('message.delete'), 'warning');
            return redirect()->route('quizzes.index');
        } catch (Exception $e) {
            logger($e->getMessage());
            DB::rollBack();
            Alert::toast(__('message.error'), 'error')->persistent();
            return redirect()->route('quizzes.index')->withInput();
        }
    }
}
