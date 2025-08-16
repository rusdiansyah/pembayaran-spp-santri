<div>
    <div class="card card-primary">
        <div class="card-header text-center">
            <a href="/" class="h1"><b>{{ config('app.name') }}</b></a>
        </div>
        <div class="card-body">
            <p class="login-box-msg">Sign in to start your session</p>
            @if (session()->has('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                </div>
            @endif
            <form wire:submit.prevent="login">
                <div class="mb-3">
                    <div class="input-group">
                        <input type="email" wire:model="email"
                            class="form-control @error('email') is-invalid @enderror" placeholder="admin@email.com">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    @error('email')
                        <div class="form-text text-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <div class="input-group">
                        <input type="password" wire:model="password"
                            class="form-control @error('password') is-invalid @enderror" placeholder="password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    @error('password')
                        <div class="form-text text-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="row">
                    <div class="col-8">
                        <div class="icheck-primary">
                            <input type="checkbox" id="remember">
                            <label for="remember">
                                Remember Me
                            </label>
                        </div>
                    </div>
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block" wire:loading.attr="disabled">
                            <i class="fas fa-sign-in-alt"></i>
                            Sign In</button>
                    </div>
                </div>
            </form>


            <p class="mb-1">
                <a wire:navigate href="/forgot-password">Lupa Password</a>
            </p>
            <p class="mb-0">
                <a wire:navigate href="/register" class="text-center">Daftar</a>
            </p>
        </div>
    </div>
</div>
