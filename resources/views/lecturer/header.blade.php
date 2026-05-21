<header class="header bg-white">
    <nav class="navbar navbar-expand-lg bg-white">
      <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-between w-100">
          <!-- Toggle Button -->
          <div class="d-flex align-items-center">
            <button class="sidebar-toggle"><i class="fa fa-long-arrow-left"></i></button>
          </div>

          <!-- Center Title -->
          <div class="text-center">
            <a href="{{url('home')}}" class="navbar-brand">
              <div class="brand-text brand-big visible text-uppercase">
                <strong class="text-dark">Supervisor</strong> Hunting System
              </div>
              <div class="brand-text brand-sm">
                <strong class="text-dark">S</strong><strong>HS</strong>
              </div>
            </a>
          </div>

          <!-- Logout Button -->
          <div class="d-flex align-items-center">
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button class="btn btn-danger" type="submit">Logout</button>
            </form>
          </div>
        </div>
      </div>
    </nav>
  </header>
