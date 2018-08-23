{extends file='Templates/template.tpl'}

{block name="title"}Internal Server Error{/block}

{block name="content"}
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8 py-3 py-md-5 text-center">
                <h1 class="display-2 mt-3">500</h1>
                <h4>Internal Server Error</h4>
                <p class="text-muted pt-2">
                    The server encountered an internal error and was unable to complete your request.<br/>
                    Please contact the server administrator: <a href='mailto:{$serverAdmin}'>{$serverAdmin}</a>.
                </p>
            </div>
        </div>
    </div>
{/block}