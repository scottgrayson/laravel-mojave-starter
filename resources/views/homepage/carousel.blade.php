<div id="carousel" class="homepage-carousel carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#carousel" data-slide-to="0" class="active"></li>
    <li data-target="#carousel" data-slide-to="1"></li>
    <li data-target="#carousel" data-slide-to="2"></li>
    <li data-target="#carousel" data-slide-to="3"></li>
  </ol>
  <div class="carousel-inner" style="height:80vh;">
    <div class="carousel-item active" style="background-image:url('/img/circle.jpg')" alt="First slide">
    </div>
    <div class="carousel-item" style="background-image:url('/img/woodshop.jpg')" alt="Second slide">
    </div>
    <div class="carousel-item" style="background-image:url('/img/claybarn.jpg')" alt="Third slide">
    </div>
    <div class="carousel-item" style="background-image:url('/img/tinfoil.jpg')" alt="Fourth slide">
    </div>
  </div>
  <div class="site-caption carousel-caption">
    <h1>Miss Betty's Day Camp</h1>
    <h5>Chester Springs, PA</h5>
    <h5><i>Since 1949</i></h5>
    <a class="btn-lg btn btn-primary" href="{{ auth()->check() ? '/campers' : '/register' }}">
      Registration
    </a>
  </div>
</div>
