{extends file='Templates/template.tpl'}

{block name="title"}{$app_title} - Registration{/block}

{block name="content"}
    <div class="container">
        <div class="row justify-content-center">
            <aside class="col-md-8 col-lg-6 col-xl-5 py-3 py-md-5">

                {include file="Templates/feedback.tpl"}

                <div class="card register-form">
                    <h5 class="p-3 text-center border-bottom m-0">Create account</h5>

                    <article class="card-body">
                        <form method="post" autocomplete="on">
                            <input type="hidden" name="csrf_token" value="{\Libraries\Core\Csrf::generateToken()}">

                            <div class="form-group">
                                <label for="username">Username</label>
                                <input id="username" name="username"
                                       class="form-control {if !empty($username_err)}is-invalid{/if}" type="text"
                                       value="{$username}" autofocus>
                                <div class="invalid-feedback">{$username_err}</div>
                            </div><!-- /.form-group -->

                            <div class="form-group">
                                <label for="email">Email address</label>
                                <input id="email" name="email"
                                       class="form-control {if !empty($email_err)}is-invalid{/if}" type="email"
                                       value="{$email}">

                                <div class="invalid-feedback">{$email_err}</div>
                            </div><!-- /.form-group -->

                            <div class="pb-2">
                                <small id="password-help" class="form-text text-muted">Your password must be 8-20
                                    characters long, contain letters and numbers, and must not contain spaces and
                                    special characters.
                                </small>
                            </div>

                            <div class="form-group">
                                <label for="password">Password</label>
                                <input id="password" name="password"
                                       class="form-control {if !empty($password_err)}is-invalid{/if}" type="password">
                                <div class="invalid-feedback">{$password_err}</div>
                            </div><!-- /.form-group -->

                            <div class="form-group">
                                <label for="password_confirm">Confirm password</label>
                                <input id="password_confirm" name="password_confirm"
                                       class="form-control {if !empty($password_err)}is-invalid{/if}" type="password">
                                <div class="invalid-feedback">{$password_err}</div>
                            </div><!-- /.form-group -->

                            <div class="form-group">
                                <div class="form-check mb-4">
                                    <input class="form-check-input" type="checkbox" value="checked" id="terms_agree"
                                           name="terms_agree" {$terms_agree}>
                                    <label class="form-check-label small" for="terms-agree">
                                        Agree to <a href="#">terms and conditions</a>
                                    </label>
                                </div>
                            </div><!-- /.form-group -->

                            <div class="form-group">
                                <button type="submit" class="btn btn-info btn-block" name="form_register"
                                        value="form_register">Register
                                </button>
                            </div><!-- /.form-group -->
                        </form>
                    </article>
                </div><!-- /.card -->
                <p class="text-center mt-2 mb-0">
                    <a href="{\Libraries\Http\Request::getSiteUrl()}/user/login" class="text-info small">Sign In <i
                                class="fa fa-arrow-right"></i></a>
                </p>
            </aside>
        </div><!-- /.row -->
    </div><!-- /.container -->
{/block}