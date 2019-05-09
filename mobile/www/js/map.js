$(document).ready(function () {

  mapboxgl.accessToken = "pk.eyJ1IjoicmpzdG9ja3N0aWxsIiwiYSI6ImNqdjNmejhwbTA4dmI0NG1rNDBtc29qemEifQ.VKQ2nFCrASDB766mtFwrpg";

  var map = new mapboxgl.Map({
    container: "map",
    style: "mapbox://styles/mapbox/streets-v11",
    center: [-77.034084, 38.909671],
    zoom: 10
  });

  map.on('load', function () {
    map.addLayer({
      id: 'terrain-data',
      type: 'line',
      source: {
        type: 'vector',
        url: 'mapbox://mapbox.mapbox-terrain-v2'
      },
      'source-layer': 'contour'
    });
  });
});