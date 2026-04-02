<!-- <table>
    <tr>
        <td colspan="35" align="center" style="background-color: #8faadc; font-weight: bold; font-size: 14px; border: 1px solid black;">
            TIME SHEETS
        </td>
    </tr>
    
    <tr>
        <td colspan="2">Nama</td>
        <td colspan="10">: {{ $transaksi->pelanggan->nama_pelanggan ?? '-' }}</td>
    </tr>
    <tr>
        <td colspan="2">Nama Operator</td>
        <td colspan="10">: {{ $transaksi->operator->nama_operator ?? '-' }}</td>
    </tr>
    <tr>
        <td colspan="2">Priode Operasi</td>
        <td colspan="10">: {{ $transaksi->tanggal_mulai ? $transaksi->tanggal_mulai->format('M-y') : '-' }}</td>
    </tr>
    <tr>
        <td colspan="2">Jenis Sewa</td>
        <td colspan="10">: {{ $transaksi->jenis_sewa ?? '-' }}</td>
    </tr>
    
    <tr></tr> <tr>
        <td rowspan="2" align="center" style="border: 1px solid black; font-weight: bold; vertical-align: middle; width: 40px;">No</td>
        <td rowspan="2" align="center" style="border: 1px solid black; font-weight: bold; vertical-align: middle; width: 150px;">Keterangan</td>
        
        @for ($i = 1; $i <= 31; $i++)
            <td align="center" style="border: 1px solid black; font-weight: bold; width: 25px;">{{ $i }}</td>
        @endfor
        
        <td rowspan="2" align="center" style="border: 1px solid black; font-weight: bold; vertical-align: middle; width: 80px;">Total Jam</td>
        <td rowspan="2" align="center" style="border: 1px solid black; font-weight: bold; vertical-align: middle; width: 120px;">Harga Sewa</td>
        
        <td width="20px"></td> <td colspan="3" style="font-weight: bold; width: 250px;">Dp Sewa alat:</td>
    </tr>
    <tr>
        @for ($i = 1; $i <= 31; $i++)
            <td style="border: 1px solid black;"></td>
        @endfor
        <td></td>
        <td style="border-bottom: 1px solid black; font-weight:bold;">Tanggal</td>
        <td style="border-bottom: 1px solid black; font-weight:bold;" align="right">Nominal</td>
    </tr>

    <tr>
        <td style="border: 1px solid black;"></td>
        <td align="center" style="border: 1px solid black;">Mob - Demob</td>
        @for ($i = 1; $i <= 31; $i++) <td style="border: 1px solid black;"></td> @endfor
        <td style="border: 1px solid black;"></td>
        <td style="border: 1px solid black;"></td>
        
        <td></td>
        <td>{{ isset($transaksi->dpPembayaran[0]) ? $transaksi->dpPembayaran[0]->created_at->format('d-M-y') : '' }}</td>
        <td align="right">{{ isset($transaksi->dpPembayaran[0]) ? 'Rp ' . number_format($transaksi->dpPembayaran[0]->jumlah_dp, 0, ',', '.') : '' }}</td>
    </tr>

    <tr>
        <td style="border: 1px solid black;"></td>
        <td style="border: 1px solid black; background-color: #fff2cc; font-weight: bold;">Operator {{ $transaksi->operator->nama_operator ?? '-' }}</td>
        @for ($i = 1; $i <= 31; $i++) <td style="border: 1px solid black;"></td> @endfor
        <td style="border: 1px solid black;"></td>
        <td style="border: 1px solid black;"></td>
        
        <td></td>
        <td>{{ isset($transaksi->dpPembayaran[1]) ? $transaksi->dpPembayaran[1]->created_at->format('d-M-y') : '' }}</td>
        <td align="right">{{ isset($transaksi->dpPembayaran[1]) ? 'Rp ' . number_format($transaksi->dpPembayaran[1]->jumlah_dp, 0, ',', '.') : '' }}</td>
    </tr>
    <tr>
        <td align="center" style="border: 1px solid black;">1</td>
        <td align="center" style="border: 1px solid black;">{{ $transaksi->tanggal_mulai ? $transaksi->tanggal_mulai->format('F-y') : 'Bulan' }}</td>
        
        @for ($i = 1; $i <= 31; $i++)
            <td align="center" style="border: 1px solid black;">{{ $jamBaket[$i] ?? '' }}</td>
        @endfor

        <td align="center" style="border: 1px solid black; font-weight:bold;">{{ array_sum($jamBaket) }}</td>
        <td align="right" style="border: 1px solid black; font-weight:bold;">Rp {{ number_format(array_sum($jamBaket) * $transaksi->harga_sewa_baket, 0, ',', '.') }}</td>
    </tr>

    <tr>
        <td style="border: 1px solid black;"></td>
        <td style="border: 1px solid black; background-color: #fce4d6; font-weight: bold;">Breker</td>
        @for ($i = 1; $i <= 31; $i++) <td style="border: 1px solid black;"></td> @endfor
        <td style="border: 1px solid black;"></td>
        <td style="border: 1px solid black;"></td>
    </tr>
    <tr>
        <td align="center" style="border: 1px solid black;">2</td>
        <td align="center" style="border: 1px solid black;">{{ $transaksi->tanggal_mulai ? $transaksi->tanggal_mulai->format('F-y') : 'Bulan' }}</td>
        
        @for ($i = 1; $i <= 31; $i++)
            <td align="center" style="border: 1px solid black;">{{ $jamBreker[$i] ?? '' }}</td>
        @endfor

        <td align="center" style="border: 1px solid black; font-weight:bold;">{{ array_sum($jamBreker) }}</td>
        <td align="right" style="border: 1px solid black; font-weight:bold;">Rp {{ number_format(array_sum($jamBreker) * $transaksi->harga_sewa_breker, 0, ',', '.') }}</td>
    </tr>

    <tr>
        <td colspan="2" align="center" style="border: 1px solid black; font-weight: bold;">GRAND TOTAL</td>
        @for ($i = 1; $i <= 31; $i++) <td style="border: 1px solid black;"></td> @endfor
        
        @php
            $totalJamKeseluruhan = array_sum($jamBaket) + array_sum($jamBreker);
            $totalHargaKeseluruhan = (array_sum($jamBaket) * $transaksi->harga_sewa_baket) + (array_sum($jamBreker) * $transaksi->harga_sewa_breker);
            $totalDp = $transaksi->dpPembayaran->sum('jumlah_dp');
        @endphp

        <td align="center" style="border: 1px solid black; font-weight: bold;">{{ $totalJamKeseluruhan }}</td>
        <td align="right" style="border: 1px solid black; font-weight: bold;">Rp {{ number_format($totalHargaKeseluruhan, 0, ',', '.') }}</td>
        
        <td></td> 
        <td style="border-top: 2px solid black; font-weight: bold;">Total:</td>
        <td align="right" style="border-top: 2px solid black; font-weight: bold;">Rp {{ number_format($totalDp, 0, ',', '.') }}</td>
    </tr>

    <tr></tr> <tr>
        <td colspan="15"></td>
        <td colspan="4" align="right">Harga Sewa :</td>
        <td colspan="3">Baket</td>
        <td align="right">{{ number_format($transaksi->harga_sewa_baket, 0, ',', '.') }}</td>
    </tr>
    <tr>
        <td colspan="15"></td>
        <td colspan="4"></td>
        <td colspan="3">Breker</td>
        <td align="right">{{ number_format($transaksi->harga_sewa_breker, 0, ',', '.') }}</td>
        
        <td colspan="9"></td>
        <td style="background-color: #ffc000; font-weight: bold;">Sisa bon :</td>
        <td align="right" style="background-color: #ffc000; font-weight: bold;">Rp {{ number_format($totalHargaKeseluruhan - $totalDp, 0, ',', '.') }}</td>
    </tr>

</table> -->