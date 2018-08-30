{extends file='Templates/template.tpl'}

{block name="title"}Access forbidden{/block}

{block name="content"}
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8 py-3 py-md-5 text-center">
                <h4>Logged out</h4>
                <p class="text-muted pt-2">
                    You have been logged out successfully.
                    <div class="row">
                        <div class="col mt-3 text-center">
                            <a class="btn btn-outline-info" href="{\Libraries\Http\Request::getSiteUrl()}/user/login">
                                Sign In <i class="fa fa-arrow-right"></i></a>
                        </div>
                    </div>
                </p>
            </div>
        </div>
    </div>
{/block}