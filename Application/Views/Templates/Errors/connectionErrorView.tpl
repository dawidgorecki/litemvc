{extends file='Templates/template.tpl'}

{block name="title"}Database connection error{/block}

{block name="content"}
    
    <div class="content-box px-3 py-3 pb-md-4 mx-auto text-center">
      <h1 class="display-2">{$errorCode}</h1>
      <h4>Database connection error</h4>
      <p class="text-muted">
        Sorry, database connection can not be estabilished.<br/>
        Please contact the server administrator: <a href='mailto:{$serverAdmin}'>{$serverAdmin}</a>.
      </p>
    </div>

{/block}
