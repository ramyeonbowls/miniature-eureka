<template>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-12">
                <div class="row">
                    <div class="col-4 col-lg-4">
                        <div class="card-header mb-5">
                            <h4 class="card-title">Login</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <form :action="loginUrl" class="form form-horizontal" method="POST">
                                    <input type="hidden" name="_token" :value="csrfToken">
                                    <input type="hidden" name="from" value="member">
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="first-name-horizontal-icon">Email</label>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="form-group has-icon-left">
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control" placeholder="Email"
                                                            id="email" name="email">
                                                        <div class="form-control-icon">
                                                            <i class="bi bi-person"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="password-horizontal-icon">Password</label>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="form-group has-icon-left">
                                                    <div class="position-relative">
                                                        <input type="password" class="form-control" placeholder="Password" id="password" name="password">
                                                        <div class="form-control-icon">
                                                            <i class="bi bi-lock"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 d-flex justify-content-end">
                                                <button type="submit" class="btn btn-primary me-1 mb-1 btn-block">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                Belum punya akun?
                                <router-link to="/register" class='menu-link'>
                                    <span> Daftar Disini</span>
                                </router-link>
                            </div>
                        </div>
                    </div>
                    <div class="col-8 col-lg-8">
                        
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<style>
    .content-wrapper {
        margin-top: 150px;
    }
</style>

<script>
export default {
  data() {
    return {
        isAuthenticated: false,
        loginUrl: '',
        csrfToken: '',
    };
  },
  mounted() {
    const appElement = document.getElementById('usr-page-container');
    this.loginUrl = appElement.dataset.loginUrl;
    this.csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;

    this.isAuthenticated = !!localStorage.getItem('auth_token');
  },
};
</script>