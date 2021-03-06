{extends file='Templates/template.tpl'}

{block name="title"}Access forbidden{/block}

{block name="content"}
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8 py-3 py-md-5 text-center">
                <h1 class="display-2 mt-3">403</h1>
                <h4>Access forbidden</h4>
                <p class="text-muted pt-2">
                    Sorry, but access to the page you are looking for was forbidden.<br/>
                    Click the button below to go back to the Homepage.

                    <div class="row">
                        <div class="col mt-3 text-center">
                            <a class="btn btn-outline-info" href="{\Libraries\Http\Request::getSiteUrl()}">
                                <i class="fa fa-arrow-left"></i> Go back to Home</a>
                        </div>
                    </div>
                </p>
            </div>
        </div>
    </div>
{/block}