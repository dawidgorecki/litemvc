{extends file='Templates/template.tpl'}

{block name="title"}Access forbidden{/block}

{block name="content"}
    
    <div class="content-box px-3 py-3 pb-md-4 mx-auto text-center">
      <h1 class="display-2">403</h1>
      <h4>Access forbidden</h4>
      <p class="text-muted">
        Sorry, but access to the page you are looking for was forbidden.<br/>
        Click the button below to go back to the Homepage.
        
        <div class="mt-4">
          <a class="btn btn-outline-info" href="{\Libraries\Http\Request::getSiteUrl()}">
            <i class="fa fa-arrow-left"></i>
            Go back to Home                    
          </a>
        </div>
      </p>
    </div>

{/block}
