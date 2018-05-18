{extends file='Templates/template.tpl'}

{block name="title"}{$title}{/block}

{block name="content"}
  
    <div class="content-box px-3 py-3 pb-md-4 mx-auto text-center">
      <h1 class="display-2">{$title}</h1>
      <h4>{$message}</h4>
      <p class="text-muted">
        Please contact the server administrator: <a href='mailto:{$serverAdmin}'>{$serverAdmin}</a>.
      </p>
    </div>

{/block}
