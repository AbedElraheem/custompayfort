
function getPaymentPage(paymentMethod , $URL) {
    
    var check3ds = getUrlParameter('3ds');
    var url = $URL;
    if(check3ds == 'no') {
       url = url+'&3ds=no'; 
    }
    
    jQuery.ajax({
       url: url, 
       type: 'post',
       dataType: 'json',
       data: {paymentMethod: paymentMethod},
       success: function (response) {
        
            if (response.form) {
                jQuery('body').append(response.form);
                if(response.paymentMethod == 'cc_merchantpage' || response.paymentMethod == 'installments_merchantpage') {
                    showMerchantPage(response.url);
                }
                else if(response.paymentMethod == 'cc_merchantpage2') {
                    var expDate = jQuery('#payfort_fort_mp2_expiry_year').val()+''+jQuery('#payfort_fort_mp2_expiry_month').val();
                    var mp2_params = {};
                    mp2_params.card_holder_name = jQuery('#payfort_fort_mp2_card_holder_name').val();
                    mp2_params.card_number = jQuery('#payfort_fort_mp2_card_number').val();
                    mp2_params.expiry_date = expDate;
                    mp2_params.card_security_code = jQuery('#payfort_fort_mp2_cvv').val();
                    jQuery.each(mp2_params, function(k, v){
                        jQuery('<input>').attr({
                            type: 'hidden',
                            id: k,
                            name: k,
                            value: v
                        }).appendTo('#payfort_payment_form'); 
                    });
                    jQuery('#payfort_payment_form input[type=submit]').click();
                }
                else{
                    jQuery('#payfort_payment_form input[type=submit]').click();
                }
            }
       }
    });
}
function showMerchantPage(merchantPageUrl) {
    if(jQuery("#payfort_merchant_page").size()) {
        jQuery( "#payfort_merchant_page" ).remove();
    }
    jQuery('<iframe name="payfort_merchant_page" id="payfort_merchant_page" height="630px" width="100%" frameborder="0" scrolling="no"></iframe>').appendTo('#pf_iframe_content');
    
    jQuery( "#payfort_merchant_page" ).attr("src", merchantPageUrl);
    jQuery( "#payfort_payment_form" ).attr("action", merchantPageUrl);
    jQuery( "#payfort_payment_form" ).attr("target","payfort_merchant_page");
    jQuery( "#payfort_payment_form" ).attr("method","POST");
    jQuery('#payfort_payment_form input[type=submit]').click();
    //jQuery( "#payfort_payment_form" ).submit();
    jQuery( "#div-pf-iframe" ).show();
}

var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
};


var payfortFort = (function () {
   return {
        validateCreditCard: function(element) {
            var isValid = false;
            var eleVal = jQuery(element).val();
            eleVal = this.trimString(element.val());
            eleVal = eleVal.replace(/\s+/g, '');
            jQuery(element).val(eleVal);
            jQuery(element).validateCreditCard(function(result) {
                /*jQuery('.log').html('Card type: ' + (result.card_type == null ? '-' : result.card_type.name)
                         + '<br>Valid: ' + result.valid
                         + '<br>Length valid: ' + result.length_valid
                         + '<br>Luhn valid: ' + result.luhn_valid);*/
                isValid = result.valid;
            });
            return isValid;
        },
        validateCardHolderName: function(element) {
            jQuery(element).val(this.trimString(element.val()));
            var cardHolderName = jQuery(element).val();
            if(cardHolderName.length > 50) {
                return false;
            }
            return true;
        },
        validateCvc: function(element) {
            jQuery(element).val(this.trimString(element.val()));
            var cvc = jQuery(element).val();
            if(cvc.length > 4 || cvc.length == 0) {
                return false;
            }
            if(!this.isPosInteger(cvc)) {
                return false;
            }
            return true;
        },
        isDefined: function(variable) {
            if (typeof (variable) === 'undefined' || typeof (variable) === null) {
                return false;
            }
            return true;
        },
        trimString: function(str){
            return str.trim();
        },
        isPosInteger: function(data) {
            var objRegExp  = /(^\d*jQuery)/;
            return objRegExp.test( data );
        }
   };
})();

var payfortFortMerchantPage2 = (function () {
    return {
        validateCcForm: function () {
            this.hideError();
            var isValid = payfortFort.validateCardHolderName(jQuery('#payfort_fort_mp2_card_holder_name'));
            if(!isValid) {
                this.showError('Invalid Card Holder Name');
                return false;
            }
            isValid = payfortFort.validateCreditCard(jQuery('#payfort_fort_mp2_card_number'));
            if(!isValid) {
                this.showError('Invalid Credit Card Number');
                return false;
            }
            isValid = payfortFort.validateCvc(jQuery('#payfort_fort_mp2_cvv'));
            if(!isValid) {
                this.showError('Invalid Card CVV');
                return false;
            }
            return true;
        },
        showError: function(msg) {
            alert(msg);
        },
        hideError: function() {
            return;
        }
    };
})();
