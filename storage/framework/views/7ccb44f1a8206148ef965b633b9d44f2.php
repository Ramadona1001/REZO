<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Settings')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Settings')); ?></li>
<?php $__env->stopSection(); ?>

<?php
    $lang = \App\Models\Utility::getValByName('default_language');
   // $logo=asset(Storage::url('uploads/logo/'));
    $logo=\App\Models\Utility::get_file('uploads/logo');
    $logo_light = \App\Models\Utility::getValByName('logo_light');
    $logo_dark = \App\Models\Utility::getValByName('logo_dark');
    $company_favicon = \App\Models\Utility::getValByName('company_favicon');
    $setting = \App\Models\Utility::colorset();
    $color = (!empty($setting['color'])) ? $setting['color'] : 'theme-3';
    $flag = (!empty($setting['color_flag'])) ? $setting['color_flag'] : '';
    $SITE_RTL= isset($setting['SITE_RTL'])?$setting['SITE_RTL']:'off';
    $meta_image = \App\Models\Utility::get_file('uploads/meta/');
?>


<?php
    $file_type = config('files_types');
    $setting = App\Models\Utility::settings();

   $local_storage_validation    = $setting['local_storage_validation'];
   $local_storage_validations   = explode(',', $local_storage_validation);

   $s3_storage_validation    = $setting['s3_storage_validation'];
   $s3_storage_validations   = explode(',', $s3_storage_validation);

   $wasabi_storage_validation    = $setting['wasabi_storage_validation'];
   $wasabi_storage_validations   = explode(',', $wasabi_storage_validation);

?>
<style>


</style>

<script>
    // document.addEventListener("DOMContentLoaded", function() {
    //     const body = document.querySelector("body");
    //     const input = document.getElementById("colorPicker");
    //     const colorCode = document.getElementById("colorCode");
    //     const button = document.getElementById("changeColorButton");

    //     setColor();
    //     input.addEventListener("input", setColor);

    //     function setColor() {
    //         // body.style.backgroundColor = input.value;
    //         colorCode.innerHTML = input.value;
    //     }
    // });


</script>

