<template>
    <div class="card-header">
        <h4 class="card-title">Horizontal Form with Icons</h4>
    </div>
    <div class="card-content">
        <div class="card-body">
            <form :action="loginUrl" class="form form-horizontal" method="POST">
                <input type="hidden" name="_token" :value="csrfToken" />
                <input type="hidden" name="from" value="member" />
                <div class="form-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="first-name-horizontal-icon">Email</label>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group has-icon-left">
                                <div class="position-relative">
                                    <input type="text" class="form-control" placeholder="Email" id="email" name="email" />
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
                                    <input type="password" class="form-control" placeholder="Password" id="password" name="password" />
                                    <div class="form-control-icon">
                                        <i class="bi bi-lock"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-8 offset-md-4">
                            <div class="form-check">
                                <div class="checkbox">
                                    <input type="checkbox" id="checkbox2" class="form-check-input" />
                                    <label for="checkbox2">Remember Me</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                            <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            isAuthenticated: false,
            loginUrl: '',
            csrfToken: '',
        }
    },
    mounted() {
        const appElement = document.getElementById('usr-page-container')
        this.loginUrl = appElement.dataset.loginUrl
        this.csrfToken = document.head.querySelector('meta[name="csrf-token"]').content

        this.isAuthenticated = !!localStorage.getItem('auth_token')
    },
}
</script>
