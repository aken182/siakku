<div class="modal fade" id="modalScrollable" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-capitalize" id="modalScrollableTitle">Estimasi SHU Unit {{ $unit }}
                    per -
                    {{ date('d') . ' ' . bulan_indonesia(date('m')) . ' ' . date('Y') }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-lg-4">
                            <label class="text-dark mb-2"><b>Grafik Estimasi SHU</b></label>
                            <input type="hidden" id="chart-route" data-route="{{ route($route) }}" />
                            <input type="hidden" id="unit" data-unit="{{ $unit }}" />
                            <div id="chart-estimasi"></div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-lg-8">
                            <label class="text-dark mb-2"><b>Tabel Estimasi SHU</b></label>
                            <small>
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered">
                                        <thead class="table-dark text-light">
                                            <tr>
                                                <th style="text-align: center">No.</th>
                                                <th style="text-align: center">Nama Dana</th>
                                                <th style="text-align: center">Persentase SHU</th>
                                                <th style="text-align: center">Jumlah Alokasi</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-dark">
                                            @php
                                                $no = 0;
                                            @endphp
                                            @foreach ($estimasi['dana'] as $item)
                                                <tr>
                                                    <td style="text-align: center">{{ $no += 1 }}.</td>
                                                    <td>{{ $item['nama'] }}</td>
                                                    <td style="text-align: center">{{ $item['persentase'] }}</td>
                                                    <td style="text-align: right">
                                                        {{ buatrpDecimal($item['jumlah_alokasi']) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot class="table-dark text-light">
                                            <tr>
                                                <td colspan="2"><b>Estimasi Sisa Hasil Usaha ( SHU )</b></td>
                                                <td style="text-align: center"><b>100 %</b></td>
                                                <td style="text-align: right">
                                                    <b>{{ buatrpDecimal($estimasi['shu']) }}</b>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal"
                    aria-label="Close">Keluar</button>
            </div>
        </div>
    </div>
</div>
