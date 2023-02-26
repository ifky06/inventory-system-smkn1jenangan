{{ (request()->is('login*')) ? 'Login' : '' }}
{{ (request()->is('dashboard*')) ? 'Dashboard' : '' }}
{{ (request()->is('barang*')) ? 'Barang' : '' }}
{{ (request()->is('bengkel*')) ? 'Bengkel' : '' }}
{{ (request()->is('sumber_dana*')) ? 'Sumber Dana' : '' }}
{{ (request()->is('kondisi*')) ? 'Update Kondisi' : '' }}
{{ (request()->is('rusak*')) ? 'Barang Rusak' : '' }}
{{ (request()->is('perbaikan*')) ? 'Menunggu Persetujuan' : '' }}
{{ (request()->is('diperbaiki*')) ? 'Sedang Diperbaiki' : '' }}
{{ (request()->is('dataperbaikan*')) ? 'Data Perbaikan' : '' }}
{{ (request()->is('peminjaman*')) ? 'Peminjaman' : '' }}
{{ (request()->is('pengembalian*')) ? 'Pengembalian' : '' }}
{{ (request()->is('datapeminjaman*')) ? 'Data Peminjaman' : '' }}
{{ (request()->is('user_admin*')) ? 'User Admin' : '' }}
{{ (request()->is('user_pj*')) ? 'User Penanggung Jawab' : '' }}
{{ (request()->is('masuk*')) ? 'Barang Masuk' : '' }}
{{ (request()->is('keluar*')) ? 'Barang Keluar' : '' }}
{{ (request()->is('profile')) ? 'Profile' : '' }}
{{ (request()->is('profile/username')) ? 'Ubah Username' : '' }}
{{ (request()->is('profile/password')) ? 'Ubah Password' : '' }}
{{ (request()->is('profile/edit')) ? 'Edit Profile' : '' }}