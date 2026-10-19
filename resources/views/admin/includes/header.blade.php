  <nav class="app-header navbar navbar-expand bg-body">
      <!--begin::Container-->
      <div class="container-fluid">
          <!--begin::Start Navbar Links-->
          <ul class="navbar-nav">
              <li class="nav-item">
                  <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button" aria-label="Toggle sidebar">
                      <i class="bi bi-list"></i>
                  </a>
              </li>
              <li class="nav-item d-none d-md-block">
                  <a href="{{ route('index') }}" target="_blank" class="nav-link text-success fw-bold">
                      <i class="bi bi-globe me-1"></i> Visit Main Site
                  </a>
              </li>
          </ul>
          <!--end::Start Navbar Links-->

          <!--begin::End Navbar Links-->
          <ul class="navbar-nav ms-auto">

              <!--begin::Fullscreen Toggle-->
              <li class="nav-item">
                  <a class="nav-link" href="#" data-lte-toggle="fullscreen" aria-label="Toggle fullscreen">
                      <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
                      <i data-lte-icon="minimize" class="bi bi-fullscreen-exit d-none"></i>
                  </a>
              </li>
              <!--end::Fullscreen Toggle-->

              <!--begin::Color Mode Toggle-->
              <li class="nav-item dropdown">
                  <a class="nav-link" href="#" id="bd-theme" aria-label="Toggle color scheme"
                      data-bs-toggle="dropdown" aria-expanded="false">
                      <i class="bi bi-sun-fill" data-lte-theme-icon="light"></i>
                      <i class="bi bi-moon-fill d-none" data-lte-theme-icon="dark"></i>
                      <i class="bi bi-circle-half d-none" data-lte-theme-icon="auto"></i>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="bd-theme"
                      style="--bs-dropdown-min-width: 8rem">
                      <li>
                          <button type="button" class="dropdown-item d-flex align-items-center"
                              data-bs-theme-value="light" aria-pressed="false">
                              <i class="bi bi-sun-fill me-2"></i>
                              Light
                          </button>
                      </li>
                      <li>
                          <button type="button" class="dropdown-item d-flex align-items-center"
                              data-bs-theme-value="dark" aria-pressed="false">
                              <i class="bi bi-moon-fill me-2"></i>
                              Dark
                          </button>
                      </li>
                      <li>
                          <button type="button" class="dropdown-item d-flex align-items-center active"
                              data-bs-theme-value="auto" aria-pressed="true">
                              <i class="bi bi-circle-half me-2"></i>
                              Auto
                          </button>
                      </li>
                  </ul>
              </li>
              <!--end::Color Mode Toggle-->

              <!--begin::User Menu Dropdown-->
              @php
                  $authUser = auth()->user();
                  $dsProfile = \App\Helpers\DataStore::getCollection('admin_profile');
                  $dsData = !empty($dsProfile) ? (array)end($dsProfile) : [];
                  $sessionData = session('admin_profile_data', []);
                  
                  $rawPhoto = ($authUser && !empty($authUser->photo)) 
                      ? $authUser->photo 
                      : ($sessionData['photo'] ?? ($dsData['photo'] ?? null));
                  
                  $hdrUserPhoto = (!empty($rawPhoto) && file_exists(public_path($rawPhoto))) 
                      ? asset($rawPhoto) 
                      : asset('home/images/dewasharif/dewalogos.png');
                  
                  $firstName = ($authUser && !empty($authUser->first_name)) ? $authUser->first_name : ($sessionData['first_name'] ?? ($dsData['first_name'] ?? 'Super'));
                  $lastName = ($authUser && !empty($authUser->last_name)) ? $authUser->last_name : ($sessionData['last_name'] ?? ($dsData['last_name'] ?? 'Admin'));
                  $userName = trim($firstName . ' ' . $lastName);
              @endphp
              <li class="nav-item dropdown user-menu">
                  <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                      <img src="{{ $hdrUserPhoto }}" class="user-image rounded-circle shadow"
                          alt="{{ $userName }}" style="object-fit: cover; width: 32px; height: 32px;" />
                      <span class="d-none d-md-inline fw-bold ms-1">{{ $userName }}</span>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                      <!--begin::User Image-->
                      <li class="user-header text-bg-success d-flex flex-column align-items-center justify-content-center py-3">
                          <img src="{{ $hdrUserPhoto }}" class="rounded-circle shadow"
                              alt="{{ $userName }}" style="width: 75px; height: 75px; object-fit: cover;" />
                          <p class="mt-2 mb-0 fw-bold">
                              {{ $userName }}
                              <small class="d-block text-white-50">DewaSharif Platform Administrator</small>
                          </p>
                      </li>
                      <!--end::User Image-->

                      <!--begin::Menu Footer-->
                      <li class="user-footer p-2">
                          <a href="{{ route('admin.profile.index') }}" class="btn btn-sm btn-outline-secondary">Profile</a>
                          <form action="{{ route('logout') }}" method="POST" class="d-inline">
                              @csrf
                              <button type="submit" class="btn btn-sm btn-outline-danger float-end">
                                  Log Out
                              </button>
                          </form>
                      </li>
                      <!--end::Menu Footer-->
                  </ul>
              </li>
              <!--end::User Menu Dropdown-->
          </ul>
          <!--end::End Navbar Links-->
      </div>
      <!--end::Container-->
  </nav>
