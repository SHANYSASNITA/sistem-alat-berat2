<?php

namespace App\Exports;

use App\Models\TransaksiSewa;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Symfony\Component\HttpFoundation\StreamedResponse;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;


class TimesheetTemplateExport
{
    public function export($transaksiId)
    {
        // Load template
        $spreadsheet = IOFactory::load(
            storage_path('app/templates/timesheet_template.xlsx')
        );
        $sheet = $spreadsheet->getActiveSheet();

        // Ambil data transaksi
        $t = TransaksiSewa::with([
            'pelanggan',
            'operator',
            'timesheets',
            'hmLogs',
            'dpPembayaran' => function($q) {
                $q->orderBy('tanggal', 'asc'); // order by tanggal bener-benar dari DB
            }
        ])->find($transaksiId);


        $hargaBaket = $t->harga_sewa_baket ?? 0;
        $hargaBreker = $t->harga_sewa_breker ?? 0;

                // =============================
        // PATCH: NORMALIZE JENIS PEKERJAAN (JSON / STRING)
        // =============================
        $jenisPekerjaan = $t->jenis_pekerjaan;

        if (is_string($jenisPekerjaan)) {
            $decoded = json_decode($jenisPekerjaan, true);
            $jenisPekerjaan = is_array($decoded) ? $decoded : [$jenisPekerjaan];
        }

        $jenisPekerjaan = array_map('strtolower', $jenisPekerjaan);

        // =============================
        // HEADER
        // =============================
        $sheet->setCellValue('G9',  $t->pelanggan->nama ?? '-');
        $sheet->setCellValue('G10', $t->operator->nama ?? '-');
        $sheet->setCellValue('G11', $t->tanggal_mulai . ' - ' . $t->tanggal_selesai);
        $sheet->setCellValue('G12',  $t->jenis_sewa ?? '-');
        $sheet->setCellValue('D19', 'Operator ' . $t->operator->nama ?? '-');
        $hmTerbaru = $t->hmLogs?->sortByDesc('created_at')->first();    
        $sheet->setCellValue('G30', $hmTerbaru->hm_terkahir ?? '-');
        $sheet->setCellValue('G33', $hmTerbaru->hm_sekarang ?? '-');
        $sheet->setCellValue('C30', $hmTerbaru->tanggal_terakhir ?? '-');
        $sheet->setCellValue('C33', $hmTerbaru->tanggal_sekarang ?? '-');
        $sheet->setCellValue('G16', $t->mobilisasi . ' - ' . $t->demobilisasi ?? '-');
        $sheet->mergeCells("AM16:AN16");
        $sheet->setCellValue('AM16', $t->biaya_modem ?? '0');
        // $sheet->setCellValue('AB29', implode(', ', $jenisPekerjaan));

        $jenis = $jenisPekerjaan; // sudah dinormalisasi

        $adaBaket  = in_array('baket', $jenis);
        $adaBreker = in_array('breker', $jenis);

        $row = 29;

        /**
         * =========================
         * BAKET + BREKER
         * =========================
         */
        if ($adaBaket && $adaBreker) {

            // ===== BAKET =====
            $sheet->setCellValue("AB{$row}", "Baket");
            $sheet->setCellValueExplicit(
                "AD{$row}",
                (int) $hargaBaket,
                DataType::TYPE_NUMERIC
            );

            $sheet->getStyle("AD{$row}")
                ->getNumberFormat()
                ->setFormatCode('#,##0_);(#,##0)');

            $sheet->getStyle("AD{$row}")
                ->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_RIGHT);

            // Copy style ke baris bawah
            $sheet->duplicateStyle(
                $sheet->getStyle("AB{$row}:AG{$row}"),
                "AB" . ($row + 1) . ":AG" . ($row + 1)
            );

            $sheet->mergeCells("AB" . ($row + 1) . ":AC" . ($row + 1));
            $sheet->mergeCells("AD" . ($row + 1) . ":AG" . ($row + 1));

            // ===== BREKER =====
            $sheet->setCellValue("AB" . ($row + 1), "Breker");
            $sheet->setCellValueExplicit(
                "AD" . ($row + 1),
                (int) $hargaBreker,
                DataType::TYPE_NUMERIC
            );

            $sheet->getStyle("AD" . ($row + 1))
                ->getNumberFormat()
                ->setFormatCode('#,##0_);(#,##0)');

            $sheet->getStyle("AD" . ($row + 1))
                ->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        }

