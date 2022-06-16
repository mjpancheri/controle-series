<?php

namespace App\Http\Controllers;

use App\Http\Middleware\Authenticator;
use App\Http\Requests\SeriesFormRequest;
use App\Mail\SeriesCreated;
use App\Models\Series;
use App\Models\User;
use App\Repositories\SeriesRepository;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SeriesController extends Controller
{
    public function __construct(private SeriesRepository $repository)
    {
        // $this->middleware(Authenticator::class)->except('index');
    }

    public function index(Request $request)
    {
        $series = Series::all(); // with(['seasons'])->get();
        $successMessage = $request->session()->get('message.success');

        return view('series.index')->with('series', $series)->with('successMessage', $successMessage);
    }

    public function create(Request $request)
    {
        $errorMessage = $request->session()->get('message.error');
        return view('series.create')->with('errorMessage', $errorMessage);
    }

    public function store(SeriesFormRequest $request)
    {
        $mimeTypePermited = "image/gif;image/jpeg;image/png";
        if ($request->hasFile('cover') && !str_contains($mimeTypePermited, $request->file('cover')->getMimeType())) {
            return back()
                ->with('message.error', "Error! File type forbidden...");
        }
        $request->coverPath = $request->file('cover')?->store('series_path', 'public');

        $series = $this->repository->add($request);
        if ($series->id == null) {
            return back()
                ->with('message.error', "Error! Series duplicated: {$request->name}");
        }
        \App\Events\SeriesCreated::dispatch(
            $series->name,
            $series->id,
            $request->seasonsQty,
            $request->episodesPerSeason,
        );

        return to_route('series.index')
            ->with('message.success', "Successful added series {$series->name}!");
    }

    public function destroy(Series $series)
    {
        $series->delete();

        return to_route('series.index')
            ->with('message.success', "Successful removed series {$series->name}!");
    }

    public function edit(Series $series)
    {
        return view('series.edit')->with('series', $series);
    }

    public function update(Series $series, SeriesFormRequest $request)
    {
        $series = $this->repository->update($series, $request);

        return to_route('series.index')
            ->with('message.success', "Successful updated series {$series->name}!");
    }
}
