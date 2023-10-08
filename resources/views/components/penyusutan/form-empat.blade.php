<form action="{{ route($route . '.store-empat') }}" method="post">
    @csrf
    <div class="card-body">
        <div class="card shadow-none bg-transparent border border-info mb-3">
            <div class="card-body">
                <div class="row mb-3">
                    <h5 class="card-title mb-0">Step - 4</h5><small class="text-info">Simpan Transaksi Penyusutan.</small>
                </div>
                <div class="row mt-3">
                    <h5 class="text-capitalize text-success">Detil Penyusutan</h5>
                </div>
                <div class="row mb-2 pb-1">
                    <div class="col-lg-5 col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td>Tanggal Transaksi</td>
                                <td style="text-align: right" class="text-dark">{{ $tanggal }}</td>
                            </tr>
                            <tr>
                                <td>Jenis Transaksi</td>
                                <td class="text-capitalize text-dark" style="text-align: right">{{ $tipe }}</td>
                            </tr>
                            @if (isset($invoicepny))
                                <tr>
                                    <td>No. Transaksi Penyesuaian</td>
                                    <td class="text-capitalize text-dark" style="text-align: right">#{{ $invoicepny }}
                                    </td>
                                </tr>
                            @endif
                        </table>
                    </div>
                </div>
                <div style="padding-bottom: 1rem;border-bottom: 1px solid #E5E5E5;"></div>
                @if (isset($invoicepny))
                    <div class="row mb-2 pb-1">
                        <input type="hidden" class="invoicePenyesuaian" name="id_penyusutan_penyesuaian"
                            value="{{ $idpenyesuaian }}" />
                        <input type="hidden" id="route-penyesuaian" data-route="{{ route($routepny) }}" />
                        <input type="hidden" name="invoice_penyesuaian" value="{{ $invoicepny }}" />
                        <div class="col-lg-3 col-sm-12 text-uppercase text-dark" style="text-align: right">
                            <button class="btn btn-light btn-pinned text-info" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseDetailPenyesuaianPenyusutan" aria-expanded="false"
                                aria-controls="collapseDetailPenyesuaianPenyusutan" title="Lihat Detail">
                                {{ $invoicepny }} <i class='bx bx-info-circle'></i>
                            </button>
                        </div>
                    </div>
                    <div class="row pb-1">
                        <div class="collapse" id="collapseDetailPenyesuaianPenyusutan">
                            <div class="d-flex p-3 border">
                                <span>
                                    <div class="detailPenyusutan"></div>
                                </span>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="row mt-3 bg-footer-theme">
                    <div class="row mt-3">
                        <label class="form-label text-dark">Detil Transaksi
                            {{ $tipe == 'penyesuaian' ? 'Penyesuaian' : '' }} :</label>
                        <div class="table-responsive text-nowrap pb-3">
                            <table class="table table-bordered table-hover">
                                <thead class=" table-success">
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama</th>
                                        <th>Unit</th>
                                        <th>Nilai Buku Sekarang</th>
                                        <th>Nilai Penyusutan</th>
                                        <th>Qty</th>
                                        <th>Total Penyusutan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                        $total = 0;
                                    @endphp
                                    @foreach ($detail as $d)
                                        @php
                                            $total += $d['total'];
                                        @endphp
                                        @if ($d['status'] == 'S')
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>{{ $d['nama'] }}</td>
                                                <td>{{ $d['unit'] }}</td>
                                                <td style="text-align: right">{{ cek_uang($d['nilai_buku_s']) }}</td>
                                                <td style="text-align: right">{{ cek_uang($d['nilai_penyusutan']) }}
                                                </td>
                                                <td style="text-align: right">{{ $d['stok'] }} {{ $d['satuan'] }}
                                                </td>
                                                <td style="text-align: right">{{ cek_uang($d['subtotal']) }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>{{ $d['nama'] }} (Eceran)</td>
                                                <td>{{ $d['unit'] }}</td>
                                                <td style="text-align: right">{{ cek_uang($d['nilai_buku_se']) }}</td>
                                                <td style="text-align: right">{{ cek_uang($d['nilai_penyusutan_e']) }}
                                                </td>
                                                <td style="text-align: right">{{ $d['stok_e'] }} {{ $d['satuan_e'] }}
                                                </td>
                                                <td style="text-align: right">{{ cek_uang($d['subtotal_e']) }}</td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>{{ $d['nama'] }}</td>
                                                <td>{{ $d['unit'] }}</td>
                                                <td style="text-align: right">{{ cek_uang($d['nilai_buku_s']) }}</td>
                                                <td style="text-align: right">{{ cek_uang($d['nilai_penyusutan']) }}
                                                </td>
                                                <td style="text-align: right">{{ $d['stok'] }} {{ $d['satuan'] }}
                                                </td>
                                                <td style="text-align: right">{{ cek_uang($d['subtotal']) }}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="6">
                                            <h5><b>Total</b></h5>
                                        </td>
                                        <td style="text-align: right">
                                            <h5><b>{{ cek_uang($total) }}</b></h5>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <label class="form-label text-dark">Detil Jurnal
                            {{ $tipe == 'penyesuaian' ? 'Penyesuaian' : '' }}
                            :</label>
                        <div class="table-responsive text-nowrap pb-4">
                            <table class="table table-bordered table-hover">
                                <thead class="table-success">
                                    <tr>
                                        <th>Rekening</th>
                                        <th>Ref</th>
                                        <th>Debet</th>
                                        <th>Kredit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($jurnalpny))
                                        <input type="hidden" name="jurnalpny" value="{{ json_encode($jurnalpny) }}" />
                                        @foreach ($jurnalpny as $item)
                                            <tr>
                                                @if ($item->posisi_dr_cr == 'kredit')
                                                    <td>{{ $item->coa->nama }}</td>
                                                @else
                                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $item->coa->nama }}
                                                    </td>
                                                @endif
                                                <td>{{ $item->coa->kode }}</td>
                                                <td
                                                    style="text-align:{{ $item->posisi_dr_cr == 'kredit' ? 'right' : 'center' }}">
                                                    {{ $item->posisi_dr_cr == 'kredit' ? buatrp($item->nominal) : '-' }}
                                                </td>
                                                <td
                                                    style="text-align:{{ $item->posisi_dr_cr == 'debet' ? 'right' : 'center' }}">
                                                    {{ $item->posisi_dr_cr == 'debet' ? buatrp($item->nominal) : '-' }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    @foreach ($jurnal as $j)
                                        <tr>
                                            <td>{{ $j['debet'] }}</td>
                                            <td>{{ $j['kode_debet'] }}</td>
                                            <td style="text-align:right">{{ buatrp($j['nominal']) }}</td>
                                            <td style="text-align:center">-</td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $j['kredit'] }}
                                            </td>
                                            <td>{{ $j['kode_kredit'] }}</td>
                                            <td style="text-align:center">-</td>
                                            <td style="text-align:right">{{ buatrp($j['nominal']) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <input type="hidden" name="tgl_transaksi" value="{{ $tanggal }}" />
                    <input type="hidden" name="cek_penyusutan" value="{{ $tipe }}" />
                    <input type="hidden" name="detail" value="{{ json_encode($detail) }}" />
                    <input type="hidden" name="jurnal" value="{{ json_encode($jurnal) }}" />
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <div class="row">
            <div class="col-12 d-flex justify-content-end">
                <a href="{{ route($route . '.step-tiga', ['data' => $dataprev]) }}" type="button"
                    class="btn btn-outline-secondary">kembali</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</form>
