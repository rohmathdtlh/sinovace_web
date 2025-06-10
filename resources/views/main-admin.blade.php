<!DOCTYPE html>
<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../assets/"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>@yield('title') | SINOVACE</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />
{{-- {{ asset('style/') }} --}}
    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{ asset('style/assets/vendor/fonts/boxicons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('style/assets/vendor/css/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('style/assets/vendor/css/theme-default.css') }}" class="template-customizer-theme-css" />
    {{-- <link rel="stylesheet" href="{{ asset('style/assets/css/demo.css') }}" /> --}}

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('style/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />

    <link rel="stylesheet" href="{{ asset('style/assets/vendor/libs/apex-charts/apex-charts.css') }}" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="{{ asset('style/assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('style/assets/js/config.js') }}"></script>

    <!-- JQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    
    <!-- Load an icon library to show a hamburger menu (bars) on small screens -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


  </head>

  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Menu -->

        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
          <div class="app-brand" style="background-color: rgba(31, 49, 111, 0.95)">
            <a href="{{ url('admin/pengaduan_langsung') }}" class="app-brand-link">
                <span class="app-brand-logo" style="margin-top: 20px; margin-bottom: 20px;">
                    <img src="{{ asset('/img/Logo.png') }}" alt="Logo Sinovace" style="height: 33px; width: auto;" />
                </span>
            </a>
          </div>

          <div class="menu-inner-shadow"></div>

          <ul class="menu-inner py-1">
        
            <!-- Forms & Tables -->

              <!-- Izin Penelitian -->
              @if(auth()->user()->kategori_id === null)
                <li class="menu-item {{ Request::is('admin/izin_penelitian*') ? 'active' : '' }}">
                  <a href="{{ url('admin/izin_penelitian') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-paste"></i>
                    <div data-i18n="Analytics">Izin Penelitian/Riset</div>
                  </a>
                </li>
              @endif

              @if(auth()->user()->kategori_id === null)
                <li class="menu-item {{ Request::is('admin/ppid*') ? 'active' : '' }}">
                  <a href="{{ url('admin/ppid') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-paste"></i>
                    <div data-i18n="Analytics">PPID</div>
                  </a>
                </li>
              @endif
               <div class="menu-inner-shadow"></div>
                  <ul class="menu-inner py-1">
              @php
            $adminKategoriId = auth()->user()->kategori_id;

            $laporActiveRoutes = [
                'admin.lapor.dashboard',
                'admin.lapor.index',
                'admin.tanggapan.sarana-prasarana',
                'admin.tanggapan.pembinaan-sekolah',
                'admin.tanggapan.pembinaan-paud',
                'admin.tanggapan.kepegawaian',
                'admin.tanggapan.perencanaan',
                'admin.tanggapan.keuangan',
                'admin.tanggapan.uptd',
                'admin.tanggapan.byKategori'
            ];

            $currentRoute = Route::currentRouteName();
            $isLaporActive = in_array($currentRoute, $laporActiveRoutes);

            // Ambil status menu dari session, default false (tertutup)
            $menuState = session()->has('menu.lapor.open') ? session()->get('menu.lapor.open') : false;

            // Jika ada parameter menu_lapor, update session
            if(request()->has('menu_lapor')) {
                $menuState = request()->menu_lapor === 'open';
                session()->put('menu.lapor.open', $menuState);
            }

            // Pastikan menu terbuka hanya jika route aktif dan user tidak sedang mencoba menutup menu
            // Tambahkan pengecekan agar tidak override jika user baru saja menutup menu
            if($isLaporActive && !request()->has('menu_lapor')) {
                $menuState = true;
            }
        @endphp

        <li class="menu-item {{ $menuState ? 'active open' : '' }}">
            <a href="javascript:void(0)" class="menu-link menu-toggle" onclick="toggleLaporMenu()">
                <i class="menu-icon tf-icons bx bxs-school"></i>
                <div data-i18n="Lapor/Pengaduan">Layanan Pengaduan</div>
            </a>
            <ul class="menu-sub {{ $menuState ? 'open' : '' }}">
                @if($adminKategoriId === null)
                    {{-- Admin super: tampilkan semua menu --}}
                    <li class="menu-item {{ Route::currentRouteName() === 'admin.lapor.dashboard' ? 'active' : '' }}">
                        <a href="{{ route('admin.lapor.dashboard') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-home-alt"></i>
                            <div data-i18n="Dashboard">Dashboard</div>
                        </a>
                    </li>
                    <li class="menu-item {{ Route::currentRouteName() === 'admin.lapor.index' ? 'active' : '' }}">
                        <a href="{{ route('admin.lapor.index') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-list-ul"></i>
                            <div data-i18n="Lapor">Data Pengaduan</div>
                        </a>
                    </li>
                    @foreach(App\Models\KategoriPengaduan::all() as $kategori)
                        <li class="menu-item {{ (Route::currentRouteName() === 'admin.tanggapan.byKategori' && Route::current()->parameter('id') == $kategori->id) ? 'active' : '' }}">
                            <a href="{{ route('admin.tanggapan.byKategori', $kategori->id) }}" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-message-alt"></i>
                                <div class="text-truncate" style="max-width: 180px;" title="{{ $kategori->nama_kategori }}">
                                    {{ $kategori->nama_kategori }}
                                </div>
                            </a>
                        </li>
                    @endforeach
                @else
                    {{-- Admin kategori terbatas: hanya tampilkan kategori yang dia punya --}}
                    @php
                        $kategori = App\Models\KategoriPengaduan::find($adminKategoriId);
                    @endphp
                    <li class="menu-item {{ (Route::currentRouteName() === 'admin.tanggapan.byKategori' && Route::current()->parameter('id') == $adminKategoriId) ? 'active' : '' }}">
                        <a href="{{ route('admin.tanggapan.byKategori', $adminKategoriId) }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-message-alt"></i>
                            <div class="text-truncate" style="max-width: 180px;" title="{{ $kategori->nama_kategori }}">
                                {{ $kategori->nama_kategori }}
                            </div>
                        </a>
                    </li>
                @endif
            </ul>
        </li>

        @if($adminKategoriId === null)
            {{-- Hanya tampilkan menu lain jika admin super --}}
            <li class="menu-header">
                <span class="menu-header-text">Lainnya</span>
            </li>
            <li class="menu-item {{ Request::is('admin/akun_admin*') ? 'active' : '' }}">
                <a href="{{ url('admin/akun_admin') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-user"></i>
                    <div data-i18n="Settings">Akun Admin</div>
                </a>
            </li>
            <li class="menu-item {{ Request::is('admin/akun_user*') ? 'active' : '' }}">
                <a href="{{ route('admin.akun_user') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-user-circle"></i>
                    <div data-i18n="Akun User">Akun User</div>
                </a>
            </li>

            <li class="menu-item {{ Request::is('kategori*') ? 'active' : '' }}">
                <a href="{{ route('kategori.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-category"></i>
                    <div data-i18n="Manajemen Kategori">Manajemen Kategori</div>
                </a>
            </li>
            <li class="menu-item {{ Request::is('admin/notifikasi*') ? 'active' : '' }}">
                <a href="{{ route('admin.notifications') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-bell"></i>
                    <div data-i18n="Notifikasi">Notifikasi
                        <span class="badge rounded-pill bg-label-danger">{{ auth()->user()->unreadNotifications->count() }}</span>
                    </div>
                </a>
            </li>
            <li class="menu-item">
                <a href="#" class="menu-link" style="color: red"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="menu-icon tf-icons bx bx-power-off"></i>
                    <div data-i18n="Settings">Logout</div>
                </a>
            </li>
        @else
            {{-- Admin kategori terbatas: hanya tampilkan logout --}}
            <li class="menu-item">
                <a href="#" class="menu-link" style="color: red"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="menu-icon tf-icons bx bx-power-off"></i>
                    <div data-i18n="Settings">Logout</div>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  @csrf
              </form>
            </li>
        @endif
          </ul>
        </aside>
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
          
        <!-- Navbar -->
        <nav class="navbar-nav-right navbar-expand-xl d-flex align-items-center" id="navbar-collapse">
          <ul class="navbar-nav flex-row align-items-center ms-auto">
            <!-- Place this tag where you want the button to render. -->

            <div class="navbar-nav-right d-flex align-items-end row" id="navbar-collapse"></div>

            <!-- User -->
            <li class="nav-item navbar-dropdown dropdown-user dropdown">
              <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                <div class="avatar avatar-online">
                  {{-- <img src="{{ asset('profile/' . Auth::user()->avatar) }}" alt="Avatar" class="avatar w-px-40 h-auto rounded-circle"> --}}
                  <img src="{{ asset('img/Profil.png') }}" alt class="w-px-40 h-auto rounded-circle" />
                </div>
              </a>
              <ul class="dropdown-menu dropdown-menu-end">
                <li>
                  <a class="dropdown-item" href="#">
                    <div class="d-flex">
                      <div class="flex-shrink-0 me-3">
                        <div class="avatar avatar-online">
                          {{-- <img src="{{ asset('profile/' . Auth::user()->avatar) }}" alt="Avatar" class="w-px-10 h-auto rounded-circle" /> --}}
                          <img src="{{ asset('img/Profil.png') }}" alt class="w-px-40 h-auto rounded-circle" />
                        </div>
                      </div>
                      <div class="flex-grow-1">
                        <span class="fw-semibold d-block">
                          @auth
                          {{auth()->user()->name }}
                          @endauth
                        </span>
                        <small class="text-muted">Admin</small>
                      </div>
                    </div>
                  </a>
                </li>

                  <div class="dropdown-divider"></div>
                </li>
                @auth
                  {{-- <li>
                    <a class="dropdown-item" href="{{ url('admin/registration') }}">
                      <i class="bx bx-user-plus me-2"></i>
                      <span class="align-middle">Registrasi</span>
                    </a>
                  </li> --}}
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                  </form>
                  
                <a class="dropdown-item" href="#" 
                  onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="bx bx-power-off me-2"></i>
                    <span class="align-middle">Log Out</span>
                </a>
                @endauth
              </ul>
            </li>
            <!--/ User -->
          </ul>
        </nav>

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->
            
            @yield('content')
            <!-- / Content -->


            <!-- Footer -->
            <footer class="content-footer footer bg-footer-theme">
              <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                <div class="mb-2 mb-md-0">
                  ©
                  <script>
                    document.write(new Date().getFullYear());
                  </script>
                  SINOVACE
                </div>
                </div>
              </div>
            </footer>
            <!-- / Footer -->

            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{ asset('style/assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('style/assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('style/assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('style/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>

    <script src="{{ asset('style/assets/vendor/js/menu.js') }}"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{ asset('style/assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ asset('style/assets/js/main.js') }}"></script>

    <!-- Page JS -->
    <script src="{{ asset('style/assets/js/dashboards-analytics.js') }}"></script>

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Include JS files -->
    <script>
      document.addEventListener('DOMContentLoaded', function () {
          const currentUrl = window.location.pathname;
          const menuItems = document.querySelectorAll('.menu-item a');
  
          menuItems.forEach(item => {
              if (item.href === window.location.href) {
                  item.parentElement.classList.add('active');
  
                  // Tambahkan kelas aktif ke menu induk jika item adalah submenu
                  const parentMenuItem = item.closest('.menu-item.menu-toggle');
                  if (parentMenuItem) {
                      parentMenuItem.classList.add('active');
                  }
              }
          });
      });
    </script>

    <!-- Toggle script -->
    <script>
      document.querySelector('.navbar-toggler').addEventListener('click', function () {
        const mainMenu = document.getElementById('main-menu');
        mainMenu.classList.toggle('show');
      });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).on('click', '.mark-as-read', function () {
            const notificationId = $(this).data('id');
            const button = $(this);
    
            $.ajax({
                url: `/admin/notifications/${notificationId}/read`,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    if (response.success) {
                        button.replaceWith('<span class="badge bg-success">Sudah Dibaca</span>');
                    } else {
                        alert('Gagal menandai sebagai dibaca.');
                    }
                },
                error: function () {
                    alert('Terjadi kesalahan. Coba lagi.');
                }
            });
        });
    </script>
  </body>
</html>
