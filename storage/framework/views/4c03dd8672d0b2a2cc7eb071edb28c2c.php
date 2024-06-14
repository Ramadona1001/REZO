<?php
    use App\Models\Utility;
    $setting = \App\Models\Utility::settings();

?>


<footer id="page-footer" class="bg-body-light">
    <div class="content py-0">
      <div class="row fs-sm">
        <div class="col-sm-6 order-sm-2 mb-1 mb-sm-0 text-center text-sm-end">
            <?php echo e(date('Y')); ?> <?php echo e($setting['footer_text'] ? $setting['footer_text'] : config('app.name', 'Resource Managment')); ?>

        </div>
        <div class="col-sm-6 order-sm-1 text-center text-sm-start">
          <a class="fw-semibold" href="#" target="_blank"><?php echo e($setting['footer_text'] ? $setting['footer_text'] : config('app.name', 'Resource Managment')); ?></a> &copy; <span data-toggle="year-copy"></span>
        </div>
      </div>
    </div>
</footer>

</div>
<!-- END Page Container -->




<script src="<?php echo e(asset('assets/js/lib/jquery.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/plugins/bootstrap.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/plugins/feather.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/dash.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/dashmix.app.min.js')); ?>"></script>


<script src="<?php echo e(asset('assets/js/plugins/simplebar.min.js')); ?>"></script>

<script src="<?php echo e(asset('js/moment.min.js')); ?>"></script>

<script src="<?php echo e(asset('assets/js/plugins/bootstrap-switch-button.min.js')); ?>"></script>

<script src="<?php echo e(asset('assets/js/plugins/sweetalert2.all.min.js')); ?>"></script>

<script src="<?php echo e(asset('assets/js/plugins/datatables/jquery.dataTables.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/plugins/datatables-bs5/js/dataTables.bootstrap5.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/plugins/datatables-responsive/js/dataTables.responsive.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/plugins/datatables-responsive-bs5/js/responsive.bootstrap5.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/plugins/datatables-buttons/dataTables.buttons.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/plugins/datatables-buttons-bs5/js/buttons.bootstrap5.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/plugins/datatables-buttons-jszip/jszip.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/plugins/datatables-buttons-pdfmake/pdfmake.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/plugins/datatables-buttons-pdfmake/vfs_fonts.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/plugins/datatables-buttons/buttons.print.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/plugins/datatables-buttons/buttons.html5.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/pages/be_tables_datatables.min.js')); ?>"></script>

<!-- Apex Chart -->



<script src="<?php echo e(asset('js/jscolor.js')); ?>"></script>

<script src="<?php echo e(asset('js/popper.min.js')); ?>"></script>






<script>
    var site_currency_symbol_position = '<?php echo e($setting['site_currency_symbol_position']); ?>';
    var site_currency_symbol = '<?php echo e($setting['site_currency_symbol']); ?>';

</script>
<script src="<?php echo e(asset('js/custom.js')); ?>"></script>

<?php if($message = Session::get('success')): ?>
    <script>
        show_toastr('success', '<?php echo $message; ?>');
    </script>
<?php endif; ?>
<?php if($message = Session::get('error')): ?>
    <script>
        show_toastr('error', '<?php echo $message; ?>');
    </script>
<?php endif; ?>
<?php if($setting['enable_cookie'] == 'on'): ?>
    <?php echo $__env->make('layouts.cookie_consent', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endif; ?>
<?php echo $__env->yieldPushContent('script-page'); ?>

<?php echo $__env->yieldPushContent('old-datatable-js'); ?>




<script>




    feather.replace();
    var pctoggle = document.querySelector("#pct-toggler");
    if (pctoggle) {
        pctoggle.addEventListener("click", function () {
            if (
                !document.querySelector(".pct-customizer").classList.contains("active")
            ) {
                document.querySelector(".pct-customizer").classList.add("active");
            } else {
                document.querySelector(".pct-customizer").classList.remove("active");
            }
        });
    }

    var themescolors = document.querySelectorAll(".themes-color > a");
    for (var h = 0; h < themescolors.length; h++) {
        var c = themescolors[h];

        c.addEventListener("click", function (event) {
            var targetElement = event.target;
            if (targetElement.tagName == "SPAN") {
                targetElement = targetElement.parentNode;
            }
            var temp = targetElement.getAttribute("data-value");
            removeClassByPrefix(document.querySelector("body"), "theme-");
            document.querySelector("body").classList.add(temp);
        });
    }

 




    function removeClassByPrefix(node, prefix) {
        for (let i = 0; i < node.classList.length; i++) {
            let value = node.classList[i];
            if (value.startsWith(prefix)) {
                node.classList.remove(value);
            }
        }
    }
</script>

<?php echo $__env->yieldContent('scripts'); ?><?php /**PATH C:\xampp\htdocs\rezo2\resources\views/partials/admin/footer.blade.php ENDPATH**/ ?>