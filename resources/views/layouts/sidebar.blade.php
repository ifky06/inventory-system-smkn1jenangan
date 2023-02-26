<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/dashboard" class="brand-link">
      <img src="{{ asset('lte/dist/img/inventory.png') }}" alt="AdminLTE Logo" class="brand-image"
           style="opacity: .8">
      <span class="brand-text font-weight-light"><b> INVENTARIS</b></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('images/profile/'.Auth::user()->foto) }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="/profile" class="d-block">
            @if (Auth::user()->status == 0)
                Admin
            @else
                Penanggung jawab {{ Auth::user()->pj }}
            @endif
          </a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent nav-legacy" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
               <li class="nav-item">
                <a href="{{ url('/dashboard') }}" class="nav-link {{ (request()->is('dashboard*')) ? 'active' : '' }}">
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>
                    Dashboard
                  </p>
                </a>
              </li>
          <li class="nav-item has-treeview {{ (request()->is('rusak*')) ? 'menu-open' : '' }}{{ (request()->is('kondisi*')) ? 'menu-open' : '' }} {{ (request()->is('barang*')) ? 'menu-open' : '' }} {{ (request()->is('bengkel*')) ? 'menu-open' : '' }} {{ (request()->is('sumber_dana*')) ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ (request()->is('rusak*')) ? 'active' : '' }}{{ (request()->is('kondisi*')) ? 'active' : '' }} {{ (request()->is('barang*')) ? 'active' : '' }} {{ (request()->is('bengkel*')) ? 'active' : '' }} {{ (request()->is('sumber_dana*')) ? 'active' : '' }}">
              <i class="nav-icon fas fa-cog"></i>
              <p>
                Data Master
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/barang" class="nav-link {{ (request()->is('barang*')) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Barang</p>
                </a>
              </li>
            @if (Auth::user()->status==1)
              <li class="nav-item">
                <a href="/kondisi" class="nav-link {{ (request()->is('kondisi*')) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Update Kondisi</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/rusak" class="nav-link {{ (request()->is('rusak*')) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Barang Rusak</p>
                </a>
              </li>
            @endif
            @if (Auth::user()->status==0)
              <li class="nav-item">
                <a href="/bengkel" class="nav-link {{ (request()->is('bengkel*')) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Bengkel</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/sumber_dana" class="nav-link {{ (request()->is('sumber_dana*')) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Sumber Dana</p>
                </a>
              </li>
              @endif
            </ul>
          </li>
          <li class="nav-item has-treeview {{ (request()->is('perbaikan*')) ? 'menu-open' : '' }} {{ (request()->is('diperbaiki*')) ? 'menu-open' : '' }} {{ (request()->is('dataperbaikan*')) ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ (request()->is('perbaikan*')) ? 'active' : '' }} {{ (request()->is('diperbaiki*')) ? 'active' : '' }} {{ (request()->is('dataperbaikan*')) ? 'active' : '' }}">
              <i class="nav-icon fas fa-tools"></i>
              <p>
                Perbaikan
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/perbaikan" class="nav-link {{ (request()->is('perbaikan*')) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Menunggu Persetujuan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/diperbaiki" class="nav-link {{ (request()->is('diperbaiki*')) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Sedang Diperbaiki</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/dataperbaikan" class="nav-link {{ (request()->is('dataperbaikan*')) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Perbaikan</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview {{ (request()->is('peminjaman*')) ? 'menu-open' : '' }} {{ (request()->is('pengembalian*')) ? 'menu-open' : '' }} {{ (request()->is('datapeminjaman*')) ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ (request()->is('peminjaman*')) ? 'active' : '' }} {{ (request()->is('pengembalian*')) ? 'active' : '' }} {{ (request()->is('datapeminjaman*')) ? 'active' : '' }}">
              <i class="nav-icon fas fa-briefcase"></i>
              <p>
                Peminjaman Barang
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/peminjaman" class="nav-link {{ (request()->is('peminjaman*')) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Peminjaman</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/pengembalian" class="nav-link {{ (request()->is('pengembalian*')) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pengembalian</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/datapeminjaman" class="nav-link {{ (request()->is('datapeminjaman*')) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Peminjaman</p>
                </a>
              </li>
            </ul>
          </li>
            @if (Auth::user()->status==0)
          <li class="nav-item has-treeview {{ (request()->is('user_admin*')) ? 'menu-open' : '' }} {{ (request()->is('user_pj*')) ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ (request()->is('user_admin*')) ? 'active' : '' }} {{ (request()->is('user_pj*')) ? 'active' : '' }}">
              <i class="nav-icon fas fa-user"></i>
              <p>
                User
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/user_admin" class="nav-link {{ (request()->is('user_admin*')) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Admin</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/user_pj" class="nav-link {{ (request()->is('user_pj*')) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Penanggung Jawab</p>
                </a>
              </li>
            </ul>
          </li>
          @endif
          <li class="nav-item has-treeview {{ (request()->is('keluar*')) ? 'menu-open' : '' }} {{ (request()->is('masuk*')) ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ (request()->is('keluar*')) ? 'active' : '' }} {{ (request()->is('masuk*')) ? 'active' : '' }}">
              <i class="nav-icon fas fa-box-open"></i>
              <p>
                Keluar Masuk
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/keluar" class="nav-link {{ (request()->is('keluar*')) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Keluar</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/masuk" class="nav-link {{ (request()->is('masuk*')) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Masuk</p>
                </a>
              </li>
            </ul>
          </li>


        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>