<?php

namespace App\Http\Controllers;

use App\Api\ApiManager;
use App\Http\Requests\QuizRequest;
use App\Models\Chat;
use App\Models\Device;
use App\Models\Message;
use App\Models\Question;
use App\Models\Quiz;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class QuizController extends Controller
{
    private $apiManager;

    public function __construct()
    {
        $this->apiManager = new ApiManager(config('z-api'));
    }

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
                'initial' => $request->initial,
                'nps' => $request->nps,
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
                'initial' => $request->initial,
                'nps' => $request->nps,
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

    /**
     * Send the specified resource from storage.
     *
     * @param  \App\Models\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function send(Quiz $quiz)
    {
        $devices = Device::get();

        return view('pages.quizzes.send', compact('quiz', 'devices'));
    }

    /**
     * Send the specified resource from storage.
     *
     * @param  \App\Models\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function sendStore(Quiz $quiz, Request $request)
    {

        try {
            DB::beginTransaction();

            $phone = $request->phone;
            $device = Device::where('id', $request->device_id)->first();

            $chat = Chat::create([
                'device_id' => $device->id,
                'quiz_id' => $quiz->id,
                'phone' => $phone,
                'finished_at' => null
            ]);

            if ($chat) {
                $question = Question::where('quiz_id', $quiz->id)->where('position', 1)->first();
                $this->apiManager->sendMessage($question->question, $phone, $device, $chat);

                DB::commit();
                Alert::toast(__('message.success'), 'success');
                return redirect()->route('quizzes.send', $quiz->id);
            }
        } catch (Exception $e) {
            DB::rollBack();
            logger($e->getMessage());
            return response()->json('Error: ' . $e->getMessage() . '. Line: ' . $e->getLine(), 500);
        }
    }
}
