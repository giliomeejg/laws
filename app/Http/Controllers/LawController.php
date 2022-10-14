<?php

namespace App\Http\Controllers;

use App\Models\Law;
use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class LawController extends Controller
{
    private function validation($id = -1)
    {
        return [
            'law_url' => ['required', 'max:2000', 'unique:laws,law_url,{$id},id,deleted_at,NULL'],
        ];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $laws = Law::latest()->paginate(10);

        return Inertia::render('Law/Index', ['laws' => $laws]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Law/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate($this->validation());

        $user = Auth::user();

        Law::create(
            [
                'user_id' => $user->id,
                'law_url' => $request->law_url,
            ]
        );

        return Redirect::route('laws.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Law  $law
     * @return \Illuminate\Http\Response
     */
    public function show(Law $law)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Law  $law
     * @return \Illuminate\Http\Response
     */
    public function edit(Law $law)
    {
        return Inertia::render('Law/Edit', [
            'law' => [
                'id' => $law->id,
                'law_url' => $law->law_url,
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Law  $law
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Law $law)
    {
        $data = $request->validate($this->validation($law->id));
        $law->update($data);


        return Redirect::route('laws.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Law  $law
     * @return \Illuminate\Http\Response
     */
    public function destroy(Law $law)
    {
        $law->delete();

        return Redirect::route('laws.index');
    }

    public static function process()
    {
        $laws = Law::whereNull('processed_at')->where('nr_errors', '<', 10)->orderBy('id', 'asc')->get();
        foreach ($laws as $key => $law) {
            $year = new Carbon($law->created_at);
            $year = $year->year;
            $location = 'laws/' . $year . '/' . $law->id . '.pdf';
            $path = pathinfo($location);

            try {
                $pdf = file_get_contents($law->law_url);
                Storage::disk('local')->makeDirectory($path['dirname']);

                Storage::disk('local')->put($location, $pdf);
                $parser = new \Smalot\PdfParser\Parser();
                $pdf = $parser->parseFile(Storage::disk('local')->path($location));
                $text = $pdf->getText();

                $law->number_of_words = str_word_count($text);
                $law->processed_at = Carbon::now();
                $law->save();
            } catch (Exception $e) {
                echo 'error processing ' . $location;
                $law->last_error_at = Carbon::now();
                $law->nr_errors += 1;
                $law->save();
            }
        }
    }
}
