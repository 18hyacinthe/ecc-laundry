<div class="container" id="container">
    <div class="form-container sign-up-container">
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <h1>Create Account</h1>
            <input type="text" name="name" placeholder="Name" value="{{ old('name') }}" />
            <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="Email" />
            <input id="password" type="password" name="password" placeholder="Password" />
            <input id="password_confirmation" type="password" name="password_confirmation" placeholder="Confirm Password" />
            <button type="submit">Sign Up</button>
        </form>
    </div>
    
    <div class="form-container sign-in-container">
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <h1>Sign in</h1>
            <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="Email" />
			<input id="password" type="password" name="password" value="{{ old('password') }}" placeholder="Password" />
			<button type="submit">Sign In</button>
        </form>
    </div>
    <div class="overlay-container">
        <div class="overlay">
            <div class="overlay-panel overlay-left">
                <h1>Welcome Back!</h1>
                <br>
                <div class="loader"></div>
                <br>
                <p>To keep connected with us please login with your personal info</p>
                <button class="ghost" id="signIn">Sign In</button>
            </div>
            <div class="overlay-panel overlay-right">
                <h1>Hello, Friend!</h1>
                <br>
                <div class="loader"></div>
                <br>
                <p>Enter your personal details and start journey with us</p>
                <button class="ghost" id="signUp">Sign Up</button>
            </div>
        </div>
    </div>
</div>