// Filter run
! function(i) {
    var o, n;
    i(".title_block").on("click", function() {
        o = i(this).parents(".accordion_item"), n = o.find(".info"),
            o.hasClass("active_block") ? (o.removeClass("active_block"),
                n.slideUp()) : (o.addClass("active_block"), n.stop(!0, !0).slideDown(),
                o.siblings(".active_block").removeClass("active_block").children(
                    ".info").stop(!0, !0).slideUp())
    })
}(jQuery);

// add Accordion
$('.ac').dcAccordion({
    speed: 300
});

// Run carousel
$(function(){
    $('.carousel').carousel({
        interval: 3000,
        pause: 'hover'
    });
});

// Subscription for news
$(function(){

    $('#btn-subscription').click(function (){

        var email = $.trim($('.subscription').val());
        if(email != '') {
            var pattern = /^([a-z0-9_\.-])+@[a-z0-9-]+\.([a-z]{2,4}\.)?[a-z]{2,4}$/i;
            if(email.match(pattern)){

                $.ajax({
                    url: '/ajax/subscription',
                    type: 'POST',
                    'cache':false,
                    data: {email:$(".subscription").val()},
                    success: function(res){
                       switch (res.result) {
                           case 0 : note('помилка обробки',0); break;
                           case 1 : note('підписка успішно здійснена',1); break;
                           case 2 : note('такий email уже існує',0); break;
                       }
                    },
                    error: function(res){
                        note('помилка обробки',0);
                        //console.log(res);
                    }
                });

            } else {
                note('вкажіть коректний email',0);
            }
       } else {
            note('поле не може бути пустим',0);
        }

    });

    function note(msg, flag) {
        var color = (flag ==0)?'#ffffff':'#00c100';
        return $('.subscription-note').css({'display':'block','color':color,'fontSize':'13px'}).
        find('small').remove().end().append(' <small>'+msg+'</small>');
    }
});

// Check field search if empty
$(function(){

    $('#form-search').submit(function (){
        if($('.field-search').val()=='') {
            return false;
        }
        return true;
    });

    $("#searchMain").autocomplete("/ajax/query", {
        delay:10,
        minChars:3,
        matchSubset:1,
        autoFill:true,
        matchContains:1,
        cacheLength:1,
        selectFirst:true,
        formatItem:liFormatQuery,
        maxItemsToShow:10
    });
});

function liFormatQuery (row, i, num) {

    var result = "<a href='void(0)' onclick='document.location.href=\"/search?keyword="+row[0]+"\"'>" + row[0] + "</a>"+" "+" (<span class='qnt'>"+row[1]+"</span>)";
    //var result = row[0] + " (<span class='qnt'>"+row[1]+"</span>)";
    return result;
}

// Nice scroll for pages
$(function(){
    $("html").niceScroll({
        cursoropacitymin:0,
        cursoropacitymax:1,
        touchbehavior:false,
        cursorwidth:"5px",
        cursorcolor:"#454648",
        cursorborder:"1px solid #454648",
        cursorborderradius:"5px"
    });
});









