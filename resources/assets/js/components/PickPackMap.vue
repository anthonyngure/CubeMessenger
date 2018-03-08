<template>
    <div style="width: 100%; height: 100%">
        <v-progress-linear hide-details v-show="loadingDriverOptions" :indeterminate="true"></v-progress-linear>
        <gmap-map
                :center="defaultOrigin"
                :options="options"
                :zoom="16"
                ref="map"
                id="map">

            <gmap-polyline v-for="(polyLinePath, i) in polyLinePaths"
                           :key="i"
                           :path="polyLinePath"
                           :options="{strokeColor: getRandomColor()}">
            </gmap-polyline>

        </gmap-map>
    </div>
</template>

<script>

    import Vue from 'vue'
    import * as VueGoogleMaps from 'vue2-google-maps'
    import EventBus from '../event-bus'

    Vue.use(VueGoogleMaps, {
        load: {
            key: 'AIzaSyAS_9BsQpqTP8EVuMZ7rQ9gMCl0wmqhm7k',
            // v: 'OPTIONAL VERSION NUMBER',
            libraries: 'places', //// If you need to use place input
        }
    })

    export default {
        name: 'pick-pack-map',
        data () {
            return {
                defaultOrigin: {lat: -1.33113, lng: 36.88117},
                markers: [],
                polyLinePaths: [],
                options: {
                    region: 'KE',
                    //gestureHandling: 'none',
                    //zoomControl: false,
                    style: [
                        {
                            'featureType': 'administrative',
                            'elementType': 'geometry.fill',
                            'stylers': [
                                {
                                    'color': '#d6e2e6'
                                }
                            ]
                        },
                        {
                            'featureType': 'administrative',
                            'elementType': 'geometry.stroke',
                            'stylers': [
                                {
                                    'color': '#cfd4d5'
                                }
                            ]
                        },
                        {
                            'featureType': 'administrative',
                            'elementType': 'labels.text.fill',
                            'stylers': [
                                {
                                    'color': '#7492a8'
                                }
                            ]
                        },
                        {
                            'featureType': 'administrative.neighborhood',
                            'elementType': 'labels.text.fill',
                            'stylers': [
                                {
                                    'lightness': 25
                                }
                            ]
                        },
                        {
                            'featureType': 'landscape.man_made',
                            'elementType': 'geometry.fill',
                            'stylers': [
                                {
                                    'color': '#dde2e3'
                                }
                            ]
                        },
                        {
                            'featureType': 'landscape.man_made',
                            'elementType': 'geometry.stroke',
                            'stylers': [
                                {
                                    'color': '#cfd4d5'
                                }
                            ]
                        },
                        {
                            'featureType': 'landscape.natural',
                            'elementType': 'geometry.fill',
                            'stylers': [
                                {
                                    'color': '#dde2e3'
                                }
                            ]
                        },
                        {
                            'featureType': 'landscape.natural',
                            'elementType': 'labels.text.fill',
                            'stylers': [
                                {
                                    'color': '#7492a8'
                                }
                            ]
                        },
                        {
                            'featureType': 'landscape.natural.terrain',
                            'stylers': [
                                {
                                    'visibility': 'off'
                                }
                            ]
                        },
                        {
                            'featureType': 'poi',
                            'elementType': 'geometry.fill',
                            'stylers': [
                                {
                                    'color': '#dde2e3'
                                }
                            ]
                        },
                        {
                            'featureType': 'poi.park',
                            'elementType': 'geometry.fill',
                            'stylers': [
                                {
                                    'color': '#a9de83'
                                }
                            ]
                        },
                        {
                            'featureType': 'poi.park',
                            'elementType': 'geometry.stroke',
                            'stylers': [
                                {
                                    'color': '#bae6a1'
                                }
                            ]
                        },
                        {
                            'featureType': 'poi.sports_complex',
                            'elementType': 'geometry.fill',
                            'stylers': [
                                {
                                    'color': '#c6e8b3'
                                }
                            ]
                        },
                        {
                            'featureType': 'poi.sports_complex',
                            'elementType': 'geometry.stroke',
                            'stylers': [
                                {
                                    'color': '#bae6a1'
                                }
                            ]
                        },
                        {
                            'featureType': 'road',
                            'elementType': 'labels.icon',
                            'stylers': [
                                {
                                    'saturation': -45
                                },
                                {
                                    'lightness': 10
                                },
                                {
                                    'visibility': 'on'
                                }
                            ]
                        },
                        {
                            'featureType': 'road',
                            'elementType': 'labels.text.fill',
                            'stylers': [
                                {
                                    'color': '#41626b'
                                }
                            ]
                        },
                        {
                            'featureType': 'road.arterial',
                            'elementType': 'geometry.fill',
                            'stylers': [
                                {
                                    'color': '#ffffff'
                                }
                            ]
                        },
                        {
                            'featureType': 'road.highway',
                            'elementType': 'geometry.fill',
                            'stylers': [
                                {
                                    'color': '#c1d1d6'
                                }
                            ]
                        },
                        {
                            'featureType': 'road.highway',
                            'elementType': 'geometry.stroke',
                            'stylers': [
                                {
                                    'color': '#a6b5bb'
                                }
                            ]
                        },
                        {
                            'featureType': 'road.highway',
                            'elementType': 'labels.icon',
                            'stylers': [
                                {
                                    'visibility': 'on'
                                }
                            ]
                        },
                        {
                            'featureType': 'road.highway.controlled_access',
                            'elementType': 'geometry.fill',
                            'stylers': [
                                {
                                    'color': '#9fb6bd'
                                }
                            ]
                        },
                        {
                            'featureType': 'road.local',
                            'elementType': 'geometry.fill',
                            'stylers': [
                                {
                                    'color': '#ffffff'
                                }
                            ]
                        },
                        {
                            'featureType': 'transit.line',
                            'elementType': 'geometry.fill',
                            'stylers': [
                                {
                                    'color': '#b4cbd4'
                                }
                            ]
                        },
                        {
                            'featureType': 'transit.station.airport',
                            'elementType': 'geometry.fill',
                            'stylers': [
                                {
                                    'saturation': -100
                                },
                                {
                                    'lightness': -5
                                }
                            ]
                        },
                        {
                            'featureType': 'water',
                            'elementType': 'geometry.fill',
                            'stylers': [
                                {
                                    'color': '#a6cbe3'
                                }
                            ]
                        }
                    ],
                },
                originMarker: null,
                loadingDriverOptions: false,
            }
        },
        watch: {
            markers (markers) {
                let bounds = new google.maps.LatLngBounds()
                if (markers) {
                    for (let m of markers) {
                        bounds.extend(m.position)
                    }
                    this.$refs.map.$mapObject.fitBounds(bounds)
                }

                if (this.polyLinePaths) {
                    for (let i = 0; i < this.polyLinePaths.length; i++) {
                        let polyLinePath = this.polyLinePaths[i]
                        for (let j = 0; j < polyLinePath.length; j++) {
                            bounds.extend(polyLinePath[j])
                        }
                    }
                }
            },
            polyLinePaths (polyLinePaths) {
                let bounds = new google.maps.LatLngBounds()
                if (polyLinePaths) {
                    for (let i = 0; i < polyLinePaths.length; i++) {
                        let polyLinePath = polyLinePaths[i]
                        for (let j = 0; j < polyLinePath.length; j++) {
                            bounds.extend(polyLinePath[j])
                        }
                    }
                }
                if (this.markers) {
                    for (let m of this.markers) {
                        bounds.extend(m.position)
                    }
                    this.$refs.map.$mapObject.fitBounds(bounds)
                }
            }
        },
        methods: {

            setOrigin (origin) {
                this.defaultOrigin = origin
                if (this.originMarker) {
                    this.originMarker.setMap(null)
                }
                this.originMarker = new google.maps.Marker({
                    map: this.$refs.map.$mapObject,
                    draggable: false,
                    animation: google.maps.Animation.DROP,
                    position: origin,
                })
                this.originMarker.addListener('click', this.toggleBounce)

            },

            toggleBounce: function toggleBounce () {
                if (this.originMarker.getAnimation() !== null) {
                    this.originMarker.setAnimation(null)
                } else {
                    this.originMarker.setAnimation(google.maps.Animation.BOUNCE)
                }
            },
            onGetCurrentPosition (position) {
                let origin = {lat: position.coords.latitude, lng: position.coords.longitude}
                this.setOrigin(origin)
                EventBus.$emit('onMapReady', this.$refs.map.$mapObject)
            },
            onGetCurrentPositionError (error) {
                console.log('Error occurred. Error code: ' + error.code)
                console.log('Error occurred. Error message: ' + error.message)
                this.onGetCurrentPosition(this.defaultOrigin)
            },
            getRandomColor () {
                return '#' + (0x1000000 + (Math.random()) * 0xffffff).toString(16).substr(1, 6)
            },
        },
        mounted () {
            if (this.$route.name === 'courier') {
                let that = this
                EventBus.$on('onOriginChanged', function (newOrigin) {
                    that.setOrigin(newOrigin)
                })
                EventBus.$on('onPolyLinePathsUpdated', function (newPolyLinePaths) {
                    that.polyLinePaths = newPolyLinePaths
                })
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(this.onGetCurrentPosition, this.onGetCurrentPositionError)
                } else {
                    this.onGetCurrentPositionError({code: 0, message: 'Geo Location not supported'})
                }
            }
        },
    }
</script>

<style scoped>
    #map {
        width: 100%;
        height: 100%;
    }
</style>