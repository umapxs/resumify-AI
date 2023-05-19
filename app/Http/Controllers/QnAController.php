<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQnARequest;
use App\Http\Requests\UpdateQnARequest;
use Illuminate\Support\Facades\Log;
use OpenAI\Laravel\Facades\OpenAI;
use App\Models\QnA;
use App\Models\Resume;

class QnAController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('QnA');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreQnARequest $request)
    {
        // Validate input_text form field and set a max lenght
        $request->validate([
            'input_text' => 'required|max:200',
        ]);

        // Get all the Resumes in the database
        $resumes = Resume::all();

        $prompt = "Please answer the following question as concisely as possible: " . $request->input('input_text') . " using the context from this database:\n";

        foreach ($resumes as $resume) {
            $prompt .= "Raw text: " . $resume->input_text . "\n";
            /* $prompt .= "Summarized text: " . $resume->summarized . "\n"; */
        }

        /* $prompt .= "If the question was complete nonsense, respond with the word 'Unknown'." . "\n"; */

        try {
            // Make the API call to OpenAI
            $response = OpenAI::completions()->create([
                'model' => 'text-davinci-003',
                'prompt' => $prompt,
                'max_tokens' => 100
            ]);

            // Extract the answer text from the API response
            $answer = $response['choices'][0]['text'];

            // Create Resume with the summarized field
            $QnA = new QnA;

            $QnA->user_id = auth()->id();
            $QnA->question = $request->input('input_text');
            $QnA->answer = $answer;

            $QnA->save();

            // Save the summarized information in session
            $request->session()->flash('answer', $answer);

            // Redirect to the desired page based on the 'redirect' parameter
            if ($request->has('redirect') && $request->input('redirect') === 'Q&A') {
                return redirect()->route('Q&A')->with('input_text', $request->input('input_text'));
            }

        } catch (\Exception $e) {
            // Log for debugging purposes
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());

            // Handle the OpenAI API exception
            return back()->withError('An error occurred while making the API call.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(QnA $qnA)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(QnA $qnA)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateQnARequest $request, QnA $qnA)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(QnA $qnA)
    {
        //
    }
}
