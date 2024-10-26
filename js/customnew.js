$(function () {

  function initMap() {


    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 18,
      center: new google.maps.LatLng(-6.16100, 106.81979),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    // var api = new Api();

    // api.get()

    var $url = "";
    $url = 'https://praka-jakarta-2024-229415464489.asia-southeast2.run.app/api/otherReports/dashboard?limit=2000&sortby=id&order=DESC';

    console.log('Surveyor ' + Api.getSurveyor());

    // if (Api.getWilayah() != "") {
    //   $url = 'https://praka-jakarta-2024-229415464489.asia-southeast2.run.app/api/reports/dashboard?limit=2000&sortby=id&order=DESC&filterbywilayah=' + Api.getWilayah();
    // }
    // if (Api.getKabupaten() != "") {
    //   $url = 'https://praka-jakarta-2024-229415464489.asia-southeast2.run.app/api/reports/dashboard?limit=2000&sortby=id&order=DESC&filterbykabupaten=' + Api.getKabupaten();
    // }
    // if (Api.getDapil() != "") {
    //   $url = 'https://praka-jakarta-2024-229415464489.asia-southeast2.run.app/api/reports/dashboard?limit=2000&sortby=id&order=DESC&filterbydapil=' + Api.getDapil();
    // }
    // if (Api.getKoordinator() != "") {
    //   $url = 'https://praka-jakarta-2024-229415464489.asia-southeast2.run.app/api/reports/dashboard?limit=2000&sortby=id&order=DESC&filterbykoordinator=' + Api.getKoordinator();
    // }
    if (Api.getSurveyor() != "") {
      $url = 'https://praka-jakarta-2024-229415464489.asia-southeast2.run.app/api/otherReports/dashboard?limit=2000&sortby=id&order=DESC&filterbysurveyor=' + Api.getSurveyor();
    }
    // else{
    //   console.log('Surveyor else '+Api.getSurveyor());
    //   $url='https://praka-jakarta-2024-229415464489.asia-southeast2.run.app/api/reports/dashboard?limit=2000&sortby=id&order=DESC';
    // }

    Api.get($url).then(resp => {
      console.log(resp);
      var locations = resp.data.rows;

      var infowindow = new google.maps.InfoWindow();

      var marker, i;

      var contentString = [];

      console.log("length " + locations.length);

      if (Api.getSurveyor() != "") {
        map = new google.maps.Map(document.getElementById('map'), {
          zoom: 18,
          center: new google.maps.LatLng(locations[0].lat, locations[0].lng),
          mapTypeId: google.maps.MapTypeId.ROADMAP
        });
      }

      // map = new google.maps.Map(document.getElementById('map'), {
      //   zoom: 18,
      //   center: new google.maps.LatLng(-6.16100, 106.81979),
      //   mapTypeId: google.maps.MapTypeId.ROADMAP
      // });

      for (i = 0; i < locations.length; i++) {
        // console.log("lat "+locations[i].lat);
        // console.log("lat "+locations[i].lng);
        marker = new google.maps.Marker({
          position: new google.maps.LatLng(locations[i].lat, locations[i].lng),
          map: map
        });

        contentString[i] = '<div class="info-window">' +
          '<div class="photo"><img src="' + locations[i].images + '" height="100%" width="100%"></div>' +
          '<div class="info-content">' +
          '<label for="coordinate">Koordinat</label>' +
          '<div class="longlat">' + locations[i].lat + ', ' + locations[i].lng + '</div>' +
          '<label for="fullname">Username</label>' +
          '<div class="full-name">' + locations[i].OtherSurveyorUsername + '</div>' +
          '<label for="address">Alamat</label>' +
          '<div class="address">' + locations[i].address + '</div>' +
          '</div>' +
          '</div>';

        google.maps.event.addListener(marker, 'click', (function (marker, i) {
          return function () {
            infowindow.setContent(contentString[i]);
            infowindow.open(map, marker);
            infowindow.setOptions({ maxWidth: 640 });
          }
        })(marker, i));
      }
    });

  }

  google.maps.event.addDomListener(window, 'load', initMap);
});


const Api = class {
  static headers() {
    var result = Api.getSess();
    // console.log(result);
    return {
      'Accept': 'application/json',
      'Content-Type': 'application/x-www-form-urlencoded',
      'Authorization': 'Bearer ' + result,
    }
  }

  static getSess() {
    var result = '';
    $.ajax({
      url: 'sess.php',
      method: 'post',
      async: false,
      success: function (data) {
        result = data;
      }
    });
    return result;
  }

  static getSurveyor() {
    var result = '';
    $.ajax({
      url: 'surveyorNewId.php',
      method: 'post',
      async: false,
      success: function (data) {
        result = data;
      }
    });
    return result;
  }

  static getWilayah() {
    var result = '';
    $.ajax({
      url: 'wilayahId.php',
      method: 'post',
      async: false,
      success: function (data) {
        result = data;
      }
    });
    return result;
  }

  static getKabupaten() {
    var result = '';
    $.ajax({
      url: 'kabupatenId.php',
      method: 'post',
      async: false,
      success: function (data) {
        result = data;
      }
    });
    return result;
  }

  static getDapil() {
    var result = '';
    $.ajax({
      url: 'dapilId.php',
      method: 'post',
      async: false,
      success: function (data) {
        result = data;
      }
    });
    return result;
  }

  static getKoordinator() {
    var result = '';
    $.ajax({
      url: 'koordinatorId.php',
      method: 'post',
      async: false,
      success: function (data) {
        result = data;
      }
    });
    return result;
  }

  static get(route) {
    return this.xhr(route, null, 'GET');
  }

  static post(route, params) {
    return this.xhr(route, params, 'POST');
  }

  static put(route, params) {
    return this.xhr(route, params, 'PUT');
  }

  static delete(route, params) {
    return this.xhr(route, params, 'DELETE');
  }

  static xhr(route, params, verb) {
    const url = `${route}`;
    console.log("url "+ route);
    let options = Object.assign({
      method: verb,
    }, params ? { body: JSON.stringify(params) } : null);

    options.headers = Api.headers();
    console.log(Api.headers());

    return fetch(url, options).then(response => {
      console.log(response);
      let json = response.json();
      if (response.ok) {
        return json;
      } else {
        return json.then(err => {
          throw err
        });
      }
    })
  }
}
