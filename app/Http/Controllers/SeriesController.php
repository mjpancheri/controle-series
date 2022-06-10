<?php

namespace App\Http\Controllers;

use App\Http\Requests\SeriesFormRequest;
use App\Models\Episode;
use App\Models\Season;
use App\Models\Series;
use App\Repositories\SeriesRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SeriesController extends Controller
{
    public function __construct(private SeriesRepository $repository)
    {

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
        DB::transaction(function () use ($series, $request) {
            $series->fill($request->all());
            $series->save();

            if ($series->seasons->count() > 0) {
                $oldSeasons = [];
                foreach ($series->seasons as $season) {
                    $oldSeasons[] = [
                        'id' => $season->id
                    ];
                }
                Season::destroy($oldSeasons);
            }
            $seasons = [];
            for ($i = 1; $i <= $request->seasonsQty; $i++) {
                $seasons[] = [
                    'series_id' => $series->id,
                    'number' => $i
                ];
            }
            Season::insert($seasons);

            $episodes = [];
            foreach ($series->seasons()->getEager() as $season) {
                for ($j = 1; $j <= $request->episodesPerSeason; $j++) {
                    $episodes[] = [
                        'season_id' => $season->id,
                        'number' => $j
                    ];
                }
            }
            Episode::insert($episodes);
        });

        return to_route('series.index')
            ->with('message.success', "Successful updated series {$series->name}!");
    }
}
