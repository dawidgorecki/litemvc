{if !empty($feedback_negative)}
    <div class="alert alert-danger alert-dismissible fade show animated fadeInUp" role="alert">
        <ul class="mb-0">
            {foreach $feedback_negative as $feedback}
                <li>{$feedback}</li>
            {/foreach}
        </ul>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
{/if}

{if !empty($feedback_positive)}
    <div class="alert alert-success alert-dismissible fade show animated fadeInUp" role="alert">
        <ul class="mb-0">
            {foreach $feedback_positive as $feedback}
                <li>{$feedback}</li>
            {/foreach}
        </ul>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
{/if}