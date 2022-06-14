<?php

namespace App\Http\Controllers;

use App\Http\Middleware\Authenticator;
use App\Http\Requests\SeriesFormRequest;
use App\Mail\SeriesCreated;
use App\Models\Series;
use App\Models\User;
use App\Repositories\SeriesRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SeriesController extends Controller
{
    public function __construct(private SeriesRepository $repository)
    {
        $this->middleware(Authenticator::class)->except('index');
    }

    public function index(Request $request)
    {
        $series = Series::all(); // with(['seasons'])->get();
        $successMessage = $request->session()->get('message.success');

        return view('series.index')->with('series', $series)->with('successMessage', $successMessage);
    }

    public function create()
    {
        return view('series.create');
    }

    public function store(SeriesFormRequest $request)
    {
        $series = $this->repository->add($request);

        foreach (User::all() as $index => $user) {
            $email = new SeriesCreated(
                $series->name,
                $series->id,
                $request->seasonsQty,
                $request->episodesPerSeason,
            );
            $when = now()->addSecond($index * 5);
            Mail::to($user)->later($when, $email);
        }

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
