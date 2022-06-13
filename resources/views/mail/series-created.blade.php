@component('mail::message')
# {{ $seriesName }} was created!

This series have {{ $seasonsQty }} season{{ $seasonsQty > 1 ? 's' : '' }} with {{ $episodesPerSeason }} episode{{ $episodesPerSeason > 1 ? 's' : '' }} per season.

@component('mail::button', ['url' => route('seasons.index', $seriesId)])
    Click here to see
@endcomponent

@endcomponent
