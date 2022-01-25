<script src="https://unpkg.com/echarts/dist/echarts.min.js"></script>
<!-- Chartisan -->
<script src="https://unpkg.com/@chartisan/echarts/dist/chartisan_echarts.js"></script>
<div id="statsCarousel" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item vh-100">
            <div class="text-center">
                <h3>Most Played Records</h3>
                <table class="table">
                    <thead>
                    <th style="width: 15vh"></th>
                    <th>Artist</th>
                    <th>Title</th>
                    <th>Times Played</th>
                    </thead>
                    <tbody>
                    @foreach($mostPlayed as $release)
                        <tr>
                            <td><img class="img-fluid" src="{{$release->full_image ?? ''}}">
                            </td>
                            <td>{{$release->artist ?? ''}}</td>
                            <td>{{$release->title ?? ''}}</td>
                            <td>{{$release->times_played ?? ''}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="carousel-item">
            <div class="text-center">
                <h3 class="mt-2 mb-0">Last Played</h3>
                @if(!$lastPlayed)
                    <h4>Nothing! Go Spin A Record!</h4>
                @else
                    <img id="lastPlayed" class="rounded mx-auto" src="{{$lastPlayed->full_image  ?? ''}}">
                    <h4>{{$lastPlayed->artist ?? ''}} - {{$lastPlayed->title ?? ''}}</h4>
                    <h4>Last Played
                        At: {{\Carbon\Carbon::parse($lastPlayed->last_played_at)->setTimezone('America/Toronto')->format('g:i a d/m/y') ?? ''}}</h4>
                @endif
            </div>
        </div>
        <div class="carousel-item">
            <div id="chart-days" style="height: 300px;"></div>
        </div>
        <div class="carousel-item">
            <div id="chart-genre" style="height: 300px;"></div>
        </div>
        <div class="carousel-item active">
            <div id="chart-artists" style="height: 300px;"></div>
        </div>
    </div>
</div>
<!-- Your application script -->
<script>
    const chartDays = new Chartisan({
        el: '#chart-days',
        url: "@chart('play_days_chart')",
        hooks: new ChartisanHooks()
            .title('Days When You Spin The Most')
            .colors('#116a78')
    });
    const chartArtists = new Chartisan({
        el: '#chart-artists',
        url: "@chart('artist_chart')",
        hooks: new ChartisanHooks()
            .title('Most Played Artists')
            .colors('#559977')
    });
    const chartGenre = new Chartisan({
        el: '#chart-genre',
        url: "@chart('genre_chart')",
        hooks: new ChartisanHooks()
            .axis(false)
            .tooltip()
            .legend()
            .title('Top Genres')
            .datasets([{type: 'pie'}])
    });
</script>
