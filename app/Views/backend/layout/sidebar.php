<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <div class="sidebar-brand">
        <a href="<?= base_url('dashboard') ?>" class="brand-link d-flex align-items-center gap-2">
            <img src="<?= base_url('assets/logo.png') ?>" alt="Logo"
                style="width:60px; height:60px; object-fit:contain;">
            <div class="d-flex flex-column lh-sm">
                <span class="fw-bold text-white">TRI JAYA MOTOR</span>
                <small class="text-secondary">Sistem Bengkel</small>
            </div>
        </a>
    </div>

    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="navigation">

                <li class="nav-item">
                    <a href="<?= base_url('dashboard') ?>" class="nav-link">
                        <i class="nav-icon bi bi-speedometer"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-header">MASTER DATA</li>
                <li class="nav-item">
                    <a href="<?= base_url('master/mekanik') ?>" class="nav-link">
                        <i class="nav-icon bi bi-person-badge-fill"></i>
                        <p>Mekanik</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('master/pelanggan') ?>" class="nav-link">
                        <i class="nav-icon bi bi-people-fill"></i>
                        <p>Pelanggan</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('master/kendaraan') ?>" class="nav-link">
                        <i class="nav-icon bi bi-car-front-fill"></i>
                        <p>Kendaraan</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('master/sparepart') ?>" class="nav-link">
                        <i class="nav-icon bi bi-box-seam-fill"></i>
                        <p>Sparepart</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('master/jasa-servis') ?>" class="nav-link">
                        <i class="nav-icon bi bi-tools"></i>
                        <p>Jasa Servis</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('master/pemasok') ?>" class="nav-link">
                        <i class="nav-icon bi bi-buildings-fill"></i>
                        <p>Pemasok (Supplier)</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-list-ul"></i>
                        <p>Data Referensi <i class="nav-arrow bi bi-chevron-right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url('master/merek-motor') ?>" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Merek Motor</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('master/tipe-motor') ?>" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Tipe Motor</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('master/kategori-part') ?>" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Kategori Part</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('master/kategori-biaya-operasional') ?>" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Kategori Biaya Operasional</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('master/merek-part') ?>" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Merek Part</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-header">TRANSAKSI</li>
                <li class="nav-item">
                    <a href="<?= base_url('transaksi/servis') ?>" class="nav-link">
                        <i class="nav-icon bi bi-gear-fill"></i>
                        <p>Servis Bengkel</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('transaksi/pembelian') ?>" class="nav-link">
                        <i class="nav-icon bi bi-cart-fill"></i>
                        <p>Pembelian Stok</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('transaksi/jasa-luar') ?>" class="nav-link">
                        <i class="nav-icon bi bi-truck-flatbed"></i>
                        <p>Jasa Luar (Bubut)</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('transaksi/gaji-mekanik') ?>" class="nav-link">
                        <i class="nav-icon bi bi-cash-stack"></i>
                        <p>Gaji Mekanik</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('transaksi/biaya-operasional') ?>" class="nav-link">
                        <i class="nav-icon bi bi-receipt-cutoff"></i>
                        <p>Biaya Operasional</p>
                    </a>
                </li>

                <li class="nav-header">LAPORAN</li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-journal-text"></i>
                        <p>Menu Laporan <i class="nav-arrow bi bi-chevron-right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url('laporan/transaksi') ?>" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Laporan Transaksi</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('laporan/stok') ?>" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Laporan Stok</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('laporan/mekanik') ?>" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Performa Mekanik</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('laporan/pembelian') ?>" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Laporan Pembelian</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('laporan/pengeluaran') ?>" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Laporan Pengeluaran</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('laporan/loyalitas') ?>" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Loyalitas Pelanggan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('laporan/laba-rugi') ?>" class="nav-link text-warning">
                                <i class="nav-icon bi bi-circle-fill"></i>
                                <p>Laba Rugi</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-header">SISTEM</li>
                <li class="nav-item">
                    <a href="<?= base_url('master/pengguna') ?>" class="nav-link">
                        <i class="nav-icon bi bi-people-fill"></i>
                        <p>Manajemen Pengguna</p>
                    </a>
                </li>

                <li class="nav-item mt-4">
                    <a href="<?= base_url('auth/logout') ?>" class="nav-link text-danger">
                        <i class="nav-icon bi bi-box-arrow-right"></i>
                        <p>Logout</p>
                    </a>
                </li>

            </ul>
        </nav>
    </div>
</aside>