        /**
         * =========================
         * BAKET SAJA
         * =========================
         */
        elseif ($adaBaket) {

            $sheet->setCellValue("AB{$row}", "Baket");
            $sheet->setCellValueExplicit(
                "AD{$row}",
                (int) $hargaBaket,
                DataType::TYPE_NUMERIC
            );

            $sheet->getStyle("AD{$row}")
                ->getNumberFormat()
                ->setFormatCode('#,##0_);(#,##0)');

            $sheet->getStyle("AD{$row}")
                ->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        }

        /**
         * =========================
         * BREKER SAJA
         * =========================
         */
        elseif ($adaBreker) {

            $sheet->setCellValue("AB{$row}", "Breker");
            $sheet->setCellValueExplicit(
                "AD{$row}",
                (int) $hargaBreker,
                DataType::TYPE_NUMERIC
            );

            $sheet->getStyle("AD{$row}")
                ->getNumberFormat()
                ->setFormatCode('#,##0_);(#,##0)');

            $sheet->getStyle("AD{$row}")
                ->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        }


        // =============================
        // DP PEMBAYARAN (List DP)
        // =============================

        $dpList = $t->dpPembayaran;
        $dpRow = 15;
        $templateDpRow = 15;

        foreach ($dpList as $i => $dp) {

            if ($dpRow != $templateDpRow) {

                // 🔑 COPY STYLE FULL BARIS DP
                $sheet->duplicateStyle(
                    $sheet->getStyle("AQ{$templateDpRow}:AT{$templateDpRow}"),
                    "AQ{$dpRow}:AT{$dpRow}"
                );

                // 🔑 WAJIB merge ulang
                $sheet->mergeCells("AS{$dpRow}:AT{$dpRow}");
            }

            // Nomor urut → AQ
            $sheet->setCellValueExplicit(
                "AQ{$dpRow}",
                (string) ($i + 1),
                DataType::TYPE_STRING
            );

            // Tanggal → AR
            $sheet->setCellValue(
                "AR{$dpRow}",
                date('d-m-Y', strtotime($dp->tanggal))
            );

            // DP → AS–AT
            $sheet->mergeCells("AS{$dpRow}:AT{$dpRow}");

            $sheet->setCellValueExplicit(
                "AS{$dpRow}",
                (int) $dp->jumlah,
                DataType::TYPE_NUMERIC
            );

            // COPY FORMAT DARI TEMPLATE
            $sheet->duplicateStyle(
                $sheet->getStyle("AS{$templateDpRow}:AT{$templateDpRow}"),
                "AS{$dpRow}:AT{$dpRow}"
            );

            $dpRow++;
        }


        // =============================
        // GROUP TIMESHEET PER BULAN
        // =============================
        $grouped = $t->timesheets->groupBy(function ($ts) {
            return date('Y-m', strtotime($ts->tanggal));
        });

        $templateRow = 20;
        $currentRow  = 20;
        $nomor       = 1;

        $totalKeseluruhanJamBaket = 0;
        $totalKeseluruhanJamBreker = 0;

        // Kolom tanggal
        $dateColumns = [
            1=>'G',2=>'H',3=>'I',4=>'J',5=>'K',6=>'L',7=>'M',8=>'N',9=>'O',10=>'P',
            11=>'Q',12=>'R',13=>'S',14=>'T',15=>'U',16=>'V',17=>'W',18=>'X',
            19=>'Y',20=>'Z',21=>'AA',22=>'AB',23=>'AC',24=>'AD',25=>'AE',
            26=>'AF',27=>'AG',28=>'AH',29=>'AI',30=>'AJ',31=>'AK'
        ];

        $colTotalJam       = 'AL';
        $colHargaStart     = 'AM';
        $colHargaEnd       = 'AN';

