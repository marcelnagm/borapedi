"use strict";
console.log("Checkout JS includeded");
window.onload ? window.onload() : console.log("No other windowonload foound");
window.onload = function () {
    checkPrivacyPolicy();
    initAddress();
    initCOD();
    //getUserAddresses();

};

var checkPrivacyPolicy = function () {
    if (!$('#privacypolicy').is(':checked')) {

        $('.paymentbutton').attr("disabled", true);
    }
};

function notify(text, type) {
    $.notify.addStyle('custom', {
        html: "<div><strong><span data-notify-text /></strong></div>",
        classes: {
            base: {
                "position": "relative",
                "margin-bottom": "1rem",
                "padding": "1rem 1.5rem",
                "border": "1px solid transparent",
                "border-radius": ".375rem",

                "color": "#fff",
                "border-color": type == "success" ? "#4fd69c" : "#fc7c5f",
                "background-color": type == "success" ? "#4fd69c" : "#fc7c5f",
            },
            success: {
                "color": "#fff",
                "border-color": type == "success" ? "#4fd69c" : "#fc7c5f",
                "background-color": type == "success" ? "#4fd69c" : "#fc7c5f",
            }
        }
    });

    $.notify(text, {
        position: "bottom right",
        style: 'custom',
        className: 'success',
        autoHideDelay: 5000,
    }
    );
}


$("#privacypolicy").change(function () {
    if (this.checked) {
        if (validateOrderFormSubmit()) {


            if (no_phone == false) {
                if ($('#phone').val().length >= 14) {
                    $('.paymentbutton').attr("disabled", false);
                    console.log("Hab botao");
                } else {
                    $('.paymentbutton').attr("disabled", true);
                    $("#privacypolicy").prop("checked", false);
                    if ($('#phone').val().length < 14) {
                        notify('Preencha o Telefone', 'error');
                    }
                }
            }
            if (no_phone == true) {
                $('.paymentbutton').attr("disabled", false);
            }
        } else {
            $("#privacypolicy").prop("checked", false);
            $('.paymentbutton').attr("disabled", true);
        }

    }
});

var validateAddressInArea = function (positions, area) {
    var paths = [];

    if (area !== null) {
        area.forEach(location =>
            paths.push(new google.maps.LatLng(location.lat, location.lng))
        );
    }
    var delivery_area = new google.maps.Polygon({paths: paths});

    if (area != null) {
        Object.keys(positions).map(function (key, index) {
            //alert("OK")
            setTimeout(function () {
                var belongsToArea = google.maps.geometry.poly.containsLocation(new google.maps.LatLng(positions[key].lat, positions[key].lng), delivery_area);

                if (belongsToArea === false) {
                    $('#address' + key).attr('disabled', 'disabled');
                }
            }, 100);
        });
    }
}




//JS FORM Validate functions
var validateOrderFormSubmit = function () {
    var deliveryMethod = $('input[name="deliveryType"]:checked').val();
    var paymentMethod = $('#paymentType').find(":selected").val();
    ;
//
//    console.log(paymentMethod);
//    console.log(paymentMethod === 'cod');

    //If deliverty, we need to have selected address
    if (deliveryMethod == "delivery") {
        //console.log($("#addressID").val())
        if ($("#addressID").val()) {
            if (paymentMethod === 'card' || paymentMethod === 'cod' || paymentMethod === 'mercadopago') {
                return true;
            } else {
                notify('Selecione um método de pagamento', 'error');
                return false;
            }
        } else {
            notify('Selecione seu endereço', 'error');

            return false;
        }
    } else {
        if (paymentMethod === 'card' || paymentMethod === 'cod' && paymentMethod === 'mercadopago') {
            return true;
        } else {
            notify('Selecione um método de pagamento', 'error');
            return false;
        }
        return true;
    }
};

var initCOD = function () {
    console.log("Initialize COD");
    // Handle form submission  - for card.
//    var form = document.getElementById('order-form');
//    form.addEventListener('submit', async function (event) {        
//        console.log('prevented');
//        event.preventDefault();
//        console.log('prevented');
//        //IF delivery - we need to have selected address
//        if (validateOrderFormSubmit()) {
//            console.log('Form valid');
//            form.submit();
//        }
//    });
};

/**
 *
 * Payment Functions
 *
 */

/**
 *
 * Address Functions
 *
 */
