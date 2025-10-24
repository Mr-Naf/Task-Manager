<section class="container my-4">
    <header class="mb-3">
        <h2 class="h5">
            {{ __('Profile Information') }}
        </h2>

        <p class="text-muted mb-0">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-4">
        @csrf
        @method('patch')

        <div class="mb-3">
            <label for="name" class="form-label">{{ __('Name') }}</label>
            <input id="name" name="name" type="text" class="form-control"
                value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
            @error('name')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">{{ __('Email') }}</label>
            <input id="email" name="email" type="email" class="form-control"
                value="{{ old('email', $user->email) }}" required autocomplete="username">
            @error('email')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div class="mt-2">
                    <p class="mb-1 text-muted">
                        {{ __('Your email address is unverified.') }}
                    </p>

                    <button form="send-verification" class="btn btn-link p-0 align-baseline">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>

                    @if (session('status') === 'verification-link-sent')
                        <div class="alert alert-success mt-2 py-1">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </div>
                    @endif
                </div>
            @endif
        </div>

        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>

            @if (session('status') === 'profile-updated')
                <span id="profile-saved" class="text-success">{{ __('Saved.') }}</span>
            @endif
        </div>
    </form>

    @if (session('status') === 'profile-updated')
        <script>
            // hide the saved message after 2 seconds
            (function() {
                const el = document.getElementById('profile-saved');
                if (!el) return;
                setTimeout(() => {
                    el.style.display = 'none';
                }, 2000);
            })();
        </script>
    @endif
</section>
