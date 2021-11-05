<x-navbar></x-navbar>
<h1 class="text-center">Register</h1>
<div class="d-flex justify-content-center">
    <div class="row">
        <div class="col-5 text-center">
            <form method="POST" action="{{route('register')}}">
                @csrf
                <div class="mb-3">
                    <label for="inputName" class="form-label">First Name</label>
                    <input type="text" class="form-control" id="inputName" name="firstname">
                </div>
                <div class="mb-3">
                    <label for="inputLastName" class="form-label">Last Name</label>
                    <input type="text" class="form-control" id="inputLastName" name="lastname">
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                           name="email">
                    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                           id="exampleInputPassword1" name="password">
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password-confirm" class="form-label">{{ __('Confirm Password') }}</label>

                    <div>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                               required autocomplete="new-password">
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary">Register</button>
                </div>
            </form>
        </div>
        <div class="col-2 text-center align-self-center">
            <strong>OR</strong>
        </div>
        <div class="col-5 align-self-center">
            <div class="text-center">
                <h3>Please Authenticate with Discogs</h3>
                <form action="{{route('api.discogs.authenticate')}}" method="post">
                    <div class="form-group justify-content-mg-center">
                        @isset($discogsMessage)
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $discogsMessage }}</strong>
                            </span>
                        @endisset
                    </div>
                    <button type="submit" class="btn btn-primary">Authenticate</button>
                </form>
            </div>
        </div>
    </div>
</div>
