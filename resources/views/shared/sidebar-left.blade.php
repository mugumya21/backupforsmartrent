<nav class="navbar navbar-light navbar-vertical navbar-expand-xl">
    <script>
      var navbarStyle = localStorage.getItem("navbarStyle");
      if (navbarStyle && navbarStyle !== 'transparent') {
        document.querySelector('.navbar-vertical').classList.add(`navbar-${navbarStyle}`);
      }
    </script>

    <div class="collapse navbar-collapse" id="navbarVerticalCollapse">
      <div class="navbar-vertical-content scrollbar">
        <ul class="navbar-nav flex-column mb-3" id="navbarVerticalNav">

         @if(Auth::user()->hasAnyDirectPermission(['sysadmin']))

          <li class="nav-item">
            <!-- parent pages--><a class="nav-link dropdown-indicator" href="#dashboard" role="button" data-bs-toggle="collapse" aria-expanded="false" aria-controls="dashboard">
              <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-chart-pie"></span></span><span class="nav-link-text ps-1">Admin</span>
              </div>
            </a>
            <ul class="nav collapse" id="dashboard">
              <li class="nav-item"><a class="nav-link" href="{{route('admin.users.index')}}" aria-expanded="false">
                  <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Users</span>
                  </div>
                </a>
                <!-- more inner pages-->
              </li>


              <li class="nav-item">
                <a class="nav-link" href="{{route('admin.roles.index')}}" aria-expanded="false">
                  <div class="d-flex align-items-center"><span class="nav-link-text ps-1"> Roles </span>
                  </div>
              </a>
            </li>

            <li class="nav-item">

              
              <a class="nav-link" href="{{route('admin.permissions.index')}}" aria-expanded="false">
                <div class="d-flex align-items-center"><span class="nav-link-text ps-1"> Permissions
      </span>         </div>

            </a>
          </li>

            </ul>
          </li>

          @endif


            <a class="nav-link dropdown-indicator" href="#accounts" role="button" data-bs-toggle="collapse" aria-expanded="false" aria-controls="events">
              <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-calculator"></span></span><span class="nav-link-text ps-1">Account</span>
              </div>
            </a>
            <ul class="nav collapse false" id="accounts">
              <li class="nav-item"><a class="nav-link" href="{{route('accounts.rates.index')}}" aria-expanded="false">
                  <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Currency Rates</span>
                  </div>
                </a>
                <!-- more inner pages-->
              </li>

                   <li class="nav-item"><a class="nav-link" href="{{route('accounts.invoices.index')}}" aria-expanded="false">
                  <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Invoices</span>
                  </div>
                </a>
                <!-- more inner pages-->
              </li>

              <li class="nav-item"><a class="nav-link" href="{{route('accounts.invoices.invoicepayments')}}" aria-expanded="false">
                <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Payments</span>
                </div>
              </a>
              <!-- more inner pages-->
            </li>

            
            
            
            </ul>


          <li class="nav-item">
      
    
            <a class="nav-link dropdown-indicator" href="#email" role="button" data-bs-toggle="collapse" aria-expanded="false" aria-controls="email">
              <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-briefcase"></span></span><span class="nav-link-text ps-1">CRM</span>
              </div>
            </a>
            <ul class="nav collapse false" id="email">
              <li class="nav-item"><a class="nav-link" href="{{route('crm.clients.index')}}" aria-expanded="false">
                  <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Clients</span>
                  </div>
                </a>
                <!-- more inner pages-->
              </li>
              
              
            </ul>
            <!-- parent pages--><a class="nav-link dropdown-indicator" href="#properties" role="button" data-bs-toggle="collapse" aria-expanded="false" aria-controls="events">
              <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="far fa-building"></span></span><span class="nav-link-text ps-1">Properties</span>
              </div>
            </a>
            <ul class="nav collapse false" id="properties">
              <li class="nav-item"><a class="nav-link" href="{{route('rent.properties.index')}}" aria-expanded="false">
                  <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Properties</span>
                  </div>
                </a>
                <!-- more inner pages-->
              </li>
            
              
            </ul>
          
          

 <!-- parent pages--><a class="nav-link" href="{{route('admin.settings.index')}}" role="button" aria-expanded="false">
  <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-wrench"></span></span><span class="nav-link-text ps-1">Settings</span>
  </div>
</a>



<a class="nav-link dropdown-indicator" href="#reports" role="button" data-bs-toggle="collapse" aria-expanded="false" aria-controls="events">
  <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-chart-line"></span></span><span class="nav-link-text ps-1">Reports</span>
  </div>
</a>
<ul class="nav collapse false" id="reports">
  <li class="nav-item"><a class="nav-link" href="{{route('reports.unpaidrent')}}" aria-expanded="false">
      <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Unpaid Rent Report</span>
      </div>
    </a>
    <!-- more inner pages-->
  </li>


  <li class="nav-item"><a class="nav-link" href="{{route('reports.payments')}}" aria-expanded="false">
    <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Payments Report</span>
    </div>
  </a>
  <!-- more inner pages-->
</li>


<li class="nav-item"><a class="nav-link" href="{{route('reports.collections')}}" aria-expanded="false">
  <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Collections</span>
  </div>
</a>
<!-- more inner pages-->
</li>

<li class="nav-item"><a class="nav-link" href="{{route('reports.leasestatus')}}" aria-expanded="false">
  <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Lease Status Report</span>
  </div>
</a>
<!-- more inner pages-->
</li>

<li class="nav-item"><a class="nav-link" href="{{route('reports.projections')}}" aria-expanded="false">
  <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Projections Report</span>
  </div>
</a>
<!-- more inner pages-->
</li>

<li class="nav-item"><a class="nav-link" href="{{route('reports.generalprojections')}}" aria-expanded="false">
  <div class="d-flex align-items-center"><span class="nav-link-text ps-1">All Projections Report</span>
  </div>
</a>
<!-- more inner pages-->
</li>

<li class="nav-item"><a class="nav-link" href="{{route('reports.anualprojections')}}" aria-expanded="false">
  <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Annual Projections</span>
  </div>
</a>
<!-- more inner pages-->
</li>

<li class="nav-item"><a class="nav-link" href="{{route('reports.bianualprojections')}}" aria-expanded="false">
  <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Bi-Annual Projections</span>
  </div>
</a>
<!-- more inner pages-->
</li>

<li class="nav-item"><a class="nav-link" href="{{route('reports.quaterlyprojections')}}" aria-expanded="false">
  <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Quaterly Projections</span>
  </div>
</a></li>

<li class="nav-item"><a class="nav-link" href="{{route('reports.ledgers')}}" aria-expanded="false">
  <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Tenant Ledgers</span>
  </div>
</a></li>

</ul>



          </li>
        
          
          
        </ul>
      
      </div>
    </div>
</nav>