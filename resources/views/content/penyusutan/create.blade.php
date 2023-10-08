@extends('layouts.contentSidebarLayout')
@section('title', "$title")
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>{{ $title }}</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="page-content">
        <!-- // Basic multiple Column Form section start -->
        <section id="multiple-column-form">
            <div class="row match-height">
                <div class="col-12">
                    <div class="card">
                        <h5 class="card-header">{{ $title2 }}</h5>
                        <div class="card-body">
                            <div class="progress mb-3">
                                @if ($step == 'satu')
                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-info"
                                        role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0"
                                        aria-valuemax="100">0%</div>
                                @elseif ($step == 'dua')
                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-info"
                                        role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0"
                                        aria-valuemax="100">50%</div>
                                @elseif ($step == 'tiga')
                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-info"
                                        role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0"
                                        aria-valuemax="100">75%</div>
                                @else
                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-info"
                                        role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0"
                                        aria-valuemax="100">100%</div>
                                @endif
                            </div>
                        </div>
                        @if ($step == 'satu')
                            <x-penyusutan.form-satu :barang="$barangs" :unit="$units" :pnypenyusutan="$pnyPenyusutan" :routepny="$routePny"
                                :route="$mainRoute" />
                        @elseif ($step == 'dua')
                            <x-penyusutan.form-dua :inventaris="$barangs" :penyesuaian="$penyesuaian" :route="$mainRoute" />
                        @elseif ($step == 'tiga')
                            <x-penyusutan.form-tiga :dataprev="$data_prev" :tanggal="$tgl_transaksi" :coas="$coas"
                                :inventaris="$inventaris" :penyusutans="$penyusutans" :penyesuaian="$penyesuaian" :route="$mainRoute" />
                        @else
                            <x-penyusutan.form-empat :dataprev="$data_prev" :detail="$detail" :jurnal="$jurnal"
                                :jurnalpny="$jurnalPny" :tanggal="$tgl_transaksi" :tipe="$tipe" :invoicepny="$invoice_penyesuaian"
                                :idpenyesuaian="$id_penyesuaian" :route="$mainRoute" :routepny="$routePny" />
                        @endif
                    </div>
                </div>
            </div>
        </section>
        <!-- // Basic multiple Column Form section end -->
    </div>
@endsection
@section('pageScript')
    @if ($step === 'satu')
        <script src="{{ asset('assets/admin') }}/js/siakku-custom/adjustment-depreciation-inventory.js"></script>
    @endif
    @if ($step === 'tiga')
        <script>
            var penyusutan = @json($penyusutans);
            document.getElementById("form-step-tiga").addEventListener("submit", function(event) {
                for (let i = 0; i < penyusutan.length; i++) {
                    if (penyusutan[i].total_penyusutan > 0) {
                        const select_coa = document.getElementById("idKredit" + penyusutan[i].id);
                        const select_coa_error = document.getElementById("errorPenyusutan" + penyusutan[i].id);
                        if (select_coa.value === "") {
                            select_coa_error.innerHTML = "Anda Harus memilih Akun Penyusutan " + penyusutan[i].jenis;
                            event.preventDefault();
                        } else {
                            select_coa_error.innerHTML = "";
                        }
                    }
                }
            });
        </script>
    @endif
    @if ($step === 'empat')
        <script src="{{ asset('assets/admin') }}/js/siakku-custom/adjustment-depreciation-inventory-two.js"></script>
    @endif
@endsection
