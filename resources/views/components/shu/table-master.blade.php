<div class="table-responsive">
    <table class="table table-striped dataTable">
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama Alokasi</th>
                <th>Persentase</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @php
                $no = 1;
            @endphp
            @forelse ($shu as $a)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $a->nama }}</td>
                    <td>{{ $a->persen }}%</td>
                    <td>
                        <x-table.action :routeedit="route($routee, $a->id_shu)" :routedelete="route($routed, $a->id_shu)" />
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center">Data Kosong.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
