</div>
<!-- End of Main Content -->
<!-- Footer -->
<footer class="sticky-footer bg-white">
    <div class="container my-auto">
        <div class="copyright text-center my-auto">
            <span>Copyright &copy; Your Website 2020</span>
        </div>
    </div>
</footer>
<!-- End of Footer -->

</div>
<!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Bootstrap core JavaScript-->
<script src="<?= base_url('assets/'); ?>vendor/jquery/jquery.min.js"></script>
<script src="<?= base_url('assets/'); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="<?= base_url('assets/'); ?>vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="<?= base_url('assets/'); ?>js/sb-admin-2.min.js"></script>

<script src="<?= base_url('assets/'); ?>js/jquery.maskMoney.js"></script>
<!-- <script src="<?= base_url('assets/'); ?>js/simple.money.format.js"></script> -->
<script src="<?= base_url('assets/'); ?>js/jquery.validate.min.js"></script>
<script src="<?= base_url('assets/'); ?>js/select2.min.js"></script>
<script src="<?= base_url('assets/'); ?>js/sweetalert.min.js"></script>
<script src="<?= base_url('assets/'); ?>js/sweetalert.min.js"></script>
<script src="<?= base_url('assets/'); ?>js/datatables.min.js"></script>

<script>
    var site = "<?= base_url(); ?>";
</script>
<script src="<?= base_url('assets/'); ?>js/item.js"></script>
<script src="<?= base_url('assets/'); ?>js/sale.js"></script>

<script>
    $(function() {
        $('#btnLogout').click(function(e) {
            e.preventDefault();
            swal({
                title: "Konfirmasi",
                text: "Apkah yakin untuk logout?",
                icon: "warning",
                buttons: ["Tidak", "Ya"],
                dangerMode: false,
            }).then((ok) => {
                if (ok) {
                    window.location.href = $(this).prop('href');
                }
            });
        });
    });
</script>


</body>

</html>