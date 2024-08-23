
<aside id="sidebar-wrapper">
    <div class="sidebar-brand">
      <h2>BMM</h2>
    </div>
    <ul class="sidebar-nav">
      <li class="{{ $activePage=='dashboard' ? 'active' : '' }}">
        <a href="{{url('/')}}"><i class="fa fa-home"></i>Home</a>
      </li>
      <li class="{{ $activePage=='batch' ? 'active' : '' }}">
        <a href="{{route('batches.index')}}"><i class="fa fa-delicious"></i>Batches</a>
      </li>
      <li class="{{ $activePage=='students' ? 'active' : '' }}">
        <a href="{{route('students.index')}}"><i class="fa fa-users"></i>Students</a>
      </li>
    </ul>
  </aside>

  <div id="navbar-wrapper">
    <nav class="navbar navbar-inverse">
      <div class="container-fluid">
        <div class="navbar-header">
          <a href="#" class="navbar-brand" id="sidebar-toggle"><i class="fa fa-bars"></i></a>
        </div>
      </div>
    </nav>
  </div>
