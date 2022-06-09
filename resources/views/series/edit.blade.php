<x-layout title="Edit series {{ $series->name }}">
    <x-series.form :action="route('series.update', $series->id)" :name="$series->name" :seasonsQty="$series->seasons->count()" :episodesPerSeason="$series->seasons->count() > 0 ? $series->seasons[0]->episodes->count() : 0" :update="true" />
</x-layout>
