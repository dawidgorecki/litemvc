{extends file='Templates/template.tpl'}

{block name="title"}{$app_title} - Sign In{/block}

{block name="content"}
    <div class="container">
        <div class="row justify-content-center">
            <aside class="col-md-7 col-lg-5 col-xl-4 py-3 py-md-5">

                {include file="Templates/feedback.tpl"}

                <div class="card login-form">
                    <h5 class="p-3 text-center border-bottom m-0">Sign in</h5>

                    <article class="card-body">
                        <form method="post" autocomplete="off">
                            <input type="hidden" name="csrf_token" value="{\Libraries\Core\Csrf::generateToken()}">

                            <div class="form-group">
                                <label for="username">Username or email</label>
                                <input id="username" name="username"
                                       class="form-control {if !empty($username_err)}is-invalid{/if}" type="text"
                                       value="{$username}" autofocus>
                                <div class="invalid-feedback">{$username_err}</div>
                            </div><!-- /.form-group -->

                            <div class="form-group">
                                <label for="password">Password</label>
                                <input id="password" name="user_password"
                                       class="form-control {if !empty($password_err)}is-invalid{/if}" type="password">
                                <div class="invalid-feedback">{$password_err}</div>
                                <div class="text-right mt-2">
                                    <a class="small text-muted"
                                       href="{\Libraries\Http\Request::getSiteUrl()}/user/reset-password">Forgot
                                        password?</a>
                                </div>
                            </div><!-- /.form-group -->

                            <div class="form-group">
                                <button type="submit" name="form_login" value="form_login"
                                        class="btn btn-info btn-block">Sign In
                                </button>
                            </div><!-- /.form-group -->
                        </form>
                    </article>

                </div><!-- /.card -->

                {if \Libraries\Core\Config::get('REGISTRATION') eq true}
                    <p class="text-center mt-2 mb-0">
                        <a href="{\Libraries\Http\Request::getSiteUrl()}/register" class="text-info small">Create an
                            account for free</a>
                    </p>
                {/if}
            </aside>
        </div><!-- /.row -->
    </div><!-- /.container -->
{/block}