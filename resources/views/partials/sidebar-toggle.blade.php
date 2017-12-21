<a href="#" onclick="toggleNav()" class="pt-2 btn btn-link">
  @svg('menu', 's3')
</a>

@section('scripts')
  <script>
    var toggled = true;
    function toggleNav() {
      if (toggled) {
        document.getElementById("sideNav").style.width = "200px";
        document.getElementById("admin-main").style.left = "200px";
      } else {
        document.getElementById("sideNav").style.width = "0px";
        document.getElementById("admin-main").style.left = "0px";
        document.getElementById("admin-main").style.width = "100%";
      }
      toggled = !toggled;
    }
  </script>
@endsection
