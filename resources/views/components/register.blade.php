<div class="grid grid-cols-3 justify-center content-center raspi:mt-24">
    <div class="flex items-center justify-center">
        <div class="px-8 py-6 raspi:py-0 raspi:mt-1 mx-4 mt-4 text-left bg-white">
            <h3 class="text-2xl raspi:text-md font-bold text-center">Register</h3>
            <form action="{{route('register')}}">
                <div class="raspi:mt-1 mt-4">
                    <div>
                        <label class="block" for="Name">Name<label>
                                <input type="text" placeholder="Name"
                                       class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600">
                    </div>
                    <div class="raspi:mt-1 mt-4">
                        <label class="block" for="email">Email<label>
                                <input type="text" placeholder="Email"
                                       class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600">
                    </div>
                    <div class="flex">
                        <button class="w-full px-6 py-2 mt-4 text-white bg-blue-600 rounded-lg hover:bg-blue-900">Create
                            Account
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="mx-auto my-auto">
        <h1 class="text-2xl"><strong>OR</strong></h1>
    </div>
    <div class="flex items-center justify-center">
        <div class="px-8 py-6 mx-4 mt-4 text-center bg-white">
            <h3 class="text-2xl font-bold text-center">Authenicate With Discogs</h3>
            <br>
            <form action="{{route('api.discogs.authenticate')}}" method="post">
                <div class="">
                    @isset($discogsMessage)
                        <span class="text-xs text-red-400">
                                <strong>{{ $discogsMessage }}</strong>
                            </span>
                    @endisset
                </div>
                <button type="submit" class="w-full px-6 py-2 mt-4 text-white bg-blue-600 rounded-lg hover:bg-blue-900">
                    Authenticate
                </button>
            </form>
        </div>
    </div>
</div>
