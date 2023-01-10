<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Actions\Search;
use App\Models\Magazine;
use Illuminate\Http\Request;
use App\Http\Requests\MagazineRequest;

class MagazineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function index(Request $request)
    {
        $magazines = [];
        if (empty($request->data)) {
            $magazines = Magazine::orderBy('id', 'desc')->paginate(10);
        }

        if (! empty($request->data)) {
            $magazines = (new Search)('App\Models\Magazine', $request->data);
        }

        return Inertia::render('Magazines', [
            'magazines' => $magazines,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function browse(Request $request)
    {
        $magazines = collect();
        if (empty($request->data)) {
            $magazines = Magazine::orderBy('id', 'desc')->paginate(12);
        }

        if (! empty($request->data)) {
            $magazines = (new Search)('App\Models\Magazine', $request->data);
        }

        return Inertia::render('Browse', [
            'currentMagazine' => $magazines->shift(),
            'magazines' => $magazines,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  MagazineRequest  $request
     */
    public function store(MagazineRequest $request)
    {
        $pdf_path = '';
        $file_name = '';
        $thumbnail_path = '';

        if ($request->file('pdf')) {
            $file_name = time().'_'.$request->file('pdf')->getClientOriginalName();
            $file_path = $request->file('pdf')->store($file_name, 'public');
            $pdf_path = url('/storage/'.$file_path);
        }

        if ($request->file('thumbnail')) {
            $thumbnail_path = $request->file('thumbnail')->store($file_name, 'public');
            $thumbnail_path = url('/storage/'.$thumbnail_path);
        }

        Magazine::create([
            'name' => $request['name'],
            'summary' => $request['summary'],
            'pdf_path' => $pdf_path,
            'thumbnail_path' => $thumbnail_path,
        ]);

        return redirect()->route('magazines.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Magazine  $magazine
     */
    public function show(Magazine $magazine)
    {
        $magazine->view_count = $magazine->view_count + 1;
        $magazine->save();

        return view(
            'view',
            [
                'pdf' => $magazine->pdf_path,
                'magazineId' => $magazine->id,
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  MagazineRequest  $request
     * @param  \App\Models\Magazine  $magazine
     */
    public function update(MagazineRequest $request, Magazine $magazine)
    {
        $magazine->update([
            'name' => $request['name'],
            'summary' => $request['summary'],
        ]);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Magazine  $magazine
     */
    public function destroy(Magazine $magazine)
    {
        $magazine->delete();

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Magazine  $magazine
     */
    public function time(Request $request, Magazine $magazine)
    {
        $magazine->total_time_open = $magazine->total_time_open + $request->time;

        $magazine->save();
    }
}
