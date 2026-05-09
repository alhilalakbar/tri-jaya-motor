<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <div class="sidebar-brand">
        <a href="<?= base_url('dashboard') ?>" class="brand-link">
            <span class="brand-text fw-light">TRI JAYA MOTOR</span>
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
                    <a href="<?= base_url('backend/master/mekanik') ?>" class="nav-link">
                        <i class="nav-icon bi bi-person-badge-fill"></i>
                        <p>Mekanik</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('backend/master/pelanggan') ?>" class="nav-link">
                        <i class="nav-icon bi bi-person-lines-fill"></i>
                        <p>Pelanggan</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('backend/master/kendaraan') ?>" class="nav-link">
                        <i class="nav-icon bi bi-car-front-fill"></i>
                        <p>Kendaraan</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('backend/master/sparepart') ?>" class="nav-link">
                        <i class="nav-icon bi bi-box-seam-fill"></i>
                        <p>Sparepart</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('backend/master/jasa_servis') ?>" class="nav-link">
                        <i class="nav-icon bi bi-tools"></i>
                        <p>Jasa Servis</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('backend/master/pemasok') ?>" class="nav-link">
                        <i class="nav-icon bi bi-building-fill"></i>
                        <p>Pemasok (Supplier)</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-tags-fill"></i>
                        <p>
                            Data Referensi
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url('backend/master/kategori_part') ?>" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Kategori Part</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('backend/master/merk_part') ?>" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Merek Part</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('backend/master/merk_motor') ?>" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Merek Motor</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('backend/master/tipe_motor') ?>" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Tipe Motor</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-header">TRANSAKSI</li>
                <li class="nav-item">
                    <a href="<?= base_url('backend/transaksi/servis') ?>" class="nav-link">
                        <i class="nav-icon bi bi-wrench-adjustable-circle-fill"></i>
                        <p>Servis Bengkel</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('backend/transaksi/pembelian') ?>" class="nav-link">
                        <i class="nav-icon bi bi-cart-check-fill"></i>
                        <p>Pembelian Stok</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('backend/transaksi/jasa_luar') ?>" class="nav-link">
                        <i class="nav-icon bi bi-truck-flatbed"></i>
                        <p>Jasa Luar (Bubut)</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?= base_url('backend/transaksi/gaji_mekanik') ?>" class="nav-link">
                        <i class="nav-icon bi bi-cash-stack"></i>
                        <p>Gaji Mekanik</p>
                    </a>
                </li>

                <li class="nav-header">SISTEM</li>
                <li class="nav-item">
                    <a href="<?= base_url('backend/master/pengguna') ?>" class="nav-link">
                        <i class="nav-icon bi bi-person-gear-fill"></i>
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