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



    var icon_nodo = {
        path: "m 17.333333,27.940003 c -5.948001,0 -10.7693329,-4.820001 -10.7693329,-10.768003 0,-5.950666 4.8213319,-10.7706632 10.7693329,-10.7706632 5.946663,0 10.769333,4.8199972 10.769333,10.7706632 0,5.948002 -4.82267,10.768003 -10.769333,10.768003 M 17.333333,0 C 7.7599976,0 0,7.7600013 0,17.333333 c 0,9.573336 17.333333,30.666668 17.333333,30.666668 0,0 17.333333,-21.093332 17.333333,-30.666668 C 34.666666,7.7600013 26.906665,0 17.333333,0 m 0,13.313333 c -2.128002,0 -3.857333,1.730668 -3.857333,3.857333 0,2.126668 1.729331,3.856003 3.857333,3.856003 2.126665,0 3.857333,-1.729335 3.857333,-3.856003 0,-2.126665 -1.730668,-3.857333 -3.857333,-3.857333 z",
        fillColor: '#fff',
        fillOpacity: .8,
        anchor: new google.maps.Point(17,48),
        strokeWeight: 1,
        scale: .8,
        rotation: 0
    }

    var icon_activacion_ysu = {
        path: "M23.7 0v1.7H0l5.5 10.7L0 23h23.7v25h3V0z",
        fillColor: '#fff',
        fillOpacity: .8,
        anchor: new google.maps.Point(26,48),
        strokeWeight: 0,
        scale: .8,
        rotation: 0
    }

    var icon_activacion = {
        path: "M19 0v2.4l-19 8 19 8V40h2.4V0z",
        fillColor: '#fff',
        fillOpacity: .8,
        anchor: new google.maps.Point(21,40),
        strokeWeight: 0,
        scale: .8,
        rotation: 0
    }

    var icon_encuentro = {
        path: "M7 0C3.3 0 0 3.2 0 7c0 3.6 2.5 6.5 6 7v14h2.3V14c3.3-.5 6-3.4 6-7 0-3.8-3.3-7-7.2-7z",
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
                            var tipo = value.type

                            switch(tipo) {
                              case 'user':
                                var icono = value.map_icon;
                                break;
                              case 'group':
                                var icono = icon_nodo;
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
                                type: tipo,
                                event_type: value.event_type,
                                event_group: value.event_group,
                                optimized: false,
                                visible: mostrar,
                                id: 'marker_'+value.guid
                            });

                            var myoverlay = new google.maps.OverlayView();
                            myoverlay.draw = function () {
                              this.getPanes().markerLayer.id='markerLayer';
                            };
                            myoverlay.setMap(map);

                            // console.log(value);

                            // Dibuja lineas entre grupos

                            for (var i = 0; i < markers.length; i++) {
                              if (first) {
                                var anterior = markers[i].position;
                                first = false;
                              } else {
                                if (markers[i].type === 'group') {
                                  viaje[i] = new google.maps.Polyline({
                                      path: [markers[i].position, anterior],
                                      strokeColor: "#eac55d",
                                      strokeOpacity: 0.2,
                                      strokeWeight: 7,
                                      geodesic: true,
                                  });
                                  var anterior = markers[i].position;
                                  viaje[i].setMap(map);
                                  // console.log(line);
                                }

                              }


                            if (this.type === 'group') {
                              var currentGroup = this.guid;
                              }
                            }

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
