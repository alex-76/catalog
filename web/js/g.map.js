var GM = {

    init: function () {
        this.initMap();
    },

    geocoder: function (name,address,tel,email,site) {

        geocoder.geocode( {'address': address}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK)
            {
                map.setCenter(results[0].geometry.location);

                var image = new google.maps.MarkerImage('/images/marker.png',
                    // This marker is 20 pixels wide by 32 pixels tall.
                    new google.maps.Size(40, 42),
                    // The origin for this image is 0,0.
                    new google.maps.Point(0,0),
                    // The anchor for this image is the base of the flagpole at 0,32.
                    new google.maps.Point(0, 32));

                var marker = new google.maps.Marker({
                    map: map,
                    icon: image,
                    position: results[0].geometry.location,
                    title: name
                });

                var contentString = '<div style="font-size:12px;">'+
                    '<b>Компанія:</b> '+ name + '<br>' +
                    '<b>Адреса:</b> '  + address + '<br>' +
                    '<b>Тел:</b> '     + tel + '<br>' +
                    '<b>Email:</b> '   + email + '<br>' +
                    '<b>Сайт:</b> '    + site +
                '</div>';
                var infowindow = new google.maps.InfoWindow({
                    content: contentString
                });

                infowindow.open(map,marker);

                google.maps.event.addListener(infowindow,'closeclick',function(){
                    marker.setAnimation(google.maps.Animation.BOUNCE);
                });

                marker.addListener('click', function () {
                    marker.setAnimation(null);
                });

                google.maps.event.addListener(marker, 'click', function() {
                    infowindow.open(map,marker);
                });
            } else {
                alert("Geocode was not successful for the following reason: " + status);
            }
        });
    },

    initMap: function () {

        geocoder = new google.maps.Geocoder();
        var myOptions = {
            zoom: 17,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };

        $.ajax({
            url: '/ajax/info',
            type: 'POST',
            'cache':false,
            data: {id:$('#postID').text()},
            success: function(res){
                GM.geocoder(res.name,res.address,res.tel,res.email,res.site);
            },
            error: function(res){
                console.log(res);
            }
        });
        map = new google.maps.Map(document.getElementById("map"), myOptions);
    }
};

$(function(){
    GM.init();
});
