<div>
{{--    <div {{$images ? 'wire:ignore' : ''}}>--}}
        @if($images)
            <div class="flex justify-between items-center">
                <div>
                    <button onclick="previousImage()">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"/>
                        </svg>
                    </button>
                </div>
                <div class="image-content">
                    @foreach($images as $key => $image)
                        <img id="{{'albumImage-' . $key}}"
                             class="@if($key===0)active-image @else hidden @endif w-72 h-72"
                             src={{$image['image']}} alt={{$image['thumbnail']}}/>
                    @endforeach
                </div>
                <div>
                    <button onclick="nextImage()">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 5l7 7-7 7M5 5l7 7-7 7"/>
                        </svg>
                    </button>
                </div>
            </div>
        @else
            <div class="loading-spinner text-center right-0 top-1/2">
                <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <div>
                    <p>Loading Images</p>
                </div>
            </div>
        @endif
        <button class="w-full px-6 py-2 mt-4 text-white bg-blue-600 rounded-lg hover:bg-blue-900"
                wire:click="imageSelected">Select
        </button>
    </div>
    <script>
        window.addEventListener('image-selected', event => {
            const selectedImage = $('.active-image')[0]
            Livewire.emitTo('edit', 'changeImage', selectedImage.src, selectedImage.alt)
            $('#coverImage').removeClass('hidden')
        })

        function nextImage() {
            let numberOfImages = $('.image-content img').length
            let activeElement = $('.active-image')[0];
            let activeImageNum = Number(activeElement.id.split('-')[1]) + 1
            $('.active-image').addClass('hidden')
            $('.active-image').removeClass('active-image')
            if (activeImageNum >= numberOfImages) {
                activeImageNum = 0
            }
            let nextImage = $('#albumImage-' + activeImageNum)
            nextImage.addClass('active-image')
            nextImage.toggleClass('hidden')
        }

        function previousImage() {

            let activeElement = $('.active-image')[0];
            let activeImageNum = Number(activeElement.id.split('-')[1]) - 1
            $('.active-image').addClass('hidden')
            $('.active-image').removeClass('active-image')
            if (activeImageNum <= 0) {
                let numberOfImages = $('.image-content img').length
                activeImageNum = numberOfImages - 1
            }
            let previousImage = $('#albumImage-' + activeImageNum)
            previousImage.addClass('active-image')
            previousImage.toggleClass('hidden')
        }
    </script>
</div>
