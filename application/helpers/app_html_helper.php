<?php

defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Remove <br /> html tags from string to show in textarea with new linke
 * @param  string $text
 * @param  string $replace character to replace with
 * @return string formatted text
 */
function clear_textarea_breaks($text, $replace = '')
{
    $breaks = [
        '<br />',
        '<br>',
        '<br/>',
    ];

    $text = str_ireplace($breaks, $replace, $text);
    $text = trim($text);

    return $text;
}

/**
 * Equivalent function to nl2br php function but keeps the html if found and do not ruin the formatting
 * @param  string $string
 * @return string
 */
function nl2br_save_html($string)
{
    if (! preg_match('#</.*>#', $string)) { // avoid looping if no tags in the string.
        return nl2br($string);
    }

    $string = str_replace(["\r\n", "\r", "\n"], "\n", $string);

    $lines  = explode("\n", $string);
    $output = '';
    foreach ($lines as $line) {
        $line = rtrim($line);
        if (! preg_match('#</?[^/<>]*>$#', $line)) { // See if the line finished with has an html opening or closing tag
            $line .= '<br />';
        }
        $output .= $line . "\n";
    }

    return $output;
}

/**
 * Check for alerts
 * @return null
 */
function app_js_alerts()
{
    $CI         = &get_instance();
    $alertclass = get_alert_class();
    if ($alertclass != '') {
        $alert_message = '';
        $alert         = $CI->session->flashdata('message-' . $alertclass);
        if (is_array($alert)) {
            foreach ($alert as $alert_data) {
                $alert_message .= '<span>' . $alert_data . '</span><br />';
            }
        } else {
            $alert_message .= $alert;
        }
        echo '<script>';
        echo '$(function(){
            alert_float("' . $alertclass . '","' . $alert_message . '");
        });';
        echo '</script>';
    }

    // Available only for admin area
    if ($CI->session->has_userdata('system-popup')) {
        echo '<script>';
        echo '$(function(){
            if(typeof("system_popup") != undefined) {
                var popupData = {};
                popupData.message = ' . json_encode(app_happy_text($CI->session->userdata('system-popup'))) . ';
                system_popup(popupData);
            }
        });';
        echo '</script>';
    }
}

/**
 * External form common footer, eq. leads form, tickets form
 * @param  mixed $form form from database
 * @return mixed
 */
function app_external_form_footer($form)
{
    $date_format = get_option('dateformat');
    $date_format = explode('|', $date_format);
    $date_format = $date_format[0];
    $locale_key  = get_locale_key($form->language);
    $assetsGroup = 'external-form';
    $CI          = &get_instance();
    $CI->app_scripts->add('jquery-js', 'assets/plugins/jquery/jquery.min.js', $assetsGroup);
    $CI->app_scripts->add('bootstrap-js', 'assets/plugins/bootstrap/js/bootstrap.min.js', $assetsGroup);
    add_jquery_validation_js_assets($assetsGroup);
    add_moment_js_assets($assetsGroup);
    add_bootstrap_select_js_assets($assetsGroup);
    $CI->app_scripts->add('datetimepicker-js', 'assets/plugins/datetimepicker/jquery.datetimepicker.full.min.js', $assetsGroup);
    $CI->app_scripts->add('colorpicker-js', 'assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js', $assetsGroup);
    echo app_compile_scripts($assetsGroup); ?>
    <script>
    $(function(){
     var time_format = '<?php echo get_option('time_format'); ?>';
     var date_format = '<?php echo $date_format; ?>';

     $('body').tooltip({
       selector: '[data-toggle="tooltip"]'
     });

     $('body').find('.colorpicker-input').colorpicker({
       format: "hex"
     });

     var date_picker_options = {
       format: date_format,
       timepicker: false,
       lazyInit: true,
       dayOfWeekStart: '<?php echo get_option('calendar_first_day '); ?>',
     }

    $('.datepicker').datetimepicker(date_picker_options);
     var date_time_picker_options = {
      lazyInit: true,
      scrollInput: false,
      validateOnBlur :false,
      dayOfWeekStart: '<?php echo get_option('calendar_first_day '); ?>',
    }
    if(time_format == 24){
      date_time_picker_options.format = date_format + ' H:i';
    } else {
      date_time_picker_options.format =  date_format + ' g:i A';
      date_time_picker_options.formatTime = 'g:i A';
    }
    $('.datetimepicker').datetimepicker(date_time_picker_options);

    $('body').find('select').selectpicker({
      showSubtext: true,
    });

    $.validator.addMethod('filesize', function (value, element, param) {
        return this.optional(element) || (element.files[0].size <= param)
    }, "<?php echo _l('ticket_form_validation_file_size', bytesToSize('', file_upload_max_size())); ?>");

    $.validator.addMethod( "extension", function( value, element, param ) {
        param = typeof param === "string" ? param.replace( /,/g, "|" ) : "png|jpe?g|gif";
        return this.optional( element ) || value.match( new RegExp( "\\.(" + param + ")$", "i" ) );
    }, $.validator.format( "<?php echo _l('validation_extension_not_allowed'); ?>" ) );

    $.validator.setDefaults({
     highlight: function(element) {
       $(element).closest('.form-group').addClass('has-error');
     },
     unhighlight: function(element) {
       $(element).closest('.form-group').removeClass('has-error');
     },
     errorElement: 'p',
     errorClass: 'text-danger',
     errorPlacement: function(error, element) {
            if (element.parent('.input-group').length || element.parents('.chk').length) {
                if (!element.parents('.chk').length) {
                    error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element.parents('.chk'));
                }
            } else if (element.is('select') && (element.hasClass('selectpicker') || element.hasClass('ajax-search'))) {
               error.insertAfter(element.parents('.form-group *').last());
            } else {
                error.insertAfter(element);
            }
        }
       });
    });
 </script>
 <?php
}

