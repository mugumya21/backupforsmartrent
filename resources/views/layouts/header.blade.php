<nav class="navbar navbar-light navbar-glass navbar-top navbar-expand">

            <button class="btn navbar-toggler-humburger-icon navbar-toggler me-1 me-sm-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarVerticalCollapse" aria-controls="navbarVerticalCollapse" aria-expanded="false" aria-label="Toggle Navigation"><span class="navbar-toggle-icon"><span class="toggle-line"></span></span></button>
            <a class="navbar-brand me-1 me-sm-3" href="{{ route('home') }}">
              <div class="d-flex align-items-center"><img class="me-2" id="darklogo" src="{{ asset('assets/img/logo.png')}}" alt="" width="40" /><img class="me-2" id="whitelogo" src="{{ asset('assets/img/logo-white.png')}}" alt="" width="40" />

              </div>
            </a>
          
            <ul class="navbar-nav navbar-nav-icons ms-auto flex-row align-items-center">
              <li class="nav-item">
                <div class="theme-control-toggle fa-icon-wait px-2">

                  
<button id="changethemebtn" style="background: none;font-size: 15px;border: none;"><span class="fas fa-moon" id="moonicon" style="color:#6a6d70"></span> <span class="fas fa-sun" id="sunicon" style="color:#b6b9be"></span>  </button>


                </div>
              </li>
            
              <li class="nav-item dropdown">
                <a class="nav-link notification-indicator notification-indicator-primary px-0 fa-icon-wait" id="navbarDropdownNotification" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="fas fa-bell" data-fa-transform="shrink-6" style="font-size: 33px;"></span></a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-card dropdown-menu-notification" aria-labelledby="navbarDropdownNotification">
                  <div class="card card-notification shadow-none">
                    <div class="card-header">
                      <div class="row justify-content-between align-items-center">
                        <div class="col-auto">
                          <h6 class="card-header-title mb-0">Notifications</h6>
                        </div>
                        
                      </div>
                    </div>
                    <div class="scrollbar-overlay" style="max-height:19rem">
                      <div class="list-group list-group-flush fw-normal fs--1">
                       
                       
                     
                        
                        
                      
                      </div>
                    </div>
                    <div class="card-footer text-center border-top"><a class="card-link d-block" href="app/social/notifications.html">View all</a></div>
                  </div>
                </div>

              </li>
              <li class="nav-item dropdown"><a class="nav-link pe-0" id="navbarDropdownUser" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <div class="avatar avatar-xl">

                    
                    @php
                    $employee =  Auth::user()->employee;
                @endphp
                @if (!empty($employee->avatar))

<img src="{{ asset("uploads/employeeavatars/{$employee->avatar->name}") }}" alt="Avatar" class="rounded-circle"/>
@else
<img src="{{ asset('uploads/employeeavatars/default.png') }}" class="rounded-circle" alt="Avatar"/>
@endif

                </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end py-0" aria-labelledby="navbarDropdownUser">
                  <div class="bg-white dark__bg-1000 rounded-2 py-2">
<a class="dropdown-item fw-bold text-warning" href="#!"><span class="fas fa-cog"></span> <span>My Account</span></a>

                    <div class="dropdown-divider"></div>
                   
                    <a class="dropdown-item" href="pages/user/profile.html">Profile</a>
                 
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="pages/user/settings.html">Settings</a>

                    <a class="dropdown-item" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                                  document.getElementById('logout-form').submit();">
                     {{ __('Logout') }}
                 </a>

                 <form id="logout-form" action="{{ route('logout') }}" method="POST" class="dropdown-item d-none">
                     @csrf
                 </form>

                  </div>
                </div>
              </li>
            </ul>
          </nav>