<div>
    <div class="card">
        <div class="card-header">
            <h5>Pengembalian Buku</h5>
        </div>
        <div class="card-body">
            @if (session()->has('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Buku</th>
                            <th>Member</th>
                            <th>Tanggal Pinjam</th>
                            <th>Tanggal Kembali</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pinjam as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->buku->judul }}</td>
                                <td>{{ $data->user->nama }}</td>
                                <td>{{ $data->tgl_pinjam }}</td>
                                <td>{{ $data->tgl_kembali }}</td>
                                <td>
                                    <button wire:click="pilih({{ $data->id }})" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modalPilih">
                                        Pilih
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $pinjam->links() }}
            </div>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header">
            <h5>Histori Pengembalian</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID Pinjam</th>
                            <th>Tanggal Kembali</th>
                            <th>Denda</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pengembalian as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->pinjam_id }}</td>
                                <td>{{ $data->tgl_kembali }}</td>
                                <td>{{ $data->denda }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $pengembalian->links() }}
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="modalPilih" tabindex="-1" aria-labelledby="modalPilihLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalPilihLabel">Form Pengembalian Buku</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3 row">
                        <label class="col-sm-4 font-weight-bold">Judul Buku</label>
                        <div class="col-sm-8">: {{ $judul }}</div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-4 font-weight-bold">Member</label>
                        <div class="col-sm-8">: {{ $member }}</div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-4 font-weight-bold">Tanggal Kembali</label>
                        <div class="col-sm-8">: {{ $tglkembali }}</div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-4 font-weight-bold">Tanggal Hari Ini</label>
                        <div class="col-sm-8">: {{ date('Y-m-d') }}</div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-4 font-weight-bold">Denda</label>
                        <div class="col-sm-8">: {{ $status ? 'Ya' : 'Tidak' }}</div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-4 font-weight-bold">Lama Terlambat</label>
                        <div class="col-sm-8">: {{ $lama }} hari</div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-4 font-weight-bold">Jumlah Denda</label>
                        <div class="col-sm-8">: Rp{{ $lama * 1000 }}</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="button" wire:click="store" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    window.addEventListener('close-modal', () => {
        $('#modalPilih').modal('hide');
    });
</script>