/**
 * External forms common header, eq ticket form, lead form
 * @param  mixed $form form from database
 * @return mixed
 */
function app_external_form_header($form)
{
    $CI          = &get_instance();
    $assetsGroup = 'external-form';

    add_favicon_link_asset($assetsGroup);

    $CI->app_css->add('reset-css', 'assets/css/reset.min.css', $assetsGroup);

    $CI->app_css->add('roboto-css', 'assets/plugins/roboto/roboto.css', $assetsGroup);
    $CI->app_css->add('bootstrap-css', 'assets/plugins/bootstrap/css/bootstrap.min.css', $assetsGroup);

    if (is_rtl()) {
        $CI->app_css->add('bootstrap-rtl-css', 'assets/plugins/bootstrap-arabic/css/bootstrap-arabic.min.css', $assetsGroup);
    }

    $CI->app_css->add('datetimepicker-css', 'assets/plugins/datetimepicker/jquery.datetimepicker.min.css', $assetsGroup);
    $CI->app_css->add('colorpicker-css', 'assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css', $assetsGroup);
    $CI->app_css->add('fontawesome-css', 'assets/plugins/font-awesome/css/font-awesome.min.css', $assetsGroup);
    $CI->app_css->add('bootstrap-select-css', 'assets/plugins/bootstrap-select/css/bootstrap-select.min.css', $assetsGroup);
    $CI->app_css->add('forms-css', base_url($CI->app_css->core_file('assets/css', 'forms.css')) . '?v=' . $CI->app_css->core_version(), $assetsGroup);

    if (file_exists(FCPATH . 'assets/css/custom.css')) {
        $CI->app_css->add('custom-css', base_url('assets/css/custom.css'), $assetsGroup);
    }

    echo app_compile_css($assetsGroup);

    if (get_option('recaptcha_secret_key') != '' && get_option('recaptcha_site_key') != '' && $form->recaptcha == 1) {
        echo "<script src='https://www.google.com/recaptcha/api.js'></script>" . PHP_EOL;
    }

    hooks()->do_action('app_external_form_head');
}

/**
 * Init admin head
 * @param  boolean $aside should include aside
 */
function init_head($aside = true)
{
    $CI = &get_instance();
    $CI->load->view('admin/includes/head');
    $CI->load->view('admin/includes/header', ['startedTimers' => $CI->misc_model->get_staff_started_timers()]);
    $CI->load->view('admin/includes/setup_menu');
    if ($aside == true) {
        $CI->load->view('admin/includes/aside');
    }
}
/**
 * Init admin footer/tails
 */
