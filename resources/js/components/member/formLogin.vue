<template>
    <div class="page-heading">
            <div class="col-md-5 col-12">
            <div id="auth-left">
                <h1 class="auth-title">Log in.</h1>
                <p class="auth-subtitle mb-4">Log in with your data that you entered during registration.</p>

                <form method="POST" action="/login">
                    <input type="hidden" name="_token" :value="csrfToken">
                    <input type="hidden" name="from" value="member">
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input type="text" class="form-control form-control-md" placeholder="Email" id="email" name="email" value="" required autocomplete="email" autofocus />
                        <div class="form-control-icon">
                            <i class="bi bi-person"></i>
                        </div>
                    </div>
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input type="password" class="form-control form-control-md" placeholder="Password" id="password" name="password" required autocomplete="current-password" />
                        <div class="form-control-icon">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-block btn-md shadow-md mt-3">Log in</button>
                </form>
                <div class="text-center mt-5 text-md fs-10">
                    <p class="text-gray-600">
                        Don't have an account?
                        <a href="/register" class="font-bold">Sign up</a>
                        .
                    </p>
                    <!-- <p>
                        <a class="font-bold" href="{{ route('password.request') }}">Forgot password?</a>
                        .
                    </p> -->
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
  data() {
    return {
        isAuthenticated: false,
        csrfToken: '',
    };
  },
  mounted() {
    this.csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;
  },
};
</script>