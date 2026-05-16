<?php

namespace App\Exports;

use App\Models\TransaksiSewa;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Symfony\Component\HttpFoundation\StreamedResponse;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

class TimesheetTemplateExport
{
    public function export($transaksiId)
    {
        // =============================
        // 1. LOAD TEMPLATE & DATA
        // =============================
        $spreadsheet = IOFactory::load(
            storage_path('app/templates/timesheet_template.xlsx')
        );
        $sheet = $spreadsheet->getActiveSheet();

        $t = TransaksiSewa::with([
            'pelanggan',
            'operator',
            'timesheets',
            'dpPembayaran' => function($q) {
                $q->orderBy('tanggal', 'asc');
            }
        ])->findOrFail($transaksiId);

        $hargaBaket = $t->harga_sewa_baket ?? 0;
        $hargaBreker = $t->harga_sewa_breker ?? 0;

        $jenisPekerjaan = $t->jenis_pekerjaan;
        if (is_string($jenisPekerjaan)) {
            $decoded = json_decode($jenisPekerjaan, true);
            $jenisPekerjaan = is_array($decoded) ? $decoded : [$jenisPekerjaan];
        }
        $jenisPekerjaan = array_map('strtolower', $jenisPekerjaan);

        // =============================
        // 2. HEADER INFO & BIAYA TETAP
        // =============================
        $sheet->setCellValue('G9',  $t->pelanggan->nama ?? '-');
        $sheet->setCellValue('G10', $t->operator->nama ?? '-');
        $sheet->setCellValue('G11', $t->lokasi_proyek ?? '-');

        $tglMulai = \Carbon\Carbon::parse($t->tanggal_mulai)->format('d-m-Y');
        $tglSelesai = \Carbon\Carbon::parse($t->tanggal_selesai)->format('d-m-Y');
        $sheet->setCellValue('G12', $tglMulai . ' - ' . $tglSelesai);
        $sheet->setCellValue('G13',  $t->jenis_sewa ?? '-');
        $sheet->setCellValue('D19', 'Operator ' . ($t->operator->nama ?? '-'));

        // INFO LOKASI MOB-DEMOB (Baris 17)
        $sheet->setCellValue('G17', ($t->mobilisasi ?? '-') . ' - ' . ($t->demobilisasi ?? '-'));

        $biayaMobDemob = (int) ($t->biaya_mobilisasi ?? 0); 
        $biayaModem = (int) ($t->biaya_modem ?? 0);

        // PERBAIKAN 1: Tampilkan total biaya tambahan di AM17 (agar sejajar dengan info Mob-Demob)
        $sheet->setCellValueExplicit('AM17', ($biayaMobDemob + $biayaModem), DataType::TYPE_NUMERIC);
        $sheet->getStyle('AM17:AN17')->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('AM17:AN17')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

        // =============================
        // 3. TABEL KANAN (DP PEMBAYARAN)
        // =============================
        $dpList = $t->dpPembayaran;
        $dpRow = 16;
        $templateDpRow = 16;

        foreach ($dpList as $i => $dp) {
            if ($dpRow != $templateDpRow) {
                $sheet->duplicateStyle($sheet->getStyle("AQ{$templateDpRow}:AT{$templateDpRow}"), "AQ{$dpRow}:AT{$dpRow}");
                $sheet->mergeCells("AS{$dpRow}:AT{$dpRow}");
            }
            $sheet->setCellValueExplicit("AQ{$dpRow}", (string) ($i + 1), DataType::TYPE_STRING);
            $sheet->setCellValue("AR{$dpRow}", date('d-m-Y', strtotime($dp->tanggal)));
            
            $sheet->mergeCells("AS{$dpRow}:AT{$dpRow}");
            $sheet->setCellValueExplicit("AS{$dpRow}", (int) $dp->jumlah, DataType::TYPE_NUMERIC);
            $sheet->duplicateStyle($sheet->getStyle("AS{$templateDpRow}:AT{$templateDpRow}"), "AS{$dpRow}:AT{$dpRow}");
            $dpRow++;
        }

        // =============================
        // 4. TABEL KIRI (TIMESHEET HM)
        // =============================
        $grouped = $t->timesheets->sortBy('tanggal')->groupBy(function ($ts) {
            return date('Y-m', strtotime($ts->tanggal));
        });

        $templateRow = 20;
        $currentRow  = 20;
        $nomor       = 1;
        $totalKeseluruhanJamBaket = 0;
        $totalKeseluruhanJamBreker = 0;

        $dateColumns = [1=>'G',2=>'H',3=>'I',4=>'J',5=>'K',6=>'L',7=>'M',8=>'N',9=>'O',10=>'P',11=>'Q',12=>'R',13=>'S',14=>'T',15=>'U',16=>'V',17=>'W',18=>'X',19=>'Y',20=>'Z',21=>'AA',22=>'AB',23=>'AC',24=>'AD',25=>'AE',26=>'AF',27=>'AG',28=>'AH',29=>'AI',30=>'AJ',31=>'AK'];

        foreach ($grouped as $ym => $items) {
            if ($currentRow != $templateRow) {
                $sheet->insertNewRowBefore($currentRow, 1);
                $sheet->duplicateStyle($sheet->getStyle("C{$templateRow}:AN{$templateRow}"), "C{$currentRow}:AN{$currentRow}");
                $sheet->mergeCells("AM{$currentRow}:AN{$currentRow}");
            }

            if (in_array('baket', $jenisPekerjaan)) {
                $sheet->setCellValue("C{$currentRow}", $nomor);
                $nomor++;

                $sheet->mergeCells("D{$currentRow}:F{$currentRow}");
                $sheet->setCellValue("D{$currentRow}", date('F Y', strtotime("$ym-01")));
                $sheet->getStyle("D{$currentRow}:F{$currentRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $sheet->getStyle("C{$currentRow}:AN{$currentRow}")->getFont()->setName('Times New Roman')->setSize(12);
                $sheet->getStyle("C{$currentRow}:AN{$currentRow}")->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

                foreach ($dateColumns as $col) {
                    $sheet->setCellValue("{$col}{$currentRow}", ' ');
                    $sheet->getStyle("{$col}{$currentRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                }

                $dailyBaket = [];
                $totalJam = 0;
                
                foreach ($items as $ts) {
                    $day = (int) date('j', strtotime($ts->tanggal));
                    if (!isset($dateColumns[$day])) continue;
                    
                    if (!isset($dailyBaket[$day])) {
                        $dailyBaket[$day] = 0;
                    }
                    $dailyBaket[$day] += $ts->jam_baket;
                    $totalJam += $ts->jam_baket;
                }

                foreach ($dailyBaket as $day => $jam) {
                    if ($jam > 0) {
                        $sheet->setCellValue("{$dateColumns[$day]}{$currentRow}", $jam);
                        $sheet->getStyle("{$dateColumns[$day]}{$currentRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    }
                }
                $totalKeseluruhanJamBaket += $totalJam;

                $sheet->setCellValue("AL{$currentRow}", $totalJam);
                $sheet->getStyle("AL{$currentRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $totalHarga = $totalJam * $hargaBaket;
                $sheet->mergeCells("AM{$currentRow}:AN{$currentRow}");
                $sheet->setCellValueExplicit("AM{$currentRow}", (int) $totalHarga, DataType::TYPE_NUMERIC);
                $sheet->duplicateStyle($sheet->getStyle("AM{$templateRow}:AN{$templateRow}"), "AM{$currentRow}:AN{$currentRow}");
                $currentRow++;
            }
            
            if (in_array('breker', $jenisPekerjaan)) {
                $brekerRow = $currentRow;
                $onlyBreker = in_array('breker', $jenisPekerjaan) && !in_array('baket', $jenisPekerjaan);

                $sheet->mergeCells("D{$brekerRow}:F{$brekerRow}");
                if ($onlyBreker) {
                    $sheet->setCellValue("C{$brekerRow}", (string) $nomor);
                    $nomor++;
                    $sheet->setCellValue("D{$brekerRow}", date('F Y', strtotime("$ym-01")));
                } else {
                    $sheet->setCellValue("D{$brekerRow}", "Breker");
                }

                $sheet->getStyle("D{$brekerRow}:F{$brekerRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle("C{$brekerRow}:AN{$brekerRow}")->getFont()->setName('Times New Roman')->setSize(12);
                $sheet->getStyle("C{$brekerRow}:AN{$brekerRow}")->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

                foreach ($dateColumns as $col) {
                    $sheet->setCellValue("{$col}{$brekerRow}", ' ');
                    $sheet->getStyle("{$col}{$brekerRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                }

                $dailyBreker = [];
                $totalJam = 0;
                
                foreach ($items as $ts) {
                    $day = (int) date('j', strtotime($ts->tanggal));
                    if (!isset($dateColumns[$day])) continue;
                    
                    if (!isset($dailyBreker[$day])) {
                        $dailyBreker[$day] = 0;
                    }
                    $dailyBreker[$day] += $ts->jam_breker;
                    $totalJam += $ts->jam_breker;
                }

                foreach ($dailyBreker as $day => $jam) {
                    if ($jam > 0) {
                        $sheet->setCellValue("{$dateColumns[$day]}{$brekerRow}", $jam);
                        $sheet->getStyle("{$dateColumns[$day]}{$brekerRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    }
                }
                $totalKeseluruhanJamBreker += $totalJam;

                $sheet->setCellValue("AL{$brekerRow}", $totalJam);
                $sheet->getStyle("AL{$brekerRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $totalHarga = $totalJam * $hargaBreker;
                $sheet->mergeCells("AM{$brekerRow}:AN{$brekerRow}");
                $sheet->setCellValueExplicit("AM{$brekerRow}", (int) $totalHarga, DataType::TYPE_NUMERIC);
                $sheet->getStyle("AM{$brekerRow}:AN{$brekerRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $sheet->getStyle("D{$brekerRow}:AK{$brekerRow}")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('E97F4A');
                $currentRow++;
            }

            $sheet->insertNewRowBefore($currentRow, 1);
            $sheet->duplicateStyle($sheet->getStyle("C{$templateRow}:AN{$templateRow}"), "C{$currentRow}:AN{$currentRow}");
            $sheet->mergeCells("D{$currentRow}:F{$currentRow}");

            foreach (array_merge(['C','D','E','F'], array_values($dateColumns)) as $col) {
                $sheet->setCellValue("{$col}{$currentRow}", "");
            }
            $sheet->setCellValue("AL{$currentRow}", "");
            $sheet->mergeCells("AM{$currentRow}:AN{$currentRow}");
            $sheet->setCellValue("AM{$currentRow}", "");
            $currentRow++;
        }

        // =============================
        // 5. GRAND TOTAL (KIRI BAWAH)
        // =============================
        $totalRow = $currentRow; 
        $sheet->mergeCells("C{$totalRow}:AK{$totalRow}");
        $sheet->setCellValue("C{$totalRow}", "GRAND TOTAL");

        $totalKeseluruhanJam = $totalKeseluruhanJamBaket + $totalKeseluruhanJamBreker;
        $sheet->setCellValue("AL{$totalRow}", $totalKeseluruhanJam);
        $sheet->getStyle("AL{$totalRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->mergeCells("AM{$totalRow}:AN{$totalRow}");
        
        // PERBAIKAN 2: Memasukkan biayaModem dan biayaMobDemob ke total tagihan
        $totalHargaTagihan = ($totalKeseluruhanJamBaket * $hargaBaket) + ($totalKeseluruhanJamBreker * $hargaBreker) + $biayaModem + $biayaMobDemob;
        
        $sheet->setCellValueExplicit("AM{$totalRow}", (int) $totalHargaTagihan, DataType::TYPE_NUMERIC);
        $sheet->getStyle("AM{$totalRow}:AN{$totalRow}")->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle("AM{$totalRow}:AN{$totalRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        
        $sheet->getStyle("C{$totalRow}:AN{$totalRow}")->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle("C{$totalRow}:AN{$totalRow}")->getFont()->setName('Times New Roman')->setSize(12)->setBold(true);

 // ============================================================
        // 6. INFO HARGA SEWA & HM (WARNA DISERAGAMKAN, TEKS HITAM)
        // ============================================================
        $infoRow = $totalRow + 3; 
        $sewaRow = $infoRow; 

        // 1. Cari NILAI HM yang valid (bukan 0)
        $hmAwalValid = $t->timesheets->where('hm_awal', '>', 0)->sortBy('tanggal')->first();
        $hmAkhirValid = $t->timesheets->where('hm_akhir', '>', 0)->sortByDesc('tanggal')->first();
        
        // 2. Cari TANGGAL mentok (Hari pertama dan Hari terakhir log)
        $logPertama = $t->timesheets->sortBy('tanggal')->first();
        $logTerakhir = $t->timesheets->sortByDesc('tanggal')->first();
        
        if ($logPertama && $logTerakhir) {
            // PERBAIKAN FATAL: Tanggal dikunci mati sesuai urutan log harian!
            $tglAwal = $logPertama->tanggal;   // Pasti ambil tanggal log pertama
            $tglAkhir = $logTerakhir->tanggal; // Pasti ambil tanggal log terakhir

            // --- KOTAK HM TERAKHIR (AWAL PROYEK) ---
            $sheet->mergeCells("C{$infoRow}:E{$infoRow}");
            $sheet->setCellValue("C{$infoRow}", "HM Terakhir");
            $sheet->getStyle("C{$infoRow}:F{$infoRow}")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFF2CC');
            $sheet->getStyle("C{$infoRow}:E{$infoRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            
            $infoRow++;
            $sheet->mergeCells("C{$infoRow}:E{$infoRow}");
            // Cetak Tanggal Awal
            $sheet->setCellValue("C{$infoRow}", \Carbon\Carbon::parse($tglAwal)->format('d-m-Y'));
            $sheet->setCellValueExplicit("F{$infoRow}", (int) ($hmAwalValid->hm_awal ?? 0), DataType::TYPE_NUMERIC);
            $sheet->getStyle("C{$infoRow}:F{$infoRow}")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFF2CC');
            $sheet->getStyle("F{$infoRow}")->getFont()->setBold(true);
            $sheet->getStyle("C{$infoRow}:F{$infoRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $infoRow += 2;

            // --- KOTAK HM SEKARANG (AKHIR PROYEK) ---
            $sheet->mergeCells("C{$infoRow}:E{$infoRow}");
            $sheet->setCellValue("C{$infoRow}", "HM Sekarang");
            $sheet->getStyle("C{$infoRow}:F{$infoRow}")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFF2CC');
            $sheet->getStyle("C{$infoRow}:E{$infoRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            
            $infoRow++;
            $sheet->mergeCells("C{$infoRow}:E{$infoRow}");
            // Cetak Tanggal Akhir
            $sheet->setCellValue("C{$infoRow}", \Carbon\Carbon::parse($tglAkhir)->format('d-m-Y'));
            $sheet->setCellValueExplicit("F{$infoRow}", (int) ($hmAkhirValid->hm_akhir ?? 0), DataType::TYPE_NUMERIC);
            $sheet->getStyle("C{$infoRow}:F{$infoRow}")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFF2CC');
            $sheet->getStyle("F{$infoRow}")->getFont()->setBold(true);
            $sheet->getStyle("C{$infoRow}:F{$infoRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        }
        
        // --- KOTAK HARGA SEWA ---
        if (in_array('baket', $jenisPekerjaan)) {
            $sheet->mergeCells("W{$sewaRow}:AB{$sewaRow}");
            $sheet->setCellValue("W{$sewaRow}", "Harga Sewa Baket :");
            $sheet->getStyle("W{$sewaRow}:AB{$sewaRow}")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFF2CC');
            $sheet->getStyle("W{$sewaRow}:AB{$sewaRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            
            // PERBAIKAN 4: Merge kolom sampai AG agar tidak pagar, warna font hitam
            $sheet->mergeCells("AC{$sewaRow}:AG{$sewaRow}");
            $sheet->setCellValueExplicit("AC{$sewaRow}", (int) $hargaBaket, DataType::TYPE_NUMERIC);
            $sheet->getStyle("AC{$sewaRow}")->getNumberFormat()->setFormatCode('"Rp" #,##0');
            $sheet->getStyle("AC{$sewaRow}:AG{$sewaRow}")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFF2CC');
            $sheet->getStyle("AC{$sewaRow}:AG{$sewaRow}")->getFont()->getColor()->setARGB('000000');
            $sheet->getStyle("AC{$sewaRow}:AG{$sewaRow}")->getFont()->setBold(true);
            $sheet->getStyle("AC{$sewaRow}:AG{$sewaRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            
            $sewaRow += 2;
        }

        if (in_array('breker', $jenisPekerjaan)) {
            $sheet->mergeCells("W{$sewaRow}:AB{$sewaRow}");
            $sheet->setCellValue("W{$sewaRow}", "Harga Sewa Breker :");
            $sheet->getStyle("W{$sewaRow}:AB{$sewaRow}")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('E97F4A');
            $sheet->getStyle("W{$sewaRow}:AB{$sewaRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            
            // PERBAIKAN 4: Merge kolom sampai AG agar tidak pagar, warna font hitam
            $sheet->mergeCells("AC{$sewaRow}:AG{$sewaRow}");
            $sheet->setCellValueExplicit("AC{$sewaRow}", (int) $hargaBreker, DataType::TYPE_NUMERIC);
            $sheet->getStyle("AC{$sewaRow}")->getNumberFormat()->setFormatCode('"Rp" #,##0');
            $sheet->getStyle("AC{$sewaRow}:AG{$sewaRow}")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('E97F4A');
            $sheet->getStyle("AC{$sewaRow}:AG{$sewaRow}")->getFont()->getColor()->setARGB('000000');
            $sheet->getStyle("AC{$sewaRow}:AG{$sewaRow}")->getFont()->setBold(true);
            $sheet->getStyle("AC{$sewaRow}:AG{$sewaRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        }

        // ============================================================
        // 7. LOGIKA FOOTER SELISIH DINAMIS & WARNA (KANAN BAWAH)
        // ============================================================
        $barisKiriBawah = max($infoRow, $sewaRow); 
        $barisTerpanjang = max($barisKiriBawah, $dpRow); 
        $footerRow = $barisTerpanjang + 2;

        $totalTerbayar = $dpList->sum('jumlah');
        $selisih = $totalHargaTagihan - $totalTerbayar;

        $sheet->mergeCells("AQ{$footerRow}:AR{$footerRow}");
        $sheet->setCellValue("AQ{$footerRow}", "Total Terbayar:");
        $sheet->getStyle("AQ{$footerRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        
        $sheet->mergeCells("AS{$footerRow}:AT{$footerRow}");
        $sheet->setCellValueExplicit("AS{$footerRow}", (int) $totalTerbayar, DataType::TYPE_NUMERIC);
        $sheet->getStyle("AS{$footerRow}:AT{$footerRow}")->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle("AQ{$footerRow}:AT{$footerRow}")->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THICK);
        
        $footerRow++;

        $sheet->mergeCells("AQ{$footerRow}:AR{$footerRow}");
        $sheet->setCellValue("AQ{$footerRow}", "Sisa Tagihan / Selisih:");
        $sheet->getStyle("AQ{$footerRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        
        $sheet->mergeCells("AS{$footerRow}:AT{$footerRow}");
        $sheet->setCellValueExplicit("AS{$footerRow}", (int) $selisih, DataType::TYPE_NUMERIC);
        $sheet->getStyle("AS{$footerRow}:AT{$footerRow}")->getNumberFormat()->setFormatCode('#,##0');

        $sheet->getStyle("AQ{$footerRow}:AT{$footerRow}")->getFont()->setName('Times New Roman')->setSize(12)->setBold(true);
        $sheet->getStyle("AQ{$footerRow}:AT{$footerRow}")->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        if ($selisih > 0) {
            $sheet->getStyle("AQ{$footerRow}:AT{$footerRow}")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFC7CE');
            $sheet->getStyle("AQ{$footerRow}:AT{$footerRow}")->getFont()->getColor()->setARGB('9C0006');
        } elseif ($selisih == 0) {
            $sheet->getStyle("AQ{$footerRow}:AT{$footerRow}")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('C6EFCE');
            $sheet->getStyle("AQ{$footerRow}:AT{$footerRow}")->getFont()->getColor()->setARGB('006100');
        } else {
            $sheet->getStyle("AQ{$footerRow}:AT{$footerRow}")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFEB9C');
            $sheet->getStyle("AQ{$footerRow}:AT{$footerRow}")->getFont()->getColor()->setARGB('9C6500');
        }

        // =============================
        // 8. OUTPUT FILE FINAL
        // =============================
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $namaPelanggan = str_replace(' ', '_', $t->pelanggan->nama ?? 'Client');

        return new StreamedResponse(function () use ($writer) {
            $writer->save('php://output');
        }, 200, [
            "Content-Type"        => "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
            "Content-Disposition" => "attachment; filename=\"Timesheet_{$namaPelanggan}.xlsx\"",
        ]);
    }
}