var initAddress = function () {
    console.log("Address initialzing");

    var start = "https://cdn1.iconfinder.com/data/icons/Map-Markers-Icons-Demo-PNG/48/Map-Marker-Ball-Pink.png"
    var map = null;
    var markerData = null;
    var marker = null;

//    $("#new_address_map").hide();
    $("#new_address_spinner").hide();
    $("#address-info").hide();
    $("#submitNewAddress").hide();
    console.log("num_address = " + num_addresses);

    if (num_addresses == 0) {
        $('#modal-order-new-address').modal('show');
    } else if (num_addresses >= 1) {
        $("select[name='AddressID'] option:eq(2)").attr("selected", "selected");
        var deliveryCost = $("#addressID").find(':selected').data('cost');

        //We now need to pass this cost to some parrent funct for handling the delivery cost change
        chageDeliveryCost(deliveryCost);

    }
    //Change on Place entering
    $('select[id="new_address_checkout"]').change(function () {
        $("#new_address_checkout_holder").hide();
        var place_id = $("#new_address_checkout option:selected").val();
        var place_name = $("#new_address_checkout option:selected").text();
        console.log("Selected " + place_id);

        $("#address").show();
        $("#address").val(place_name);
        $("#new_address_map").show();
        $("#new_address_spinner").show();
        $("#address-info").show();
        $("#submitNewAddress").show();

        //Get Place lat/lng
        getPlaceDetails(place_id, function (isFetched, data) {
            if (isFetched) {
                var latAdd = data.lat;
                var lngAdd = data.lng;

                $('#lat').val(latAdd);
                $('#lng').val(lngAdd);


                var mapAddress = new google.maps.Map(document.getElementById('new_address_map'), {
                    zoom: 17,
                    center: new google.maps.LatLng(data.lat, data.lng)
                });

                var markerDataAddress = new google.maps.LatLng(data.lat, data.lng);
                var markerAddress = new google.maps.Marker({
                    position: markerDataAddress,
                    map: mapAddress,
                    icon: start,
                    title: data.name
                });

                mapAddress.addListener('click', function (event) {
                    var data = new google.maps.LatLng(event.latLng.lat(), event.latLng.lng());
                    markerAddress.setPosition(data);

                    var latAdd = event.latLng.lat();
                    var lngAdd = event.latLng.lng();

                    $('#lat').val(latAdd);
                    $('#lng').val(lngAdd);
                });
            }
        });

    });

    //Save on click for location
    $("#submitNewAddress").on("click", function () {

        var address_name = $("#address").val();
        var address_neigh = $("#address_neigh").val();
        var address_city = $("#address_city").val();
        var nick = $("#nick").val();
        var address_number = $("#numbero").val();
        var number_apartment = $("complement").val();
        var number_intercom = '';
        var entry = '';
        var floor = '';

        var lat = $("#lat").val();
        var lng = $("#lng").val();

        var doSubmit = true;
        var message = "";
        if (address_number.length < 1) {
            doSubmit = false;
            message += "\nPreencha o campo numero";
        }
        if (nick.length < 1) {
            doSubmit = false;
            message += "\nPreencha o campo apelido para o endereco";
        }

        if (!doSubmit) {
            notify(message, 'error');
            return false;
        } else {


            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'POST',
                url: '/addresses',
                data: {
                    new_address: address_number.length != 0 ? address_name + ", " + address_number + ", " + address_neigh + "- " + address_city : address_name + ", " + address_neigh + "- " + address_city,
                    lat: lat,
                    lng: lng,
                    apartment: number_apartment,
                    intercom: number_intercom,
                    nick: nick,
                    entry: entry,
                    floor: floor
                },
                success: function (response) {
                    if (response.status) {
                        //location.replace(response.success_url);
                        window.location.reload();
                    }
                }, error: function (response) {
                    //return callback(false, response.responseJSON.errMsg);
                }
            })
        }

    });
}


/**
 * Fetch lat / lng for specific google place id
 * @param {*} place_id
 * @param {*} callback
 */
function getPlaceDetails(place_id, callback) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: 'POST',
        url: '/new/address/details',
        data: {place_id: place_id},
        success: function (response) {
            if (response.status) {
                return callback(true, response.result)
            }
        }, error: function (response) {
            //return callback(false, response.responseJSON.errMsg);
        }
    });
}
