<nav class="navbar navbar-expand-lg navbar-light bg-white mb-3 border-bottom">

  <div class="container">
    <a class="navbar-brand" href="{\Libraries\Http\Request::getSiteUrl()}">{$app_title}</a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsDefault" aria-controls="navbarsDefault" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsDefault">
      
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a class="nav-link {if \Libraries\Core\View::checkForActive('Page@view')}active{/if}" href="{\Libraries\Http\Request::getSiteUrl()}">Home</a>
        </li>
      </ul>
      <!-- /.navbar-nav -->
      
      <ul class="navbar-nav ml-auto">
 
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Example pages</a>
          <div class="dropdown-menu" aria-labelledby="dropdown01">
            <a class="dropdown-item {if \Libraries\Core\View::checkForActive('Page@pricing')}active{/if}" href="{\Libraries\Http\Request::getSiteUrl()}/pages/pricing">Pricing</a>
            <a class="dropdown-item {if \Libraries\Core\View::checkForActive('Page@checkout')}active{/if}" href="{\Libraries\Http\Request::getSiteUrl()}/pages/checkout">Checkout</a>
          </div>
        </li>
        
      </ul>
      <!-- /.navbar-nav --> 
    </div>
    <!-- /#navbarsDefault -->
  </div>
  <!-- /.container -->
</nav>
<!-- /.navbar -->