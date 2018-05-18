{extends file='Templates/template.tpl'}

{block name="title"}Internal Server Error{/block}

{block name="content"}

    <div class="content-box px-3 py-3 pb-md-4 mx-auto text-center">
      <h1 class="display-2">500</h1>
      <h4>Internal Server Error</h4>
      <p class="text-muted">
        The server encountered an internal error and was unable to complete your request.<br/>
        Please contact the server administrator: <a href='mailto:{$serverAdmin}'>{$serverAdmin}</a>.
      </p>
    </div>

{/block}
