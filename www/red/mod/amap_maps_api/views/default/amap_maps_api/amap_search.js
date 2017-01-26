define(function (require) {
    var elgg = require('elgg');
    var $ = require('jquery');
    require("amap_ma_oms_js");



    // Initialize map vars
    var map_settings = require("amap_maps_api/settings");
    var gm = google.maps;
    var map;
    var mapTypeIds = [];
    var markers = [];
    var markerBounds = new google.maps.LatLngBounds();
    var mc;
    var circle = new google.maps.Circle();

    // retrieve available map layers
    var layer_x = map_settings['layers'];
    $.each($.parseJSON(layer_x), function (item, value) {
        mapTypeIds.push(value);

    });

    $('#my_location').click(function () {
        if ($('#my_location').is(':checked')) {
            $('#autocomplete').val($('#user_location').val());
        } else {
            $('#autocomplete').val('');
        }
    });

    function SelectMarker(s_marker,s_markers) {
      for (var i = 0; i < s_markers.length; i++) {
        var s_icon=s_markers[i].getIcon();
        s_icon.fillOpacity= .8;
        s_icon.scale = .8;
        s_markers[i].setIcon(s_icon);
      }
      if (s_marker) {
        var s_icon=s_marker.getIcon();
        // s_icon.fillColor='red';
        s_icon.fillOpacity= 1;
        s_icon.scale = 1;
        s_marker.setIcon(s_icon);
      }
    }



    var icon_punto = {
         path: "m 17.333333,27.940003 c -5.948001,0 -10.7693329,-4.820001 -10.7693329,-10.768003 0,-5.950666 4.8213319,-10.7706632 10.7693329,-10.7706632 5.946663,0 10.769333,4.8199972 10.769333,10.7706632 0,5.948002 -4.82267,10.768003 -10.769333,10.768003 M 17.333333,0 C 7.7599976,0 0,7.7600013 0,17.333333 c 0,9.573336 17.333333,30.666668 17.333333,30.666668 0,0 17.333333,-21.093332 17.333333,-30.666668 C 34.666666,7.7600013 26.906665,0 17.333333,0 m 0,13.313333 c -2.128002,0 -3.857333,1.730668 -3.857333,3.857333 0,2.126668 1.729331,3.856003 3.857333,3.856003 2.126665,0 3.857333,-1.729335 3.857333,-3.856003 0,-2.126665 -1.730668,-3.857333 -3.857333,-3.857333 z",
        // path: "M65 103.8c13-3 26.6-12.7 33-23.8 5-8.3 7.7-20.5 6.8-29.3-1.3-13-5.4-21.6-15-31C79 8.7 70.7 5.2 55.6 5c-15-.2-24.6 3.7-35 14C8 31.8 3 46.3 6 62.4c5 28.4 32.4 47.7 59.2 41.5zm-5.7-16.3C64 76 64 67.5 59 56.7c-4.5-10-5.8-23.5-3-31.7 2.8-7.4 6-7.4 13.7.3 8.4 8 12 17.4 12 31.2 0 18-6.6 31.6-17.3 36.5-8.3 3.8-8.7 3.4-5-5.5zm-16 2.2C33.6 83.7 27.5 70 27.5 54c0-11.4 2.6-20.7 7.8-27.2 4.3-5.4 12-11 15.7-11 2 0 1.7 1-1.2 8.2-4.6 11.2-4.6 20 0 30 5 10 6 21 3 31C51.6 89 50 92 49 92c-.8 0-3.4-1-5.7-2.5z",
        fillColor: '#fff',
        fillOpacity: .8,
        anchor: new google.maps.Point(17,48),
        strokeWeight: 1,
        scale: .8,
        rotation: 0
    }

    var icon_punto_completo = {
         path: "m 17.333333,27.940003 c -5.948001,0 -10.7693329,-4.820001 -10.7693329,-10.768003 0,-5.950666 4.8213319,-10.7706632 10.7693329,-10.7706632 5.946663,0 10.769333,4.8199972 10.769333,10.7706632 0,5.948002 -4.82267,10.768003 -10.769333,10.768003 M 17.333333,0 C 7.7599976,0 0,7.7600013 0,17.333333 c 0,9.573336 17.333333,30.666668 17.333333,30.666668 0,0 17.333333,-21.093332 17.333333,-30.666668 C 34.666666,7.7600013 26.906665,0 17.333333,0 m 0,13.313333 c -2.128002,0 -3.857333,1.730668 -3.857333,3.857333 0,2.126668 1.729331,3.856003 3.857333,3.856003 2.126665,0 3.857333,-1.729335 3.857333,-3.856003 0,-2.126665 -1.730668,-3.857333 -3.857333,-3.857333 z",
        // path: "M65 103.8c13-3 26.6-12.7 33-23.8 5-8.3 7.7-20.5 6.8-29.3-1.3-13-5.4-21.6-15-31C79 8.7 70.7 5.2 55.6 5c-15-.2-24.6 3.7-35 14C8 31.8 3 46.3 6 62.4c5 28.4 32.4 47.7 59.2 41.5zm-5.7-16.3C64 76 64 67.5 59 56.7c-4.5-10-5.8-23.5-3-31.7 2.8-7.4 6-7.4 13.7.3 8.4 8 12 17.4 12 31.2 0 18-6.6 31.6-17.3 36.5-8.3 3.8-8.7 3.4-5-5.5zm-16 2.2C33.6 83.7 27.5 70 27.5 54c0-11.4 2.6-20.7 7.8-27.2 4.3-5.4 12-11 15.7-11 2 0 1.7 1-1.2 8.2-4.6 11.2-4.6 20 0 30 5 10 6 21 3 31C51.6 89 50 92 49 92c-.8 0-3.4-1-5.7-2.5z",
        fillColor: '#e9d9a6',
        fillOpacity: 1,
        anchor: new google.maps.Point(17,48),
        strokeWeight: 1,
        scale: .8,
        rotation: 0
    }

    var icon_paso = {
        path: "M16 26.7c10.5-2.2 14.6-14.5 7.4-22.2C15.6-4 2.2 0 .2 11.5-1 18.2 3.6 25 10.5 26.5c2.3.6 3.2.6 5.5.2zm-1.4-3c-.5-1-.5-2 0-3s.6-1 2.4-.6c1.2.5 1.3.6 1.2 1.5-.6 2.3-2.8 3.6-3.6 2zm2-5c-.5 0-1.8-1-1.3-1l-.2-2c-.8-4 1-7.8 3.6-7 2 .8 2.3 5.3.7 9-.5 1.4-.8 1.5-2.6 1zm-6.6-1c-.6-.4-.8-1-.8-2 0-1.3 0-1.4 1.2-1.7 1.6-.4 2 0 2.3 1.8.3 2.2-1 3.2-2.7 2zm-2-5C6.7 10 6.4 5 7.4 3.4c.4-.7.8-.8 1.8-.7 2.3.2 3.4 3.3 2.7 7.8-.3 1.5-.5 1.8-1.3 2-.5 0-1.2.3-1.6.4-.5 0-.8 0-1-.4z",
        fillColor: '#fff',
        fillOpacity: .8,
        anchor: new google.maps.Point(13,13),
        strokeWeight: 1,
        scale: .8,
        rotation: 0
    }

    var icon_paso_completo = {
        path: "M16 26.7c10.5-2.2 14.6-14.5 7.4-22.2C15.6-4 2.2 0 .2 11.5-1 18.2 3.6 25 10.5 26.5c2.3.6 3.2.6 5.5.2zm-1.4-3c-.5-1-.5-2 0-3s.6-1 2.4-.6c1.2.5 1.3.6 1.2 1.5-.6 2.3-2.8 3.6-3.6 2zm2-5c-.5 0-1.8-1-1.3-1l-.2-2c-.8-4 1-7.8 3.6-7 2 .8 2.3 5.3.7 9-.5 1.4-.8 1.5-2.6 1zm-6.6-1c-.6-.4-.8-1-.8-2 0-1.3 0-1.4 1.2-1.7 1.6-.4 2 0 2.3 1.8.3 2.2-1 3.2-2.7 2zm-2-5C6.7 10 6.4 5 7.4 3.4c.4-.7.8-.8 1.8-.7 2.3.2 3.4 3.3 2.7 7.8-.3 1.5-.5 1.8-1.3 2-.5 0-1.2.3-1.6.4-.5 0-.8 0-1-.4z",
        fillColor: '#e9d9a6',
        fillOpacity: .8,
        anchor: new google.maps.Point(13,13),
        strokeWeight: 1,
        scale: .8,
        rotation: 0
    }

    var icon_activacion_ysu = {
        path: "M15 0l.2.3c0 .5.3 1.4.8 2.8.3 1 .8 2.3 1.5 3.8.8 1.8 2 4 3.5 6.2 1.5-2.2 3.3-4.4 5.7-6.3.2 0 .3-.3.5-.4A15 15 0 0 0 15 0zm0 0zm0 0A15 15 0 0 0 2.8 6.3c0 .2.3.3.4.4C5.6 8.7 7.5 11 9 13c1.5-2.3 2.7-4.4 3.5-6.2L14 3l.8-2.6c0-.3 0-.4.2-.4zm0 4l-1 3.4c-.7 2.2-2 5-3.7 7.7 2 3 3 6 3.8 8.2.5 1.3.8 2.4 1 3.3l.8-3.3c.8-2.3 2-5 3.8-8-1.7-3-3-5.6-3.7-7.8C15.4 6 15 5 15 4zM1.4 8.7A15 15 0 0 0 0 15a15 15 0 0 0 1.4 6.2c2.4-1.8 4.5-4 6-6.2C6 13 4 10.6 1.7 9c0-.2-.2-.2-.2-.2zm27.2 0h-.2c-2.4 2-4.3 4-6 6.2 1.7 2.2 3.8 4.4 6.2 6.2A15 15 0 0 0 30 15a15 15 0 0 0-1.4-6.2zM9 17c-1.6 2.3-3.6 4.6-6 6.5h-.2A15 15 0 0 0 15 30l-.2-.3v-.4l-.7-2-1.3-3.5c-1-2-2-4.2-3.7-6.7zm12 0c-1.6 2.6-2.8 5-3.7 6.8L16 27.3l-.7 2c0 .2 0 .3-.2.4v.3a15 15 0 0 0 12.2-6.3v-.2c-2.7-2-4.6-4.2-6.2-6.4zm-6 13z",
        fillColor: '#fff',
        fillOpacity: .8,
        anchor: new google.maps.Point(26,48),
        strokeWeight: 0,
        scale: .8,
        rotation: 0
    }

    var icon_activacion = {
        path: "M15 0C6.7 0 0 6.7 0 15s6.7 15 15 15 15-6.7 15-15S23.3 0 15 0zm.2 2.2c.3 0 .6 0 .7.4l.2 1.2v8.7h-1.7c-.2 0-.2-.3-.2-.4V7 3.4v-.7c.2-.3.5-.5.8-.5h.2zm3 2c.3-.2.5 0 .6.5L19 7c0 2 0 3.8.2 5.6v1.7s0 .3-.2.5l-.8-1c-1.6-1-1.3-1-1.3-1.6V12v-.3-4.4l.3-2.4c0-.4.2-.7.5-1h.4zm-4 9h.2c1 .2 1.6.5 2.5.6 0 0 0 .2.2.3 1.2 1.6 2 3 2.5 5v.4l-1.5 3.2c-.5 1-.8 2-.8 3 0 .3 0 .4-.4.5-1.7.7-3.4.6-5 0-.4 0-.5 0-.5-.5 0-.7-.3-1.3-.8-1.8-.7-.7-1-1.5-1-2.4v-.5h.5c.8.6 1.5.5 2-.3.2-.4.4-.5.8-.4h.6c.8 0 1.3-.5 1.3-1.2l-.3-1.6-.3-.7c0-.4 0-.5.4-.5 1.2.5 1 .2 1 1.3.2.3.2.6.3 1 0 0 .2.3.5.3s.3-.3.3-.6v-1-.8c0-.4-.3-.6-.7-.7l-1-.3c-.5-.3-1-.7-1-1.3 0-.5 0-.7.3-.7zm-2.7.2c.2 0 .4 0 .6.2.2 0 .3.2.4.4l1.7 4.3c.2.3 0 .7-.2 1-.3 0-.7 0-1-.3-.2-.3-.5-.5-.6-.8l-1.2-3c0-.2 0-.5-.2-.8 0-.6.3-1 .7-1zM9.7 16c.3 0 .5 0 .7.4.6 1 1 2 1.3 3.2 0 .3 0 .6-.4.7-.4.2-.6 0-.8-.3l-.3-.3-1-2.6c-.3-.4 0-.8.2-1h.3z",
        fillColor: '#fff',
        fillOpacity: .8,
        anchor: new google.maps.Point(21,40),
        strokeWeight: 0,
        scale: .8,
        rotation: 0
    }

    var icon_encuentro = {
        path: "M15 0l.2.3c0 .5.3 1.4.8 2.8.3 1 .8 2.3 1.5 3.8.8 1.8 2 4 3.5 6.2 1.5-2.2 3.3-4.4 5.7-6.3.2 0 .3-.3.5-.4A15 15 0 0 0 15 0zm0 0zm0 0A15 15 0 0 0 2.8 6.3c0 .2.3.3.4.4C5.6 8.7 7.5 11 9 13c1.5-2.3 2.7-4.4 3.5-6.2L14 3l.8-2.6c0-.3 0-.4.2-.4zm0 4l-1 3.4c-.7 2.2-2 5-3.7 7.7 2 3 3 6 3.8 8.2.5 1.3.8 2.4 1 3.3l.8-3.3c.8-2.3 2-5 3.8-8-1.7-3-3-5.6-3.7-7.8C15.4 6 15 5 15 4zM1.4 8.7A15 15 0 0 0 0 15a15 15 0 0 0 1.4 6.2c2.4-1.8 4.5-4 6-6.2C6 13 4 10.6 1.7 9c0-.2-.2-.2-.2-.2zm27.2 0h-.2c-2.4 2-4.3 4-6 6.2 1.7 2.2 3.8 4.4 6.2 6.2A15 15 0 0 0 30 15a15 15 0 0 0-1.4-6.2zM9 17c-1.6 2.3-3.6 4.6-6 6.5h-.2A15 15 0 0 0 15 30l-.2-.3v-.4l-.7-2-1.3-3.5c-1-2-2-4.2-3.7-6.7zm12 0c-1.6 2.6-2.8 5-3.7 6.8L16 27.3l-.7 2c0 .2 0 .3-.2.4v.3a15 15 0 0 0 12.2-6.3v-.2c-2.7-2-4.6-4.2-6.2-6.4zm-6 13z",
        fillColor: '#fff',
        fillOpacity: .8,
        anchor: new google.maps.Point(7,28),
        strokeWeight: 0,
        scale: .8,
        rotation: 0
    }


    $(document).ready(function () {
        // Initialize map vars

        infowindow = new google.maps.InfoWindow();
        var myLatlng = new google.maps.LatLng(map_settings['d_location_lat'],map_settings['d_location_lon']);
        var mapOptions = {
            zoom: parseInt(map_settings['default_zoom']),
            center: myLatlng,
            mapTypeControlOptions: {
                mapTypeIds: mapTypeIds
            },
        };

        map = new gm.Map(document.getElementById("map"), mapOptions);
        map.setMapTypeId(map_settings['default_layer']);

        map.mapTypes.set("OSM", new google.maps.ImageMapType({
            getTileUrl: function(coord, zoom) {
                // See above example if you need smooth wrapping at 180th meridian
                return map_settings['osm_base_layer'] + zoom + "/" + coord.x + "/" + coord.y + ".png";
            },
            tileSize: new google.maps.Size(256, 256),
            name: "OpenStreetMap",
            maxZoom: 12
        }));

        // trigger the search button for making the initial search
        setTimeout(function() {
            $("#nearby_btn").trigger('click');

        },0);



        return false;
    });

    $('#nearby_btn').click(function () {
        // reset markers
        if (markers.length > 0) {
            for (var i = 0; i < markers.length; i++) {
              markers[i].setMap(null);
            }
            markers = [];
            markerBounds = new google.maps.LatLngBounds();

            if ((document.getElementById("map_indextable") == null) && (map_settings['cluster'])) {
                mc.clearMarkers();
            }
        }

        // reset search area, in case it exists
        circle.setMap(null);

        var btn_text = $(this).val();
        $(this).prop('value', 'Searching...');
        $(this).css("opacity", 0.7);

        // Spiderfier feature
        var oms = new OverlappingMarkerSpiderfier(map,{markersWontMove: true, markersWontHide: true, keepSpiderfied: true});

        var s_location = $('#autocomplete').val();
        var s_radius = $('#s_radius').val();
        var s_keyword = $('#s_keyword').val();
        var s_action = $('#s_action').val();
        var initial_load = $('#initial_load').val();
        var noofusers = $('#noofusers').val();
        var change_title = $('#change_title').val();
        var group_guid = $('#group_guid').val();
        var s_change_title = $('#s_change_title').val();
//console.log(s_change_title);
        var showradius;
        if ($('#showradius').is(':checked'))
            showradius = 1;
        else
            showradius = 0;

        if (isNaN(s_radius)) {
            elgg.register_error(elgg.echo('amap_maps_api:search:error:radius_invalid'));
            initSearchBtn(btn_text);
            return false;
        } else if (s_action == 'undefined' || s_action.length === 0) {
            elgg.register_error(elgg.echo('amap_maps_api:search:error:action_undefined'));
            initSearchBtn(btn_text);
            return false;
        } else {

            elgg.action(s_action, {
                data: {
                    s_location: s_location,
                    s_radius: s_radius,
                    s_keyword: s_keyword,
                    showradius: showradius,
                    initial_load: initial_load,
                    noofusers: noofusers,
                    s_change_title: s_change_title,
                    group_guid: group_guid
                },
                success: function (result) {
                    if (result.error) {
                        elgg.register_error(result.msg);

                    } else {
                        // console.log(result);

                        var line = false;
                        var lines = new Array(100);
                        var first = true;
                        var viaje = new Array(100);
                        var markers_groups = new Array();

                        $('#map_location').html(result.location);
                        $('#map_radius').html(result.radius);

                        if (s_location) {
                            $('#s_radius').val(result.s_radius);
                        }


                        if (initial_load == 'location') {
                            $('#my_location').prop('checked', true);
                        }

                        if (s_location && result.s_location_lat && result.s_location_lng) {
                            //console.log('aa'+s_location+' - '+result.s_location);
                            var myLatlng = new google.maps.LatLng(result.s_location_lat,result.s_location_lng);
                            var marker = new google.maps.Marker({
                                map: map,
                                position: myLatlng,
                                optimized: false,
                                icon: elgg.normalize_url('/mod/amap_maps_api/graphics/flag.png')
                            });
                            map.setCenter(marker.getPosition());

                            google.maps.event.addListener(marker, 'click', function() {
                                infowindow.setContent('Search address: '+s_location+'<br />Search radius: '+result.s_radius+' '+map_settings['unitmeas']);
                                infowindow.open(map, this);
                            });
                            markerBounds.extend(myLatlng);

                            oms.addMarker(marker);  // Spiderfier feature
                            markers.push(marker);
                            //console.log('aa'+showradius+' - '+result.s_radius);
                            if (showradius && result.s_radius_no > 0) {
                                circle = new google.maps.Circle({
                                  map: map,
                                  radius: result.s_radius_no,
                                  fillColor: 'yellow',
                                  fillOpacity: 0.2
                                });
                                // Bind circle and marker
                                circle.bindTo('center', marker, 'position');
                                map.fitBounds(circle.getBounds());
                            }
                        }

                        var result_x = result.map_objects;



                        $.each($.parseJSON(result_x), function (item, value) {

                            var myLatlng = new google.maps.LatLng(value.lat,value.lng);

                            var mostrar = true;
                            var clase = value.type;

                            switch(clase) {
                              case 'user':
                                var icono = value.map_icon;
                                break;
                              case 'group':
                                // console.log(value.estado);
                                if (value.estado == 'Completo') {
                                  if (value.tipo == 'paso') {
                                    console.log(value.guid + ' es paso completo' );
                                    var icono = icon_paso_completo;
                                  } else {
                                    // poder completo
                                    var icono = icon_punto_completo;
                                  }
                                } else {
                                  // Incompleto
                                  if (value.tipo == 'paso') {
                                    var icono = icon_paso;
                                    console.log(value.guid + ' es paso incompleto' );
                                  } else {
                                    // poder Incompleto
                                    var icono = icon_punto;
                                  }
                                }
                                break;
                              case 'objectevent':
                                mostrar = false;
                                switch(value.event_type) {
                                  case 'activacion-ysu':
                                    var icono = icon_activacion_ysu;
                                    break;
                                  case 'activacion':
                                    var icono = icon_activacion;
                                    break;
                                  case 'encuentro':
                                    var icono = icon_encuentro;
                                    break;
                                }
                                break;
                            }

                            var marker = new google.maps.Marker({
                                map: map,
                                position: myLatlng,
                                title: value.title,
                                // icon: value.map_icon,
                                icon: icono,
                                guid: value.guid,
                                type: clase,
                                event_type: value.event_type,
                                event_group: value.event_group,

                                orden: value.orden,
                                estado: value.estado,
                                tipo: value.tipo,

                                optimized: false,
                                visible: mostrar,
                                id: 'marker_'+value.guid
                            });



                            var myoverlay = new google.maps.OverlayView();
                            myoverlay.draw = function () {
                              this.getPanes().markerLayer.id='markerLayer';
                            };
                            myoverlay.setMap(map);

                            // console.log(marker);




                            google.maps.event.addListener(marker, 'click', function() {
                                infowindow.close();
                                infowindow.setContent('<div class="infowindow">'+value.info_window+'</div>');
                                infowindow.open(map, this);
                                currentMark = this;

                                // Resala el marker clickeado
                                SelectMarker(this,markers);

                                // Invisibliza los eventos en caso que no se click en un evento
                                if (this.type != 'objectevent') {
                                  for (var i = 0; i < markers.length; i++) {
                                    if (markers[i].type === 'objectevent') {
                                      markers[i].setVisible(false);
                                    }
                                  }
                                }

                                // Elimina las lineas entre grupo y evento si existen
                                if (line) {
                                  if (this.type != 'objectevent') {
                                    for (var i = 0; i < lines.length; i++) {
                                      if (lines[i]) {
                                        lines[i].setMap(null);
                                      }
                                    }
                                  }
                                }

                                // Dibuja lineas entre grupos y sus eventos
                                if (this.type === 'group') {
                                  var currentGroup = this.guid;
                                  for (var i = 0; i < markers.length; i++) {
                                    if (markers[i].event_group === currentGroup) {
                                      markers[i].setVisible(true);
                                      lines[i] = new google.maps.Polyline({
                                          path: [currentMark.position, markers[i].position],
                                          strokeColor: "#ccc",
                                          strokeOpacity: 0.8,
                                          strokeWeight: 3,
                                      });
                                      lines[i].setMap(map);
                                      line=true;
                                      // console.log(line);

                                    }
                                  }
                                }
                            });

                            google.maps.event.addListener(infowindow,'closeclick',function(){
                              SelectMarker(null,markers);

                              if (this.type != 'objectevent') {
                                for (var i = 0; i < markers.length; i++) {
                                  if (markers[i].type === 'objectevent') {
                                    markers[i].setVisible(false);
                                  }
                                  if (lines[i]) {
                                    lines[i].setMap(null);
                                  }
                                }
                              }
                            });


                            oms.addMarker(marker);  // Spiderfier feature
                            markers.push(marker);
                            // console.log(markers);

                            if (!showradius)    {
                                markerBounds.extend(myLatlng);
                                map.fitBounds(markerBounds);
                            }

                        });


                        // Dibuja lineas entre grupos

                        for (var i = 0; i < markers.length; i++) {
                          if (markers[i].type === 'group') {
                            markers_groups.push(markers[i]);
                          }
                        }
                        markers_groups.sort(function(a,b) {return (a.orden > b.orden) ? 1 : ((b.orden > a.orden) ? -1 : 0);} );
                        console.log(markers_groups);

                        for (var i = 0; i < markers_groups.length; i++) {
                          if (markers_groups[i].type === 'group') {

                            if (markers_groups[i].estado === 'Completo') {
                              var line_color = "#eac55d";
                            } else {
                              var line_color = "#e9d9a6";
                            }

                            j = i + 1;
                            if (j != markers_groups.length) {
                              viaje[i] = new google.maps.Polyline({
                                path: [markers_groups[i].position, markers_groups[j].position],
                                strokeColor: line_color,
                                strokeOpacity: 0.8,
                                strokeWeight: 7,
                                geodesic: true,
                              });
                              var anterior = markers_groups[i].position;
                              viaje[i].setMap(map);
                              // console.log(line);

                            }
                          }
                        }




                        // If in Global Map

                        if ((document.getElementById("map_indextable") == null) && (map_settings['cluster'])) {
                            mcOptions = {
                                styles: [
                                    {
                                        height: 53,
                                        url: elgg.normalize_url('/mod/amap_maps_api/vendors/js-marker-clusterer/images/m1.png'),
                                        width: 53
                                    },
                                    {
                                        height: 56,
                                        url: elgg.normalize_url('/mod/amap_maps_api/vendors/js-marker-clusterer/images/m2.png'),
                                        width: 56
                                    },
                                    {
                                        height: 66,
                                        url: elgg.normalize_url('/mod/amap_maps_api/vendors/js-marker-clusterer/images/m3.png'),
                                        width: 66
                                    },
                                    {
                                        height: 78,
                                        url: elgg.normalize_url('/mod/amap_maps_api/vendors/js-marker-clusterer/images/m4.png'),
                                        width: 78
                                    },
                                    {
                                        height: 90,
                                        url: elgg.normalize_url('/mod/amap_maps_api/vendors/js-marker-clusterer/images/m5.png'),
                                        width: 90
                                    }
                                ],
                                maxZoom: map_settings['cluster_zoom']
                            };
                            //init clusterer with your options
                            mc = new MarkerClusterer(map, markers, mcOptions);
                        }

                        if (result.sidebar) {
                            $('#map_side_entities').html(result.sidebar);

                            $('.map_entity_block').click(function() {
                                var tmp_attr = $(this).find('a.entity_m');
                                var object_id = tmp_attr.attr('id');
                                for (var i = 0; i < markers.length; i++) {
                                    if (markers[i].id === "marker_" + object_id) {
                                        var latLng = markers[i].getPosition(); // returns LatLng object
                                        google.maps.event.trigger(markers[i], 'click');
                                        break;
                                    }
                                }
                            });

                            $('.map_entity_block a.entity_m').click(function() {
                                var object_id = $(this).attr('id');
                                for (var i = 0; i < markers.length; i++) {
                                    if (markers[i].id === "marker_" + object_id) {
                                        var latLng = markers[i].getPosition(); // returns LatLng object
                                        google.maps.event.trigger(markers[i], 'click');
                                        break;
                                    }
                                }
                            });
                        }

                        // If in Global Map
                        if(document.getElementById("map_indextable") !== null) {

                          $('#chbx_user').click(function() {
                            if ($(this).is(':checked')) {
                              var state = true;
                            } else {
                              var state = false;
                            }
                            for (var i = 0; i < markers.length; i++) {
                                if (markers[i].type === "user") {
                                    markers[i].setVisible(state);
                                }
                            }
                          });

                          $('#chbx_group').click(function() {
                            if ($(this).is(':checked')) {
                              var state = true;
                            } else {
                              var state = false;
                            }
                            for (var i = 0; i < markers.length; i++) {
                                if (markers[i].type === "group") {
                                    markers[i].setVisible(state);
                                }
                            }
                          });

                          $('#chbx_pages').click(function() {
                            if ($(this).is(':checked')) {
                              var state = true;
                            } else {
                              var state = false;
                            }
                            for (var i = 0; i < markers.length; i++) {
                                if (markers[i].type === "objectpage_top") {
                                    markers[i].setVisible(state);
                                }
                            }
                          });

                          $('#chbx_events').click(function() {
                            if ($(this).is(':checked')) {
                              var state = true;
                            } else {
                              var state = false;
                            }
                            for (var i = 0; i < markers.length; i++) {
                                if (markers[i].type === "objectevent") {
                                    markers[i].setVisible(state);
                                }
                            }
                          });
                        }


                    }
                },
                complete: function () {
                    // bring search button to normal
                    initSearchBtn(btn_text);

                    // set empty the initial input so it will not be used by search form
                    $('#initial_load').val('');
                 }

            });
        }

        return false;
    });

});

function initSearchBtn(btn_text) {
    $("#nearby_btn").prop('value', btn_text);
    $("#nearby_btn").css("opacity", 1);
}
