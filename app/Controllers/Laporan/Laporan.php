<?php

namespace App\Controllers\Laporan;

use App\Controllers\BaseController;
use App\Models\Laporan\TransaksiServisLaporanModel;
use App\Models\Laporan\StokSparepartLaporanModel;
use App\Models\Laporan\PerformaMekanikLaporanModel;
use App\Models\Laporan\PembelianStokLaporanModel;
use App\Models\Laporan\PengeluaranLaporanModel;
use App\Models\Laporan\LoyalitasLaporanModel;
use App\Models\Laporan\LabaRugiLaporanModel;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Dompdf\Dompdf;

class Laporan extends BaseController
{
    protected $helpers = ['date', 'number'];

    private function getDateRange()
    {
        return [
            'tgl_mulai' => $this->request->getGet('tgl_mulai') ?? date('Y-m-01'),
            'tgl_akhir' => $this->request->getGet('tgl_akhir') ?? date('Y-m-d')
        ];
    }

    public function transaksi()
    {
        $range = $this->getDateRange();
        $model = new TransaksiServisLaporanModel();

        $laporan = $model->where('tanggal_masuk >=', $range['tgl_mulai'] . ' 00:00:00')
            ->where('tanggal_masuk <=', $range['tgl_akhir'] . ' 23:59:59')
            ->findAll();

        return view('backend/laporan/transaksi', [
            'judul' => 'Laporan Transaksi Servis',
            'laporan' => $laporan,
            'tgl_mulai' => $range['tgl_mulai'],
            'tgl_akhir' => $range['tgl_akhir']
        ]);
    }

    public function stok()
    {
        $model = new StokSparepartLaporanModel();

        return view('backend/laporan/stok', [
            'judul' => 'Laporan Stok Sparepart',
            'laporan' => $model->findAll(),
            'tgl_mulai' => date('Y-m-01'),
            'tgl_akhir' => date('Y-m-d')
        ]);
    }

    public function mekanik()
    {
        $range = $this->getDateRange();
        $model = new PerformaMekanikLaporanModel();

        return view('backend/laporan/mekanik', [
            'judul' => 'Laporan Performa Mekanik',
            'laporan' => $model->findAll(),
            'tgl_mulai' => $range['tgl_mulai'],
            'tgl_akhir' => $range['tgl_akhir']
        ]);
    }

    public function pembelian()
    {
        $range = $this->getDateRange();
        $model = new PembelianStokLaporanModel();

        $laporan = $model->where('tanggal_pembelian >=', $range['tgl_mulai'] . ' 00:00:00')
            ->where('tanggal_pembelian <=', $range['tgl_akhir'] . ' 23:59:59')
            ->findAll();

        return view('backend/laporan/pembelian', [
            'judul' => 'Laporan Pembelian Stok',
            'laporan' => $laporan,
            'tgl_mulai' => $range['tgl_mulai'],
            'tgl_akhir' => $range['tgl_akhir']
        ]);
    }

    public function pengeluaran()
    {
        $range = $this->getDateRange();
        $model = new PengeluaranLaporanModel();

        $laporan = $model->where('tanggal >=', $range['tgl_mulai'] . ' 00:00:00')
            ->where('tanggal <=', $range['tgl_akhir'] . ' 23:59:59')
            ->findAll();

        return view('backend/laporan/pengeluaran', [
            'judul' => 'Laporan Pengeluaran',
            'laporan' => $laporan,
            'tgl_mulai' => $range['tgl_mulai'],
            'tgl_akhir' => $range['tgl_akhir']
        ]);
    }

    public function loyalitas()
    {
        $range = $this->getDateRange();
        $model = new LoyalitasLaporanModel();

        return view('backend/laporan/loyalitas', [
            'judul' => 'Laporan Loyalitas Pelanggan',
            'laporan' => $model->findAll(),
            'tgl_mulai' => $range['tgl_mulai'],
            'tgl_akhir' => $range['tgl_akhir']
        ]);
    }

    public function labaRugi()
    {
        $range = $this->getDateRange();
        $model = new LabaRugiLaporanModel();

        return view('backend/laporan/laba_rugi', [
            'judul' => 'Laporan Laba Rugi',
            'laba' => $model->first(),
            'tgl_mulai' => $range['tgl_mulai'],
            'tgl_akhir' => $range['tgl_akhir']
        ]);
    }

    private function getHeaderMap($jenis)
    {
        $maps = [
            'transaksi' => [
                'kode_transaksi' => 'Kode Transaksi',
                'tanggal_masuk' => 'Tanggal',
                'nama_pelanggan' => 'Pelanggan',
                'nomor_plat' => 'Nomor Plat',
                'nama_merek_motor' => 'Merek',
                'nama_tipe' => 'Tipe',
                'nama_mekanik' => 'Mekanik',
                'status_pengerjaan' => 'Status Pengerjaan',
                'status_pembayaran' => 'Status Pembayaran',
                'metode_pembayaran' => 'Metode Pembayaran',
                'total_biaya' => 'Total Biaya',
            ],

            'pembelian' => [
                'kode_pembelian' => 'Kode Pembelian',
                'tanggal_pembelian' => 'Tanggal',
                'nama_pemasok' => 'Pemasok',
                'nama_part' => 'Nama Sparepart',
                'jumlah_beli' => 'Jumlah',
                'harga_beli_satuan' => 'Harga Satuan',
                'subtotal' => 'Subtotal',
                'total_biaya_pembelian' => 'Total Pembelian',
            ],

            'laba-rugi' => [
                'total_pendapatan' => 'Total Pendapatan',
                'total_pembelian' => 'Total Pembelian',
                'total_operasional' => 'Total Operasional',
                'total_gaji' => 'Total Gaji',
                'estimasi_laba_bersih' => 'Estimasi Laba Bersih',
            ],
        ];

        return $maps[$jenis] ?? [];
    }
    
