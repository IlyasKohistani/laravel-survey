<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Survey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SurveyController extends Controller
{

    /**
     * Display a listing of the resource for dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        // Load current user all survey with their categorized result
        $user_surveys = Answer::whereHas('survey', function ($q) {
            $q->where('user_id',  Auth::id());
        })->select('category_id', DB::raw('count(*) as category_count'))
            ->groupBy('category_id')->orderBy('category_id')->get()->pluck('category_count', 'category_id');


        // Load all users survey with their categorized result
        $all_surveys = Answer::select('category_id', DB::raw('count(*) as category_count'))
            ->groupBy('category_id')->orderBy('category_id')->get()->pluck('category_count', 'category_id');


        return view('dashboard')->with(['user_surveys' => $user_surveys, 'all_surveys' => $all_surveys]);
    }


    /**
     * Display a listing of the survey for current user.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Load current user all survey with their categorized result
        $data = Survey::where('user_id', Auth::id())->with(['answers' => function ($query) {
            return $query->select('survey_id', 'category_id', DB::raw('count(*) as category_count'))
                ->groupBy(['category_id', 'survey_id'])->orderBy('category_id')->get();
        }])->orderBy('id', 'DESC')->get();


        return view('surveys')->with(['surveys' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('take-survey');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'answers' => ['required', 'array', 'min:1'],
            'answers.*.answers' => ['required', 'array', 'min:9'],
            'answers.*.answers.*.category_id' => ['required'],
            'answers.*.answers.*.answer' => ['required']
        ]);

        // Get the resulted array from data
        $preparedData = $this->prepareResultAnswers($data["answers"]);
        $total_questions = $preparedData['total_questions'];
        $results =  $preparedData['results'];


        // try storing data
        try {
            $survey = new Survey();
            $survey->user_id = auth()->user()->id;
            $survey->username = auth()->user()->name;
            $survey->total_questions = $total_questions;
            $survey->save();

            // Store answers if not empty
            if (!empty($results))
                $survey->answers()->createMany($results);
        } catch (\Throwable $th) {
            $survey->answers()->delete();
            $survey->delete();
            return redirect()->back()->withInput($request->all())->withErrors(['error' => $th->getMessage()]);
        }

        return redirect()->route('surveys.index')->with(['success' => 'Congratulations! You have successfully completed a survey.', 'survey_id' => $survey->id]);
    }


    /**
     * Prepare answers to store.
     */
    public function prepareResultAnswers($answers, $parent_key = null, $results = [], $total_questions = 0)
    {
        // Loop through answers and prepare for store
        foreach ($answers as $key => $answer) {
            array_push(
                $results,
                [
                    'parent_id' => $parent_key,
                    'question_id' => $key,
                    'answer_id' => $answer['answer'],
                    'category_id' => $answer['category_id']
                ]
            );
            // Generate the branching answers if exist
            if (isset($answer['answers'])) {
                $branchResults = $this->prepareResultAnswers($answer['answers'], $key, $results, $total_questions);
                $results =  $branchResults['results'];
                $total_questions =  $branchResults['total_questions'];
            }
            // Increment number of questions
            $total_questions++;
        }

        return ['results' => $results, 'total_questions' => $total_questions];
    }
}
