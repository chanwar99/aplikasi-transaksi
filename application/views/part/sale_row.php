<tr>
    <td>
        <a href="#" class="btn btn-primary" data-target="#SaleFormModal" data-type="SaleEdit" data-toggle="modal" data-id="<?= $id; ?>">
            <i class="fas fa-edit"></i>
        </a>
        <a href="#" class="btn btn-danger btn-del">
            <i class="fas fa-trash"></i>
        </a>
    </td>
    <td>no</td>
    <td>
        <input type="hidden" value="<?= $id;; ?>" name="idItem[]">
        <input type="hidden" value="<?= $kode_brg; ?>" name="itemCode[]" disabled>
        <?= $kode_brg; ?>
    </td>
    <td>
        <input type="hidden" value="<?= $nama_brg; ?>" name="itemName[]" disabled>
        <?= $nama_brg; ?>
    </td>
    <td>
        <input type="hidden" value="<?= $qty; ?>" name="qty[]">
        <?= $qty; ?>
    </td>
    <td>
        <input type="hidden" value="<?= $harga_ban; ?>" name="itemPrice[]">
        <?= $harga_ban; ?>
    </td>
    <td>
        <input type="hidden" value="<?= $diskon_perc; ?>" name="discPerc[]">
        <?= $diskon_perc; ?>
    </td>
    <td>
        <input type="hidden" value="<?= $diskon_nom; ?>" name="nomDisc[]">
        <?= $diskon_nom; ?>
    </td>
    <td>
        <input type="hidden" value="<?= $harga_disc; ?>" name="priceDisc[]">
        <?= $harga_disc; ?>
    </td>
    <td>
        <input type="hidden" value="<?= $harga_tot; ?>" name="priceTot[]">
        <?= $harga_tot; ?>
    </td>
</tr>