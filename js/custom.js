$(function () {

  function initMap() {


    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 11.8,
      center: new google.maps.LatLng(-6.16100, 106.81979),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    var $url = "";
    $url = 'https://praka-jakarta-2024-229415464489.asia-southeast2.run.app/api/reports/dashboard?limit=2000&sortby=id&order=DESC';

    if (Api.getWilayah() != "") {
      $url = 'https://praka-jakarta-2024-229415464489.asia-southeast2.run.app/api/reports/dashboard?limit=2000&sortby=id&order=DESC&filterbywilayah=' + Api.getWilayah();
    }
    if (Api.getKabupaten() != "") {
      $url = 'https://praka-jakarta-2024-229415464489.asia-southeast2.run.app/api/reports/dashboard?limit=2000&sortby=id&order=DESC&filterbykabupaten=' + Api.getKabupaten();
    }
    if (Api.getDapil() != "") {
      $url = 'https://praka-jakarta-2024-229415464489.asia-southeast2.run.app/api/reports/dashboard?limit=2000&sortby=id&order=DESC&filterbydapil=' + Api.getDapil();
    }
    if (Api.getKoordinator() != "") {
      $url = 'https://praka-jakarta-2024-229415464489.asia-southeast2.run.app/api/reports/dashboard?limit=2000&sortby=id&order=DESC&filterbykoordinator=' + Api.getKoordinator();
    }
    if (Api.getSurveyor() != "") {
      $url = 'https://praka-jakarta-2024-229415464489.asia-southeast2.run.app/api/reports/dashboard?limit=2000&sortby=id&order=DESC&filterbysurveyor=' + Api.getSurveyor();
    }

    Api.get($url).then(resp => {
      var locations = resp.data.rows;

      var infowindow = new google.maps.InfoWindow();

      var marker, i;

      var contentString = [];

      if (Api.getSurveyor() != "") {
        map = new google.maps.Map(document.getElementById('map'), {
          zoom: 18,
          center: new google.maps.LatLng(locations[0].lat, locations[0].lng),
          mapTypeId: google.maps.MapTypeId.ROADMAP
        });
      }

      for (i = 0; i < locations.length; i++) {
        marker = new google.maps.Marker({
          position: new google.maps.LatLng(locations[i].lat, locations[i].lng),
          icon: {
            url: 'https://storage.googleapis.com/bucket-praka-jakarta/m34kmra4',
            scaledSize: new google.maps.Size(30, 30)
          },
          map: map
        });

        var firstAnswer = locations[i].answer1 == 1 ? "Ya" : "Tidak";
        var secondAnswer = locations[i].answer2 == 1 ? "Ya" : "Tidak";

        contentString[i] = '<div class="info-window">' +
          '<div class="photo"><img src="' + locations[i].images + '" height="100%" width="100%"></div>' +
          '<div class="info-content">' +
          '<label for="coordinate">Koordinat</label>' +
          '<div class="longlat">' + locations[i].lat + ', ' + locations[i].lng + '</div>' +
          '<label for="fullname">Nama Lengkap</label>' +
          '<div class="full-name">' + locations[i].name + '</div>' +
          '<label for="address">Alamat</label>' +
          '<div class="address">' + locations[i].address1 + '</div>' +
          '<label for="answer1">Mengenal Pramono Anung dan Rano Karno ?</label>' +
          '<div class="answer-1">' + firstAnswer + '</div>' +
          '<label for="answer2">Ingin memilih Pramono Anung dan Rano Karno ? </label>' +
          '<div class="answer-2">' + secondAnswer + '</div>' +
          '<label for="surveyorName">Nama Surveyor</label>' +
          '<div class="address">' + locations[i].AppUserName + '</div>' +
          '<label for="coordinatorName">Nama Koordinator</label>' +
          '<div class="address">' + locations[i].CoordinatorName + '</div>' +
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

function myFunction1() {
  var x = document.getElementById("filterWilayah").value;
  
  $url = 'https://praka-jakarta-2024-229415464489.asia-southeast2.run.app/api/dashboardUsers/kabupaten?filterbywilayah=' + x;
  var optionsAsString = "<option value=''></option>";
  Api.get($url).then(resp => {
    var locations = resp.data;
    for(var i = 0; i < locations.length; i++) {
        optionsAsString += "<option value='" + locations[i].id + "'>" + locations[i].name + "</option>";
    }
    var selectobject=document.getElementById("filterKabupaten");
    var options = selectobject.getElementsByTagName('OPTION');
    for(var i=0; i<options.length; i++) {
      selectobject.removeChild(options[i]);
      i--;
    }
    $( 'select[name="filterKabupaten"]' ).append( optionsAsString );
  });
}

function myFunction2() {
  var x = document.getElementById("filterKabupaten").value;
  
  $url = 'https://praka-jakarta-2024-229415464489.asia-southeast2.run.app/api/dashboardUsers/dapil?filterbykabupaten=' + x;
  var optionsAsString = "<option value=''></option>";
  Api.get($url).then(resp => {
    var locations = resp.data;
    for(var i = 0; i < locations.length; i++) {
        optionsAsString += "<option value='" + locations[i].id + "'>" + locations[i].name + "</option>";
    }
    var selectobject=document.getElementById("filterDapil");
    var options = selectobject.getElementsByTagName('OPTION');
    for(var i=0; i<options.length; i++) {
      selectobject.removeChild(options[i]);
      i--;
    }
    $( 'select[name="filterDapil"]' ).append( optionsAsString );
  });
}

function myFunction3() {
  var x1 = document.getElementById("filterWilayah").value;
  var x2 = document.getElementById("filterKabupaten").value;
  var x3 = document.getElementById("filterDapil").value;
  
  var url = 'https://praka-jakarta-2024-229415464489.asia-southeast2.run.app/api/dashboardUsers/?'
  + 'limit=all'
  + '&sortby=id'
  + '&order=ASC'
  + '&page=1'
  + '&filterbywilayah='+ x1 
  + '&filterbykabupaten='+ x2 
  + '&filterbydapil=' +x3;
  var optionsAsString = "<option value=''></option>";
  Api.get(url).then(resp => {
    var locations = resp.data.rows;
    for(var i = 0; i < locations.length; i++) {
        optionsAsString += "<option value='" + locations[i].id + "'>" + locations[i].name + "</option>";
    }
    var selectobject=document.getElementById("filterKoordinator");
    var options = selectobject.getElementsByTagName('OPTION');
    for(var i=0; i<options.length; i++) {
      selectobject.removeChild(options[i]);
      i--;
    }
    $( 'select[name="filterKoordinator"]' ).append( optionsAsString );
  });
}

function myFunctionAddKoor(){
  var wilayah = document.getElementById("filterWilayah").value;
  var kabupaten = document.getElementById("filterKabupaten").value;
  var dapil = document.getElementById("filterDapil").value;
  var name = document.getElementById("name").value;
  var dob = document.getElementById("dob").value;
  Api.post("https://praka-jakarta-2024-229415464489.asia-southeast2.run.app/api/dashboardUsers/", {name: name, dob: dob, WilayahId : wilayah, DapilId: dapil, KabupatenId: kabupaten}).then(resp => {
    if(resp.status){
      alert('Sukses Menambahkan!');
      window.location.href = "koordinator.php";
    }
  });
}

function editMyFunction1() {
  var x = document.getElementById("editFilterWilayah").value;
  
  $url = 'https://praka-jakarta-2024-229415464489.asia-southeast2.run.app/api/dashboardUsers/kabupaten?filterbywilayah=' + x;
  var optionsAsString = "<option value=''></option>";
  Api.get($url).then(resp => {
    var locations = resp.data;
    for(var i = 0; i < locations.length; i++) {
        optionsAsString += "<option value='" + locations[i].id + "'>" + locations[i].name + "</option>";
    }
    var selectobject=document.getElementById("editFilterKabupaten");
    var options = selectobject.getElementsByTagName('OPTION');
    for(var i=0; i<options.length; i++) {
      selectobject.removeChild(options[i]);
      i--;
    }
    $( 'select[name="editFilterKabupaten"]' ).append( optionsAsString );
  });
}

function editMyFunction2() {
  var x = document.getElementById("editFilterKabupaten").value;
  
  $url = 'https://praka-jakarta-2024-229415464489.asia-southeast2.run.app/api/dashboardUsers/dapil?filterbykabupaten=' + x;
  var optionsAsString = "<option value=''></option>";
  Api.get($url).then(resp => {
    var locations = resp.data;
    for(var i = 0; i < locations.length; i++) {
        optionsAsString += "<option value='" + locations[i].id + "'>" + locations[i].name + "</option>";
    }
    var selectobject=document.getElementById("editFilterDapil");
    var options = selectobject.getElementsByTagName('OPTION');
    for(var i=0; i<options.length; i++) {
      selectobject.removeChild(options[i]);
      i--;
    }
    $( 'select[name="editFilterDapil"]' ).append( optionsAsString );
  });
}

function myFunctionEditKoor(){
  var id = document.getElementById("koordId").value;
  var wilayah = document.getElementById("editFilterWilayah").value;
  var kabupaten = document.getElementById("editFilterKabupaten").value;
  var dapil = document.getElementById("editFilterDapil").value;
  var name = document.getElementById("bookId").value;
  var dob = document.getElementById("bookDob").value;

  const profile = {};
  profile['name'] = name;
  profile['dob'] = dob;
  profile['WilayahId'] = wilayah;
  profile['DapilId'] = dapil;
  profile['KabupatenId'] = kabupaten;

  Api.put("https://praka-jakarta-2024-229415464489.asia-southeast2.run.app/api/dashboardUsers/"+id, {name: name, dob: dob, WilayahId : wilayah, DapilId: dapil, KabupatenId: kabupaten}).then(resp => {
    if(resp.status){
      alert('Sukses Mengubah!');
      window.location.href = "koordinator.php";
    }
  });
}

function myFunctionDeleteKoor(){
  var id = document.getElementById("id").value;

  Api.delete("https://praka-jakarta-2024-229415464489.asia-southeast2.run.app/api/dashboardUsers/"+id, null).then(resp => {
    if(resp.status){
      alert('Sukses Hapus!');
      window.location.href = "koordinator.php";
    }
  });
}

function myFunctionAddSurveyor(){
  var koordinator = document.getElementById("filterByKoordinator").value;
  var name = document.getElementById("name").value;
  var dob = document.getElementById("dob").value;
  Api.post("https://praka-jakarta-2024-229415464489.asia-southeast2.run.app/api/appUsers/", {name: name, dob: dob, CoordinatorId : koordinator}).then(resp => {
    if(resp.status){
      alert('Sukses Menambahkan!');
      window.location.href = "surveyor.php";
    }
  });
}

function myFunctionEditSurveyor(){
  var koordinator = document.getElementById("filterEditByKoordinator").value;
  var name = document.getElementById("nameEdit").value;
  var dob = document.getElementById("dobEdit").value;
  var id = document.getElementById("surveyorId").value;
  Api.put("https://praka-jakarta-2024-229415464489.asia-southeast2.run.app/api/appUsers/"+id, {name: name, dob: dob, CoordinatorId : koordinator}).then(resp => {
    if(resp.status){
      alert('Sukses Ubah!');
      window.location.href = "surveyor.php";
    }
  });
}

function myFunctionDeleteSurveyor(){
  var id = document.getElementById("id").value;
  Api.delete("https://praka-jakarta-2024-229415464489.asia-southeast2.run.app/api/appUsers/"+id, null).then(resp => {
    if(resp.status){
      alert('Sukses Hapus!');
      window.location.href = "koordinator.php";
    }
  });
}

const Api = class {
  static headers() {
    var result = Api.getSess();
    return {
      'Accept': 'application/json',
      'Content-Type': 'application/json',
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
      url: 'surveyorId.php',
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

  static async xhr(route, params, verb) {
    const url = `${route}`;

    let options = Object.assign({
      method: verb,
    }, params ? { body: JSON.stringify(params) } : null);

    options.headers = Api.headers();

    return await fetch(url, options).then(response => {
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
