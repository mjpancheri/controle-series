<x-layout title="New series" :errorMessage="$errorMessage">
    <x-series.form :action="route('series.store')" :name="old('name')" :seasonsQty="old('seasonsQty')" :episodesPerSeason="old('episodesPerSeason')" />
</x-layout>
