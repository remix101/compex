// Execute JavaScript on page load
$(function() {
    // Initialize phone number text input plugin
    $('#inputPhone').intlTelInput({
        responsiveDropdown: true,
        autoFormat: true,
        defaultCountry: "ng",
        utilsScript: '/vendor/intl-phone/libphonenumber/build/utils.js'
    });
    
    $('#inputPhone').on('blur', function(e){
        $('#inputPhone').intlTelInput("setNumber", inputPhone.value);
    });
});