        // =============================
        // LOOP PER BULAN
        // =============================
        // =============================
        // LOOP PER BULAN
        // =============================
        foreach ($grouped as $ym => $items) {

            if ($currentRow != $templateRow) {

                // 1️⃣ Insert row baru
                $sheet->insertNewRowBefore($currentRow, 1);

                // 2️⃣ Copy style FULL dari template
                $sheet->duplicateStyle(
                    $sheet->getStyle("C{$templateRow}:AN{$templateRow}"),
                    "C{$currentRow}:AN{$currentRow}"
                );

                // 3️⃣ WAJIB ulang merge kolom harga
                $sheet->mergeCells("AM{$currentRow}:AN{$currentRow}");
            }


            if (in_array('baket', $jenisPekerjaan)) {

                // Nomor urut (C)
                $sheet->setCellValue("C{$currentRow}", $nomor);
                $nomor++;

                // Merge bulan D–F
                $sheet->mergeCells("D{$currentRow}:F{$currentRow}");
                $sheet->setCellValue("D{$currentRow}", date('F Y', strtotime("$ym-01")));

                $sheet->getStyle("D{$currentRow}:F{$currentRow}")
                    ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // Style font + border
                $sheet->getStyle("C{$currentRow}:AN{$currentRow}")
                    ->getFont()->setName('Times New Roman')->setSize(12);

                $sheet->getStyle("C{$currentRow}:AN{$currentRow}")
                    ->getBorders()->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN);

                // Kosongkan tanggal (G–AK)
                foreach ($dateColumns as $col) {
                    $sheet->setCellValue("{$col}{$currentRow}", ' ');
                    $sheet->getStyle("{$col}{$currentRow}")
                        ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                }

                // Hitung jam per hari
                $totalJam = 0;
                foreach ($items as $ts) {
                    $day = (int) date('j', strtotime($ts->tanggal));
                    if (!isset($dateColumns[$day])) continue;

                    $totalJam += $ts->jam_baket;

                    $sheet->setCellValue("{$dateColumns[$day]}{$currentRow}", $ts->jam_baket);
                    $sheet->getStyle("{$dateColumns[$day]}{$currentRow}")
                        ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                }

                // SUM ke jam total keseluruhan
                $totalKeseluruhanJamBaket += $totalJam;

                // Total Jam (AL)
                $sheet->setCellValue("{$colTotalJam}{$currentRow}", $totalJam);
                $sheet->getStyle("{$colTotalJam}{$currentRow}")
                    ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // ===============================
                // TOTAL HARGA (AM–AN) – ACCOUNTING AMAN
                // ===============================
                $totalHarga = $totalJam * $hargaBaket;

                // 1️⃣ MERGE dulu
                $sheet->mergeCells("{$colHargaStart}{$currentRow}:{$colHargaEnd}{$currentRow}");

                // 2️⃣ SET VALUE numeric
                $sheet->setCellValueExplicit(
                    "{$colHargaStart}{$currentRow}",
                    (int) $totalHarga,
                    \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC
                );

                // 3️⃣ COPY ACCOUNTING FORMAT DARI TEMPLATE
                $sheet->duplicateStyle(
                    $sheet->getStyle("{$colHargaStart}{$templateRow}:{$colHargaEnd}{$templateRow}"),
                    "{$colHargaStart}{$currentRow}:{$colHargaEnd}{$currentRow}"
                );

                $currentRow++;

            }
            
            // =======================================
            // TAMBAH BARIS breker
            // =======================================


            if (in_array('breker', $jenisPekerjaan)) {

                $brekerRow = $currentRow;

                $onlyBreker = in_array('breker', $jenisPekerjaan)
                        && !in_array('baket', $jenisPekerjaan);

                // Merge D–F
                $sheet->mergeCells("D{$brekerRow}:F{$brekerRow}");
                if ($onlyBreker) {
                    $sheet->setCellValue("C{$brekerRow}", (string) $nomor);
                    $nomor++;
                    $sheet->setCellValue("D{$brekerRow}", date('F Y', strtotime("$ym-01")));
                } else {
                    $sheet->setCellValue("D{$brekerRow}", "Breker");
                }

                $sheet->getStyle("D{$brekerRow}:F{$brekerRow}")
                    ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // Style font + border
                $sheet->getStyle("C{$brekerRow}:AN{$brekerRow}")
                    ->getFont()->setName('Times New Roman')->setSize(12);

                $sheet->getStyle("C{$brekerRow}:AN{$brekerRow}")
                    ->getBorders()->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN);

                // Kosongkan G–AK
                foreach ($dateColumns as $col) {
                    $sheet->setCellValue("{$col}{$brekerRow}", ' ');
                    $sheet->getStyle("{$col}{$brekerRow}")
                        ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                }

                // Hitung jam per hari
                $totalJam = 0;
                foreach ($items as $ts) {
                    $day = (int) date('j', strtotime($ts->tanggal));
                    if (!isset($dateColumns[$day])) continue;

                    $totalJam += $ts->jam_breker;

                    $sheet->setCellValue("{$dateColumns[$day]}{$brekerRow}", $ts->jam_breker);
                    $sheet->getStyle("{$dateColumns[$day]}{$brekerRow}")
                        ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                }

