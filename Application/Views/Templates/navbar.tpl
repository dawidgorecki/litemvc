<nav class="navbar navbar-expand-md navbar-light bg-white mb-3 border-bottom">
    <div class="container">
        <a class="navbar-brand" href="{\Libraries\Http\Request::getSiteUrl()}">{$app_title}</a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsDefault"
                aria-controls="navbarsDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsDefault">

            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link {if \Libraries\Core\View::checkForActive('Page@view')}active{/if}"
                       href="{\Libraries\Http\Request::getSiteUrl()}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {if \Libraries\Core\View::checkForActive('Page@pricing')}active{/if}"
                       href="{\Libraries\Http\Request::getSiteUrl()}/pages/pricing">Pricing</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {if \Libraries\Core\View::checkForActive('Page@checkout')}active{/if}"
                       href="{\Libraries\Http\Request::getSiteUrl()}/pages/checkout">Checkout</a>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdown-account" data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">My account
                        {if \Libraries\Http\Session::userIsLoggedIn()}
                            ({\Libraries\Http\Session::get('user_data')->getUsername()})
                        {/if}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdown-account">
                        {if \Libraries\Http\Session::userIsLoggedIn()}
                            <a class="dropdown-item"
                               href="{\Libraries\Http\Request::getSiteUrl()}/user/logout">Logout</a>
                        {else}
                            <a class="dropdown-item {if \Libraries\Core\View::checkForActive('Login@actionLogin')}active{/if}"
                               href="{\Libraries\Http\Request::getSiteUrl()}/user/login">Login</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item {if \Libraries\Core\View::checkForActive('Register@actionRegister')}active{/if}"
                               href="{\Libraries\Http\Request::getSiteUrl()}/register">Register</a>
                        {/if}
                    </div>
                </li>
            </ul>

        </div><!-- /#navbarsDefault -->
    </div><!-- /.container -->
</nav><!-- /.navbar -->