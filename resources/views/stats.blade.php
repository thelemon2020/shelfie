<x-navbar></x-navbar>
<body style="overflow-x: hidden;">
<!-- Charting library -->
<script src="https://unpkg.com/echarts/dist/echarts.min.js"></script>
<!-- Chartisan -->
<script src="https://unpkg.com/@chartisan/echarts/dist/chartisan_echarts.js"></script>
<div id="statsCarousel" class="carousel slide carousel-fade" data-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item">
            <div class="text-center">
                <h3>Most Played Records</h3>
                <table class="table">
                    <thead>
                    <th class="w-50"></th>
                    <th>Artist</th>
                    <th>Title</th>
                    <th>Times Played</th>
                    </thead>
                    <tbody>
                    @foreach($mostPlayed as $release)
                        <tr>
                            <td><img style="height: 100px; width: 100px" src="{{$release->full_image ?? ''}}">
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
        <div class="carousel-item active">
            <div id="chart" style="height: 300px;"></div>
        </div>
    </div>
</div>
<!-- Your application script -->
<script>
    const chart = new Chartisan({
        el: '#chart',
        url: "@chart('play_days_chart')",
    });
</script>
</body>
