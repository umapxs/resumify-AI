<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreResumeRequest;
use App\Http\Requests\UpdateResumeRequest;
use Illuminate\Support\Facades\Log;
use OpenAI\Laravel\Facades\OpenAI;
use App\Models\Resume;
use GuzzleHttp\Client;
use GuzzleHttp\Promise\Utils;

class ResumeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function store(StoreResumeRequest $request)
    {
        // Validate input_text form field and set a max length
        $request->validate([
            'input_text' => 'required|max:1000',
        ]);

        // Initialize the summarized variable
        $summarized = null;

        try {
            // Make the API call to OpenAI
            $response = OpenAI::completions()->create([
                'model' => 'text-davinci-003',
                'prompt' => 'Come up with a short summary with less than 250 characters for this text: ' . $request->input('input_text'),
                'max_tokens' => 100
            ]);

            // Extract the summarized text from the API response
            $summarized = $response['choices'][0]['text'];

        } catch (\Exception $e) {

            // Log for debugging purposes
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());

            // Set the summarized variable to null
            $summarized = null;

        }

        /**
         * Makes an API request to OpenAI for the translations
         */
        function translateText($model, $prompt, $summarized) {
            $response = OpenAI::completions()->create([
                'model' => $model,
                'prompt' => $prompt . $summarized,
                'max_tokens' => 150
            ]);

            return $response['choices'][0]['text'];
        }

        // Initialize $languages and $translationResults arrays
        $languages = ['English', 'Portuguese', 'Spanish'];
        $translationResults = [];

        // Translate answer for each language
        if ($summarized) {
            foreach ($languages as $language) {
                $prompt = 'Translate the following text to ' . $language . ': ' . $summarized;

                $translationResponses = OpenAI::completions()->create([
                    'model' => 'text-davinci-003',
                    'prompt' => $prompt,
                    'max_tokens' => 500,
                    'n' => 1,
                    'stop' => '\n'
                ]);

                $translation = $translationResponses['choices'][0]['text'];
                $translationResults[$language] = $translation;
            }
        }

        // Create Resume with the summarized field
        $resume = new Resume;

        $resume->user_id = auth()->id();
        $resume->input_text = $request->input('input_text');
        $resume->summarized = $summarized;

        // Loop for every language
        foreach ($languages as $language) {
            $resume->{$language . '_summarized'} = $translationResults[$language] ?? null;
        }

        $resume->save();

        // Save the summarized information in session
        $request->session()->flash('summarized', $summarized);

        // Redirect to the desired page based on the 'redirect' parameter
        if ($request->has('redirect') && $request->input('redirect') === 'dashboard') {
            return redirect()->route('resumify')->with('input_text', $request->input('input_text'));
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Resume $resume)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Resume $resume)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateResumeRequest $request, Resume $resume)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Resume $resume)
    {
        //
    }
}
