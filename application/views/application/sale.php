<!-- Begin Page Content -->
<form id="saleSubmit">
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800">Sale</h1>
        <div class="row">
            <div class="col-lg-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Transaksi
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="itemCode">No:</label>
                            <input type="text" class="form-control" id="noTrans" name="noTrans" readonly>
                        </div>
                        <div class="form-group">
                            <label for="date">Tanggal:</label>
                            <input type="date" class="form-control" id="date" name="date">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Customer
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="custCode">Kode:</label>
                            <select class="form-control" id="custCode" name="custCode">
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="custName">Nama:</label>
                            <input type="text" class="form-control" id="custName" name="custName" disabled>
                        </div>
                        <div class="form-group">
                            <label for="custTelp">Telp:</label>
                            <input type="text" class="form-control" id="custTelp" name="custTelp" disabled>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th rowspan="2">
                                            <a href="#" class="btn btn-primary btn-icon-split" data-target="#SaleFormModal" data-type="SaleAdd" data-toggle="modal">
                                                <span class="text">Tambah</span>
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-plus-square"></i>
                                                </span>
                                            </a>
                                        </th>
                                        <th rowspan="2">No.</th>
                                        <th rowspan="2">Kode Barang</th>
                                        <th rowspan="2">Nama Barang</th>
                                        <th rowspan="2">Qty</th>
                                        <th rowspan="2">Harga Bandrol</th>
                                        <th colspan="2">Diskon</th>
                                        <th rowspan="2">Harga Diskon</th>
                                        <th rowspan="2">Total</th>
                                    </tr>
                                    <tr>
                                        <th>(%)</th>
                                        <th>(Rp)</th>
                                    </tr>
                                </thead>
                                <tbody id="SaleRow">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6"></div>
            <div class="col-lg-6">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="subTot">Sub Total:</label>
                            <input class="form-control" type="text" name="subTot" id="subTot" value="0.00" readonly>
                        </div>
                        <div class="form-group">
                            <label for="disco">Diskon (Rp):</label>
                            <input class="form-control" type="text" name="disco" id="disco" value="0.00">
                        </div>
                        <div class=" form-group">
                            <label for="okr">Ongkir (Rp):</label>
                            <input class="form-control" type="text" name="okr" id="okr" value="0.00">
                        </div>
                        <div class="form-group">
                            <label for="topbar">Total Bayar:</label>
                            <input class="form-control" type="text" name="totbar" id="totbar" value="0.00" readonly>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary btn-block">
                                    <span class="text">Simpan</span>
                                </button>
                            </div>
                            <div class="col-md-6">
                                <a href="<?= base_url('sale'); ?>" class="btn btn-danger d-block">
                                    <span class="text">Reset</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->

</form>

<div class="modal fade" id="SaleFormModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form Sale</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="no" name="no">
                <div class="form-group">
                    <label for="items">Barang:</label>
                    <select class="form-control" id="items" name="items">
                    </select>
                </div>
                <div class="form-group">
                    <label for="qty">Qty:</label>
                    <input type="number" class="form-control" id="qty" name="qty" min="1">
                </div>
                <div class="form-group">
                    <label for="discPerc">Diskon (%):</label>
                    <input type="number" class="form-control" id="discPerc" name="discPerc" min="0" max="100">
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Kembali</button>
                <button type="submit" class="btn btn-primary" disabled>Simpan</button>
            </div>
        </form>
    </div>
</div>