function init_tail()
{
    $CI = &get_instance();
    $CI->load->view('admin/includes/scripts');
}

/**
 * Get company logo from uploads folder
 * @param  string $uri        uri to append in the url
 * @param  string $href_class additional href class
 * @param  string $type       dark logo or light logo
 * @return mixed             string
 */
function get_company_logo($uri = '', $href_class = '', $type = '')
{
    $company_logo = get_option('company_logo' . ($type == 'dark' ? '_dark' : ''));
    $company_name = get_option('companyname');

    if ($uri == '') {
        $logoURL = site_url();
    } else {
        $logoURL = site_url($uri);
    }

    $logoURL = hooks()->apply_filters('logo_href', $logoURL);

    if ($company_logo != '') {
        $logo = '<a href="' . $logoURL . '" class="logo img-responsive' . ($href_class != '' ? ' ' . $href_class : '') . '">
            <img src="' . base_url('uploads/company/' . $company_logo) . '" class="img-responsive" alt="' . $company_name . '">
        </a>';
    } elseif ($company_name != '') {
        $logo = '<a href="' . $logoURL . '" class="' . $href_class . ' logo logo-text">' . $company_name . '</a>';
    } else {
        $logo = '';
    }

    $logo = hooks()->apply_filters('company_logo', $logo);

    echo $logo;
}
/**
 * Output company logo dark
 * @param  string $uri        uri to append to url
 * @param  string $href_class additional class for href
 * @return string
 */
function get_dark_company_logo($uri = '', $href_class = '')
{
    if (get_option('company_logo_dark') == '') {
        return get_company_logo($uri, $href_class);
    }

    return get_company_logo($uri, $href_class, 'dark');
}
/**
 * Generate small icon button / font awesome
 * @param  string $url        href url
 * @param  string $type       icon type
 * @param  string $class      button class
 * @param  array  $attributes additional attributes
 * @return string
 */
function icon_btn($url = '', $type = '', $class = 'btn-default', $attributes = [])
{
    $_url = '#';
    if (_startsWith($url, 'http')) {
        $_url = $url;
    } elseif ($url !== '#') {
        $_url = admin_url($url);
    }

    return '<a href="' . $_url . '" class="btn ' . $class . ' btn-icon"' . _attributes_to_string($attributes) . '>
            <i class="fa fa-' . $type . '"></i>
        </a>';
}

/**
 * Strip tags
 * @param  string $html string to strip tags
 * @return string
 */
function _strip_tags($html)
{
    return strip_tags($html, '<br>,<em>,<p>,<ul>,<ol>,<li>,<h4><h3><h2><h1>,<pre>,<code>,<a>,<img>,<strong>,<b>,<blockquote>,<table>,<thead>,<th>,<tr>,<td>,<tbody>,<tfoot>');
}

function no_index_customers_area()
{
    hooks()->add_action('app_customers_head', '_inject_no_index');
}

function _inject_no_index()
{
    echo '<meta name="robots" content="noindex">' . PHP_EOL;
}

function admin_body_class($class = '')
{
    echo 'class="' . join(' ', get_admin_body_class($class)) . '"';
}

function get_admin_body_class($class = '')
{
    $classes   = [];
    $classes[] = 'app';
    $classes[] = 'admin';
    $classes[] = $class;

    $ci = &get_instance();

    $first_segment  = $ci->uri->segment(1);
    $second_segment = $ci->uri->segment(2);
    $third_segment  = $ci->uri->segment(3);

    $classes[] = $first_segment;

    // Not valid eq users/1 - ID
    if ($second_segment != '' && !is_numeric($second_segment)) {
        $classes[] = $second_segment;
    }

    // Not valid eq users/edit/1 - ID
    if ($third_segment != '' && !is_numeric($third_segment)) {
        $classes[] = $third_segment;
    }

    if (is_staff_logged_in()) {
        $classes[] = 'user-id-' . get_staff_user_id();
    }

    $classes[] = strtolower($ci->agent->browser());

    if (is_mobile()) {
        $classes[] = 'mobile';
        $classes[] = 'hide-sidebar';
    }

    if (is_rtl()) {
        $classes[] = 'rtl';
    }

    $classes = hooks()->apply_filters('admin_body_class', $classes);

    return array_unique($classes);
}
