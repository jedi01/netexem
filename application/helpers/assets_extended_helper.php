<?php


/**
 * Register active customers area theme hook to initialize CSS/Javascript assets
 * This function should be called only once from the theme functions.php file
 * @param  string $function function to call
 * @return boolean
 */
function extend_admin_assets($function)
{
    $CI = &get_instance();
	
	$apiKey =  get_option('google_api_key'); 
    // Input Mask
    $CI->app_scripts->add('input-mask-js', 'assets/plugins/jquery-input-mask/jquery-input-mask-phone-number.js');
    $CI->app_scripts->add('google-map-api', 'https://maps.googleapis.com/maps/api/js?key='.$apiKey.'&libraries=places&callback=initAutocomplete');

    $CI->app_css->add('notes-css', 'assets/css/custom_notes.css');


}
hooks()->add_action('app_admin_assets_added', 'extend_admin_assets');


function google_autocomplete_script(){
?>
<script type="text/javascript">
var placeSearch, autocomplete;

var componentForm = {
  street_number: 'short_name',
  route: 'long_name',
  locality: 'long_name',
  administrative_area_level_1: 'short_name',
  country: 'long_name',
  postal_code: 'short_name'
};




function initAutocomplete() {

  autocomplete = new google.maps.places.Autocomplete(document.getElementById('address'), {types: ['geocode']});
  autocomplete.setComponentRestrictions({'country': ['us']});
  autocomplete.addListener('place_changed', fillInAddress);

   autocomplete1 = new google.maps.places.Autocomplete(document.getElementById('billing_street'), {types: ['geocode']});
   autocomplete1.setComponentRestrictions({'country': ['us']});
   autocomplete1.addListener('place_changed', fillInAddress1);

   autocomplete2 = new google.maps.places.Autocomplete(document.getElementById('shipping_street'), {types: ['geocode']});
   autocomplete2.setComponentRestrictions({'country': ['us']});
   autocomplete2.addListener('place_changed', fillInAddress2);

}

function fillInAddress() {
  var place = autocomplete.getPlace();
  for (var i = 0; i < place.address_components.length; i++) {
    var addressType = place.address_components[i].types[0];
    if (componentForm[addressType]) {
      var val = place.address_components[i][componentForm[addressType]];
      if (addressType == "route") {
         $(".street_number").val($(".street_number").val()+' '+val)

      }else{
         $("."+addressType).val(val);   
      }
      
    }
  }

}

function fillInAddress1() {
  var place1 = autocomplete1.getPlace();
  for (var i = 0; i < place1.address_components.length; i++) {
    var addressType = place1.address_components[i].types[0];
    if (componentForm[addressType]) {
      var val = place1.address_components[i][componentForm[addressType]];
       if (addressType == "route") {
         $(".street_number1").val($(".street_number1").val()+' '+val)

      }else{
         $("."+addressType+"1").val(val);   
      }
      
    }
  }

}


function fillInAddress2() {
  var place2 = autocomplete2.getPlace();
  for (var i = 0; i < place2.address_components.length; i++) {
    var addressType = place2.address_components[i].types[0];
    if (componentForm[addressType]) {
      var val = place2.address_components[i][componentForm[addressType]];
      if (addressType == "route") {
         $(".street_number2").val($(".street_number2").val()+' '+val)

      }else{
         $("."+addressType+"2").val(val);   
      }
    }
  }

}
</script>


<?php

}

hooks()->add_action('before_js_scripts_render', 'google_autocomplete_script');

