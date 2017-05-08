$(document).ready(function(){
                       // prevent cut , copy and past operations or readonly attributes 
$('.readonly').bind("cut copy paste",function(e) {
    e.preventDefault();
});
                     

                     
$('.numbersOnly').keypress(function (e) {
    var regex = new RegExp("^[0-9\b]+$");
    var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
    if (regex.test(str)) {
        return true;
    }

    e.preventDefault();
    return false;
});

 
                     
$('.isfloat').keypress(function (e) {
    var regex = new RegExp("^[0-9.\b]+$");
    var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
    if (regex.test(str)) {
        return true;
    }

    e.preventDefault();
    return false;
});

                     
$('.isArabicAndEnglishletters').keypress(function (e) {
    var regex = new RegExp("^[a-zA-Z\u0600-\u06FF \b]+$");
    var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
    if (regex.test(str)) {
        return true;
    }

    e.preventDefault();
    return false;
});






$('.isArabicletters').keypress(function (e) {
    var regex = new RegExp("^[\u0600-\u06FF \b]+$");
    var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
    if (regex.test(str)) {
        return true;
    }

    e.preventDefault();
    return false;
});

$('.isEnglishletters').keypress(function (e) {
    var regex = new RegExp("^[a-zA-Z \b]+$");
    var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
    if (regex.test(str)) {
        return true;
    }

    e.preventDefault();
    return false;
});


$(".readonly").keydown(function(e){
e.preventDefault();
});


  $(document).on('focus', ':input', function() {
    $(this).attr('autocomplete', 'off');
  });




                  /* $('.isArabicAndEnglishletters').keyup(function () { 
                   this.value = this.value.replace(/[^a-zA-Z\u0600-\u06FF \.]/g,'');
                     });*/
            
                /*   $('.numbersOnly').keyup(function () { 
                   this.value = this.value.replace(/[^0-9\.]/g,'');
                     });
                     
                   $('.isfloat').keyup(function () { 
                   this.value = this.value.replace(/[^0-9.\.]/g,'');
                     });*/
                     
                  /* $('.isArabicletters').keyup(function () { 
                   this.value = this.value.replace(/[^\u0600-\u06FF \.]/g,'');
                     });
                     
                   $('.isEnglishletters').keyup(function () { 
                   this.value = this.value.replace(/[^a-zA-Z \.]/g,'');
                     });
                      */
           
});
                     
   