    private function formatValue($key, $value)
    {
        $currencyFields = [
            'total_biaya',
            'harga_beli_satuan',
            'subtotal',
            'total_biaya_pembelian',
            'total_pendapatan',
            'total_pembelian',
            'total_operasional',
            'total_gaji',
            'estimasi_laba_bersih'
        ];

        $dateFields = [
            'tanggal_masuk',
            'tanggal_pembelian',
            'tanggal'
        ];

        if (in_array($key, $currencyFields)) {
            return 'Rp ' . number_format((float)$value, 0, ',', '.');
        }

        if (in_array($key, $dateFields) && !empty($value)) {
            return date('d M Y H:i', strtotime($value));
        }

        return $value;
    }
    
    private function getExportData($jenis)
    {
        $range = $this->getDateRange();

        switch ($jenis) {
            case 'transaksi':
                $model = new TransaksiServisLaporanModel();
                return $model->where('tanggal_masuk >=', $range['tgl_mulai'] . ' 00:00:00')
                    ->where('tanggal_masuk <=', $range['tgl_akhir'] . ' 23:59:59')
                    ->findAll();

            case 'pembelian':
                $model = new PembelianStokLaporanModel();
                return $model->where('tanggal_pembelian >=', $range['tgl_mulai'] . ' 00:00:00')
                    ->where('tanggal_pembelian <=', $range['tgl_akhir'] . ' 23:59:59')
                    ->findAll();

            case 'pengeluaran':
                $model = new PengeluaranLaporanModel();
                return $model->where('tanggal >=', $range['tgl_mulai'] . ' 00:00:00')
                    ->where('tanggal <=', $range['tgl_akhir'] . ' 23:59:59')
                    ->findAll();

            case 'mekanik':
                return (new PerformaMekanikLaporanModel())->findAll();

            case 'loyalitas':
                return (new LoyalitasLaporanModel())->findAll();

            case 'stok':
                return (new StokSparepartLaporanModel())->findAll();

            case 'laba-rugi':
                return [(array)(new LabaRugiLaporanModel())->first()];

            default:
                return [];
        }
    }

    public function exportExcel($jenis)
    {
        $data = $this->getExportData($jenis);
        $headerMap = $this->getHeaderMap($jenis);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'LAPORAN ' . strtoupper(str_replace('-', ' ', $jenis)));
        $sheet->mergeCells('A1:J1');

        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        if (!empty($data)) {
            $keys = array_keys((array)$data[0]);

            $col = 'A';
            foreach ($keys as $key) {
                $label = $headerMap[$key] ?? ucfirst(str_replace('_', ' ', $key));
                $sheet->setCellValue($col . '3', $label);
                $col++;
            }

            $sheet->getStyle('A3:' . chr(ord('A') + count($keys) - 1) . '3')
                ->getFont()
                ->setBold(true);

            $sheet->getStyle('A3:' . chr(ord('A') + count($keys) - 1) . '3')
                ->getFill()
                ->setFillType(Fill::FILL_SOLID)
                ->getStartColor()
                ->setARGB('1F2937');

            $sheet->getStyle('A3:' . chr(ord('A') + count($keys) - 1) . '3')
                ->getFont()
                ->getColor()
                ->setARGB('FFFFFF');

            $row = 4;

            foreach ($data as $item) {
                $col = 'A';

                foreach ((array)$item as $key => $value) {
                    $sheet->setCellValue($col . $row, $this->formatValue($key, $value));
                    $col++;
                }

                $row++;
            }

            foreach (range('A', chr(ord('A') + count($keys) - 1)) as $column) {
                $sheet->getColumnDimension($column)->setAutoSize(true);
            }

            $sheet->getStyle('A3:' . chr(ord('A') + count($keys) - 1) . ($row - 1))
                ->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN
                        ]
                    ]
                ]);
        }

    $writer = new Xlsx($spreadsheet);

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="laporan-' . $jenis . '.xlsx"');

    $writer->save('php://output');
    exit;
}
    public function exportPdf($jenis)
    {
        $data = $this->getExportData($jenis);
        $headerMap = $this->getHeaderMap($jenis);

        $html = '
        <style>
            body {
                font-family: Arial, sans-serif;
                font-size: 11px;
            }

            h2 {
                text-align: center;
                margin-bottom: 20px;
            }

            table {
                width: 100%;
                border-collapse: collapse;
            }

            th {
                background-color: #1F2937;
                color: white;
                padding: 8px;
                border: 1px solid #ccc;
            }

            td {
                padding: 6px;
                border: 1px solid #ccc;
            }

            tr:nth-child(even) {
                background-color: #f5f5f5;
            }
        </style>
        ';

        $html .= '<h2>Laporan ' . strtoupper(str_replace('-', ' ', $jenis)) . '</h2>';
        $html .= '<table>';

        if (!empty($data)) {
            $keys = array_keys((array)$data[0]);

            $html .= '<tr>';

            foreach ($keys as $key) {
                $label = $headerMap[$key] ?? ucfirst(str_replace('_', ' ', $key));
                $html .= '<th>' . $label . '</th>';
            }

            $html .= '</tr>';

            foreach ($data as $item) {
                $html .= '<tr>';

                foreach ((array)$item as $key => $value) {
                    $html .= '<td>' . $this->formatValue($key, $value) . '</td>';
                }

                $html .= '</tr>';
            }
        }

        $html .= '</table>';

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream('laporan-' . $jenis . '.pdf', ['Attachment' => true]);

        exit;
    }
}