<?php $__env->startPush('css-page'); ?>
    <?php if($color == 'theme-3'): ?>
        <style>
            .btn-check:checked + .btn-outline-primary, .btn-check:active + .btn-outline-primary,
            .btn-outline-primary:active, .btn-outline-primary.active, .btn-outline-primary.dropdown-toggle.show {
                color: #ffffff;
                background-color: #6fd943 !important;
                border-color: #6fd943 !important;
            }

            .btn-outline-primary:hover
            {
                color: #ffffff;
                background-color: #6fd943 !important;
                border-color: #6fd943 !important;
            }

            .btn[class*="btn-outline-"]:hover {

                border-color: #6fd943 !important;
            }
        </style>
    <?php endif; ?>
    <?php if($color == 'theme-2'): ?>
        <style>
            .btn-check:checked + .btn-outline-primary, .btn-check:active + .btn-outline-primary, .btn-outline-primary:active, .btn-outline-primary.active, .btn-outline-primary.dropdown-toggle.show {
                color: #ffffff;
                background: linear-gradient(141.55deg, rgba(240, 244, 243, 0) 3.46%, #4ebbd3 99.86%)#1f3996 !important;
                border-color: #4ebbd3 !important;
            }

            .btn-outline-primary:hover
            {
                color: #ffffff;
                background: linear-gradient(141.55deg, rgba(240, 244, 243, 0) 3.46%, #4ebbd3 99.86%)#1f3996 !important;
                border-color: #4ebbd3 !important;
            }
            .btn.btn-outline-primary{
                color: #1F3996;
                border-color: #4ebbd3 !important;
            }
        </style>
    <?php endif; ?>
    <?php if($color == 'theme-4'): ?>
        <style>
            .btn-check:checked + .btn-outline-primary, .btn-check:active + .btn-outline-primary, .btn-outline-primary:active, .btn-outline-primary.active, .btn-outline-primary.dropdown-toggle.show {
                color: #ffffff;
                background-color: #584ed2 !important;
                border-color: #584ed2 !important;

            }

            .btn-outline-primary:hover
            {
                color: #ffffff;
                background-color: #584ed2 !important;
                border-color: #584ed2 !important;
            }
            .btn.btn-outline-primary{
                color: #584ed2;
                border-color: #584ed2 !important;
            }
        </style>
    <?php endif; ?>
    <?php if($color == 'theme-1'): ?>
        <style>
            .btn-check:checked + .btn-outline-primary, .btn-check:active + .btn-outline-primary,
            .btn-outline-primary:active, .btn-outline-primary.active, .btn-outline-primary.dropdown-toggle.show {
                color: #ffffff;
                background: linear-gradient(141.55deg, rgba(81, 69, 157, 0) 3.46%, rgba(255, 58, 110, 0.6) 99.86%), #51459d !important;
                border-color: #51459d !important;
            }


            body.theme-1 .btn-outline-primary:hover
            {
                color: #ffffff;
                background: linear-gradient(141.55deg, rgba(81, 69, 157, 0) 3.46%, rgba(255, 58, 110, 0.6) 99.86%), #51459d !important;
                border-color: #51459d !important;
            }
        </style>
    <?php endif; ?>
<?php $__env->stopPush(); ?>


<?php $__env->startPush('script-page'); ?>
    <script>
        var scrollSpy = new bootstrap.ScrollSpy(document.body, {
            target: '#useradd-sidenav',
            offset: 300,
        })

        $('.colorPicker').on('click', function(e) {
            $('body').removeClass('custom-color');
            if (/^theme-\d+$/) {
                $('body').removeClassRegex(/^theme-\d+$/);
            }
            $('body').addClass('custom-color');
            $('.themes-color-change').removeClass('active_color');
            $(this).addClass('active_color');
            const input = document.getElementById("color-picker");
            setColor();
            input.addEventListener("input", setColor);

            function setColor() {
                $(':root').css('--color-customColor', input.value);
            }

            $(`input[name='color_flag`).val('true');
        });

        $('.themes-color-change').on('click', function() {

        $(`input[name='color_flag`).val('false');

            var color_val = $(this).data('value');
            $('body').removeClass('custom-color');
            if(/^theme-\d+$/)
            {
                $('body').removeClassRegex(/^theme-\d+$/);                
            }
            $('body').addClass(color_val);
            $('.theme-color').prop('checked', false);
            $('.themes-color-change').removeClass('active_color');
            $('.colorPicker').removeClass('active_color');
            $(this).addClass('active_color');
            $(`input[value=${color_val}]`).prop('checked', true);
        });
        
        $.fn.removeClassRegex = function(regex) {
    return $(this).removeClass(function(index, classes) {
        return classes.split(/\s+/).filter(function(c) {
            return regex.test(c);
        }).join(' ');
    });
};

        // storage setting
        $(document).on('change','[name=storage_setting]',function(){
            if($(this).val() == 's3'){
                $('.s3-setting').removeClass('d-none');
                $('.wasabi-setting').addClass('d-none');
                $('.local-setting').addClass('d-none');
            }else if($(this).val() == 'wasabi'){
                $('.s3-setting').addClass('d-none');
                $('.wasabi-setting').removeClass('d-none');
                $('.local-setting').addClass('d-none');
            }else{
                $('.s3-setting').addClass('d-none');
                $('.wasabi-setting').addClass('d-none');
                $('.local-setting').removeClass('d-none');
            }
        });
    </script>

    <script>
        document.getElementById('logo_dark').onchange = function () {
            var src = URL.createObjectURL(this.files[0])
            document.getElementById('image').src = src
        }
        document.getElementById('logo_light').onchange = function () {
            var src = URL.createObjectURL(this.files[0])
            document.getElementById('image1').src = src
        }
        document.getElementById('favicon').onchange = function () {
            var src = URL.createObjectURL(this.files[0])
            document.getElementById('image2').src = src
        }
    </script>

    <script type="text/javascript">

        $(document).on("click", '.send_email', function(e)
        {
            e.preventDefault();
            var title = $(this).attr('data-title');
            var size = 'md';
            var url = $(this).attr('data-url');

            if (typeof url != 'undefined') {
                $("#commonModal .modal-title").html(title);
                $("#commonModal .modal-dialog").addClass('modal-' + size);
                $("#commonModal").modal('show');


                $.post(url, {
                    _token:'<?php echo e(csrf_token()); ?>',
                    mail_driver: $("#mail_driver").val(),
                    mail_host: $("#mail_host").val(),
                    mail_port: $("#mail_port").val(),
                    mail_username: $("#mail_username").val(),
                    mail_password: $("#mail_password").val(),
                    mail_encryption: $("#mail_encryption").val(),
                    mail_from_address: $("#mail_from_address").val(),
                    mail_from_name: $("#mail_from_name").val(),

                }, function(data) {
                    $('#commonModal .body').html(data);
                });
            }
        });
        $(document).on('submit', '#test_email', function(e) {
            e.preventDefault();
            // $("#email_sending").show();
            var post = $(this).serialize();
            var url = $(this).attr('action');
            $.ajax({
                type: "post",
                url: url,
                data: post,
                cache: false,
                beforeSend: function() {
                    $('#test_email .btn-create').attr('disabled', 'disabled');
                },
                success: function(data) {
                    // console.log(data)
                    if (data.success) {
                        show_toastr('success', data.message, 'success');
                    } else {
                        show_toastr('error', data.message, 'error');
                    }
                    // $("#email_sending").hide();
                    $('#commonModal').modal('hide');


                },
                complete: function() {
                    $('#test_email .btn-create').removeAttr('disabled');
                },
            });
        });
    </script>

    
    <script type="text/javascript">
        function enablecookie() {
            const element = $('#enable_cookie').is(':checked');
            $('.cookieDiv').addClass('disabledCookie');
            if (element==true) {
                $('.cookieDiv').removeClass('disabledCookie');
                $("#cookie_logging").attr('checked', true);
            } else {
                $('.cookieDiv').addClass('disabledCookie');
                $("#cookie_logging").attr('checked', false);
            }
        }
    </script>

    <script>
        if ($('#cust-darklayout').length > 0) {
            var custthemedark = document.querySelector("#cust-darklayout");
            custthemedark.addEventListener("click", function() {
            var custthemedark = document.querySelector("#cust-darklayout");
            custthemedark.addEventListener("click", function() {
                if (custthemedark.checked) {
                    $('#main-style-link').attr('href','<?php echo e(env("APP_URL")); ?>'+'/public/assets/css/style-dark.css');
                    
                    document.body.style.background = 'linear-gradient(141.55deg, #22242C 3.46%, #22242C 99.86%)';
                    $('.dash-sidebar .main-logo a img').attr('src','<?php echo e($logo . '/logo-light.png'); ?>');

                } else {
                    document.body.style.setProperty('background', 'linear-gradient(141.55deg, rgba(240, 244, 243, 0) 3.46%, #f0f4f3 99.86%)', 'important');

                    $('#main-style-link').attr('href','<?php echo e(env("APP_URL")); ?>'+'/public/assets/css/style.css');
                    $('.dash-sidebar .main-logo a img').attr('src','<?php echo e($logo. '/logo-dark.png'); ?>');

                }
            });
            });
        }
    </script>


<?php $__env->stopPush(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Settings')); ?></li>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="row">
                

                <div class="col-xl-12">

                    <!--Site Settings-->
                    <div id="brand-settings" class="card">
                        <div class="card-header">
                            <h5><?php echo e(__('Brand Settings')); ?></h5>
                        </div>
                        <?php echo e(Form::model($settings, ['url' => 'systems', 'method' => 'POST', 'enctype' => 'multipart/form-data'])); ?>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-4 col-sm-6 col-md-6">
                                    <div class="card logo_card">
                                        <div class="card-header">
                                            <h5><?php echo e(__('Logo dark')); ?></h5>
                                        </div>
                                        <div class="card-body pt-0">
                                            <div class="setting-card">
                                                <div class="logo-content mt-4">
                                                    <img id="image" src="<?php echo e($logo.'/'.(isset($logo_dark) && !empty($logo_dark)?$logo_dark:'logo-dark.png').'?timestamp='.time()); ?>"
                                                         class="big-logo" style="width:100%">
                                                </div>
                                                <div class="choose-files mt-5">
                                                    <label for="logo_dark">
                                                        <div class="  company_logo_update"> <i
                                                                class="fa fa-upload px-1"></i><?php echo e(__('Choose file here')); ?>

                                                        </div>
                                                        <input type="file" name="logo_dark" id="logo_dark" class="form-control file" data-filename="logo_dark">
                                                    </label>
                                                </div>
                                                <?php $__errorArgs = ['logo_dark'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <div class="row">
                                                    <span class="invalid-logo" role="alert">
                                                        <strong class="text-danger"><?php echo e($message); ?></strong>
                                                    </span>
                                                    </div>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-6 col-md-6">
                                    <div class="card logo_card">
                                        <div class="card-header">
                                            <h5><?php echo e(__('Logo Light')); ?></h5>
                                        </div>
                                        <div class="card-body pt-0">
                                            <div class=" setting-card">
                                                <div class="logo-content mt-4">
                                                    <img id="image1" src="<?php echo e($logo.'/'.(isset($logo_light) && !empty($logo_light)?$logo_light:'logo-light.png').'?timestamp='.time()); ?>"
                                                         class="big-logo img_setting" style="width:100%;    filter: drop-shadow(5px 5px 5px gray);">
                                                </div>
                                                <div class="choose-files mt-5">
                                                    <label for="logo_light">
                                                        <div class="  dark_logo_update"> <i class="fa fa-upload px-1">
                                                            </i><?php echo e(__('Choose file here')); ?>

                                                        </div>
                                                        <input type="file" name="logo_light" id="logo_light" class="form-control file" data-filename="logo_light">
                                                    </label>
                                                </div>
                                                <?php $__errorArgs = ['logo_light'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <div class="row">
                                                    <span class="invalid-logo" role="alert">
                                                        <strong class="text-danger"><?php echo e($message); ?></strong>
                                                    </span>
                                                </div>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-6 col-md-6">
                                    <div class="card logo_card">
                                        <div class="card-header">
                                            <h5><?php echo e(__('Favicon')); ?></h5>
                                        </div>
                                        <div class="card-body pt-0">
                                            <div class=" setting-card">
                                                <div class="logo-content mt-4">
                                                    <img id="image2" src="<?php echo e($logo.'/'.(isset($company_favicon) && !empty($company_favicon)?$company_favicon:'favicon.png').'?timestamp='.time()); ?>" width="50px"
                                                         class="img_setting" style="width:100%;    filter: drop-shadow(5px 5px 5px gray);">
                                                </div>
                                                <div class="choose-files mt-5">
                                                    <label for="favicon">
                                                        <div class=" company_favicon_update"> <i
                                                                class="fa fa-upload px-1"></i><?php echo e(__('Choose file here')); ?>

                                                        </div>
                                                        <input type="file" class="form-control file"  id="favicon" name="favicon"
                                                               data-filename="favicon">
                                                    </label>
                                                </div>
                                                <?php $__errorArgs = ['favicon'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <div class="row">
                                                    <span class="invalid-logo" role="alert">
                                                            <strong class="text-danger"><?php echo e($message); ?></strong>
                                                    </span>
                                                </div>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <?php echo e(Form::label('title_text',__('Title Text'),array('class'=>'form-label'))); ?>

                                            <?php echo e(Form::text('title_text',null,array('class'=>'form-control','placeholder'=>__('Title Text')))); ?>

                                            <?php $__errorArgs = ['title_text'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="invalid-title_text" role="alert">
                                                     <strong class="text-danger"><?php echo e($message); ?></strong>
                                                 </span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <?php echo e(Form::label('footer_text',__('Footer Text'),['class'=>'form-label'])); ?>

                                            <?php echo e(Form::text('footer_text',Utility::getValByName('footer_text'),array('class'=>'form-control','placeholder'=>__('Enter Footer Text')))); ?>

                                            <?php $__errorArgs = ['footer_text'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="invalid-footer_text" role="alert">
                                                <strong class="text-danger"><?php echo e($message); ?></strong>
                                            </span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                    
                                </div>
                                

                                
                                <div class="card-footer text-end">
                                    <div class="form-group">
                                        <input class="btn btn-print-invoice btn-primary m-r-10" type="submit" value="<?php echo e(__('Save Changes')); ?>">
                                    </div>
                                </div>
                                <?php echo e(Form::close()); ?>

                            </div>
                        </div>
                    </div>

                    <!--Email Settings-->
                    

                    <!--Payment Settings-->
                    

                    <!--Pusher Settings-->
                    

                    <!--ReCaptcha Settings-->
                    

                    <!-- Storage Settings -->
                    

                    
                    

                    
                    

                    
                    

                    
                    
                    

                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>




<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\rezo2\resources\views/settings/index.blade.php ENDPATH**/ ?>