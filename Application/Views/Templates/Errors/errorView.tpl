{extends file='Templates/template.tpl'}

{block name="title"}{$title}{/block}

{block name="content"}
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8 py-3 py-md-5 text-center">
                <h1 class="display-2 mt-3">{$errorCode}</h1>
                <h4>{$title}</h4>
                <p class="text-muted pt-2">{$message}
                   <br>Please contact the server administrator: <a href='mailto:{$serverAdmin}'>{$serverAdmin}</a>.</p>
            </div>
        </div>
    </div>
{/block}