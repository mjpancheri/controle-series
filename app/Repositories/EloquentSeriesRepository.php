<?php

namespace App\Repositories;

use App\Http\Requests\SeriesFormRequest;
use App\Models\Episode;
use App\Models\Season;
use App\Models\Series;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\MockObject\DuplicateMethodException;

class EloquentSeriesRepository implements SeriesRepository
{

    public function add(SeriesFormRequest $request): Series
    {
        try {
            return DB::transaction(function () use ($request) {
                $series = Series::create([
                    'name' => $request->name,
                    'cover' => $request->coverPath,
                ]);
                $seasons = [];
                for ($i = 1; $i <= $request->seasonsQty; $i++) {
                    $seasons[] = [
                        'series_id' => $series->id,
                        'number' => $i
                    ];
                }
                Season::insert($seasons);

                $episodes = [];
                foreach ($series->seasons as $season) {
                    for ($j = 1; $j <= $request->episodesPerSeason; $j++) {
                        $episodes[] = [
                            'season_id' => $season->id,
                            'number' => $j
                        ];
                    }
                }
                Episode::insert($episodes);

                return $series;
            });
        } catch (\Exception $e) {
            return new Series();
        }
    }

    public function update(Series $series, SeriesFormRequest $request): Series
    {
        return DB::transaction(function () use ($series, $request) {
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

            return $series;
        });
    }
}
