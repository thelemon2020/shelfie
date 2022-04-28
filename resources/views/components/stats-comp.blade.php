<script src="https://unpkg.com/echarts/dist/echarts.min.js"></script>
<!-- Chartisan -->
<script src="https://unpkg.com/@chartisan/echarts/dist/chartisan_echarts.js"></script>
<div id="statsCarousel" class="slideshow-container min-w-screen text-center flex items-center justify-center">
    <div id="mostPlayedStat" class="mySlides fade">
        <h3>Most Played Records</h3>
        <table>
            <thead>
            <th style="width: 15vh"></th>
            <th class="w-4/12">Artist</th>
            <th>Title</th>
            <th>Times Played</th>
            </thead>
            <tbody>
            @foreach($mostPlayed as $release)
                <tr>
                    <td><img class="img-fluid" src="{{$release->full_image ?? ''}}"></td>
                    <td>{{$release->artist ?? ''}}</td>
                    <td>{{$release->title ?? ''}}</td>
                    <td>{{$release->times_played ?? ''}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="mySlides fade" id="lastPlayedStat">
        <h3>Last Played</h3>
        @if(!$lastPlayed)
            <h4>Nothing! Go Spin A Record!</h4>
        @else
            <img id="lastPlayed" class="rounded mx-auto raspi:w-60" src="{{$lastPlayed->full_image  ?? ''}}">
            <h4>{{$lastPlayed->artist ?? ''}} - {{$lastPlayed->title ?? ''}}</h4>
            <h4>Last Played
                At: {{\Carbon\Carbon::parse($lastPlayed->last_played_at)->setTimezone('America/Toronto')->format('g:i a d/m/y') ?? ''}}</h4>
        @endif
    </div>

    <div id="chart-days" class="mySlides fade w-full h-72"></div>


    <div id="chart-genre" class="mySlides fade w-full h-72"></div>


    <div id="chart-artists" class="mySlides fade w-full h-[72vh] raspi:h-[100vh]"></div>

</div>
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
            .colors(
                "blue",
            )
            .options({
                xAxis: {
                    type: "category",
                    axisLabel: {
                        interval: 0,
                        rotate: 30 //If the label names are too long you can manage this by rotating the label.
                    }
                },
                grid: {
                    containLabel: true
                }
            })
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

    let slideIndex = 0;
    showSlides();

    function showSlides() {
        let i;
        let slides = document.getElementsByClassName("mySlides");
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        slideIndex++;
        if (slideIndex > slides.length) {
            slideIndex = 1
        }
        slides[slideIndex - 1].style.display = "block";
        setTimeout(showSlides, 10000); // Change image every 2 seconds
    }
</script>
