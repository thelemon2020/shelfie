<x-navbar></x-navbar>
<h1 class="text-center">Log In</h1>
<div class="d-flex justify-content-center">
    <form method="POST" action="/login">
        @csrf
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Email address</label>
            <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Password</label>
            <input type="password" name="password" class="form-control" id="exampleInputPassword1">
        </div>
        <div class="d-flex justify-content-center">
            <button type="submit" class="btn btn-primary">Login</button>
        </div>
    </form>
</div>
<div class="container text-center pt-2">
    <a href="/register">Sign Up For An Account Here</a>
</div>