                $totalKeseluruhanJamBreker += $totalJam;

                // Total Jam (AL)
                $sheet->setCellValue("{$colTotalJam}{$brekerRow}", $totalJam);
                $sheet->getStyle("{$colTotalJam}{$brekerRow}")
                    ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // Total Harga (AM–AN)
                $totalHarga = $totalJam * $hargaBreker;

                $sheet->mergeCells("{$colHargaStart}{$brekerRow}:{$colHargaEnd}{$brekerRow}");
                $sheet->setCellValue("{$colHargaStart}{$brekerRow}", $totalHarga);

                $sheet->getStyle("{$colHargaStart}{$brekerRow}:{$colHargaEnd}{$brekerRow}")
                    ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // ---------------------------------------
                // SET BACKGROUND WARNA E97F4A
                // ---------------------------------------
                $sheet->getStyle("D{$brekerRow}:AK{$brekerRow}")
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('E97F4A');

                // Pindah row turun
                $currentRow++;

            }


            // ============================================================
            // TAMBAH BARIS SPACER (KOSONG) BIAR TIDAK RAPAT
            // ============================================================

            // Insert row baru
            $sheet->insertNewRowBefore($currentRow, 1);

            $sheet->duplicateStyle(
                $sheet->getStyle("C{$templateRow}:AN{$templateRow}"),
                "C{$currentRow}:AN{$currentRow}"
            );

            // Merge D–F (kosong)
            $sheet->mergeCells("D{$currentRow}:F{$currentRow}");

            // Kosongkan semua kolom
            foreach (array_merge(['C','D','E','F'], array_values($dateColumns)) as $col) {
                $sheet->setCellValue("{$col}{$currentRow}", "");
            }

            // Kolom AL, AM, AN kosong
            $sheet->setCellValue("AL{$currentRow}", "");
            $sheet->mergeCells("AM{$currentRow}:AN{$currentRow}");
            $sheet->setCellValue("AM{$currentRow}", "");

            $currentRow++;

        }


        // ============================================================
        // ROW TOTAL (Dinamis Setelah Bulan Terakhir)
        // ============================================================
        $totalRow = $currentRow; // otomatis tepat di bawah bulan terakhir

        // $sheet->unmergeCells("D{$totalRow}:F{$totalRow}");
        $sheet->mergeCells("C{$totalRow}:AK{$totalRow}");
        $sheet->setCellValue("C{$totalRow}", "GRAND TOTAL");
                    // $sheet->setCellValue("Grand Total");

        $totalKeseluruhanJam = $totalKeseluruhanJamBaket + $totalKeseluruhanJamBreker;

            // Total Jam keseluruhan → AL
        $sheet->setCellValue("AL{$totalRow}", $totalKeseluruhanJam);
        $sheet->getStyle("AL{$totalRow}")
            ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Merge & isi total harga → AM–AN
        $sheet->mergeCells("AM{$totalRow}:AN{$totalRow}");

        // $totalHargaKeseluruhan = $totalKeseluruhanJam * $hargaBaket;
        $totalHargaKeseluruhan =
            ($totalKeseluruhanJamBaket  * $hargaBaket)
        + ($totalKeseluruhanJamBreker * $hargaBreker)
        + $t->biaya_modem;

        $sheet->setCellValue(
            "AM{$totalRow}",
            $totalHargaKeseluruhan
        );

        // $sheet->setCellValue(
        //     "AM{$totalRow}", $totalHargaKeseluruhan + $t->biaya_modem
        // );

        $sheet->getStyle("AM{$totalRow}:AN{$totalRow}")
            ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Border
        $sheet->getStyle("C{$totalRow}:AN{$totalRow}")
            ->getBorders()->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

        // Font konsisten
        $sheet->getStyle("C{$totalRow}:AN{$totalRow}")
            ->getFont()->setName('Times New Roman')->setSize(12)->setBold(true);


        // =============================
        // OUTPUT FILE
        // =============================
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');

        return new StreamedResponse(function () use ($writer) {
            $writer->save('php://output');
        }, 200, [
            "Content-Type"        => "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
            "Content-Disposition" => "attachment; filename=\"timesheet.xlsx\"",
        ]);
    }
}
