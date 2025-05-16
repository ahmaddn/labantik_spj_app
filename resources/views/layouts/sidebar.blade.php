<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="menu-title">
                    <span>Main Menu</span>
                </li>
                <li class="{{ Route::is('dashboard') ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}" class="{{ Route::is('dashboard') ? 'active' : '' }}"><i
                            class="feather-grid"></i> <span> Dashboard Admin</span></a>
                </li>
                <li class="submenu {{ Route::is('internal.*') ? 'active' : '' }}">
                    <a href="#"><i class="fas fa-graduation-cap"></i> <span> Internal</span> <span
                            class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="{{ route('internal.kepsek.index') }}"
                                class="{{ Route::is('internal.kepsek.index') ? 'active' : '' }}">Kepala Sekolah</a></li>
                        <li><a href="{{ route('internal.bendahara.index') }}"
                                class="{{ Route::is('internal.bendahara.index') ? 'active' : '' }}">Bendahara</a></li>
                        <li><a href="{{ route('internal.penerima.index') }}"
                                class="{{ Route::is('internal.penerima.index') ? 'active' : '' }}">Penerima</a></li>
                    </ul>
                </li>
                <li class="{{ Route::is('eksternal.*') ? 'active' : '' }}">
                    <a href="#"><i class="fas fa-chalkboard-teacher"></i> <span> Eksternal</span> <span
                            class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="{{ route('eksternal.kegiatan.index') }}" 
                                class="{{ Route::is('eksternal.kegiatan.index*') ? 'active' : '' }}">Kegiatan</a></li>
                        <li><a href="#" 
                                class="{{ Route::is('eksternal.barang.index*') ? 'active' : '' }}">Barang</a></li>
                        <li><a href="#"     
                                class="{{ Route::is('eksternal.penyedia.index*') ? 'active' : '' }}">Penyedia</a></li>
                        <li><a href="#" 
                                class="{{ Route::is('eksternal.pesanan.index*') ? 'active' : '' }}">Pesanan</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
