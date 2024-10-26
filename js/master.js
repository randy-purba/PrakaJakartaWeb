$(function () {
  var bindDatePicker = function() {
    $(".date").datetimepicker({
      format:'YYYY-MM-DD',
      icons: {
       time: "fa fa-clock-o",
       date: "fa fa-calendar",
       up: "fa fa-arrow-up",
       down: "fa fa-arrow-down"
      }
    }).find('input:first').on("blur",function () {
      // check if the date is correct. We can accept dd-mm-yyyy and yyyy-mm-dd.
      // update the format if it's yyyy-mm-dd
      var date = parseDate($(this).val());

      if (! isValidDate(date)) {
       //create date based on momentjs (we have that)
       date = moment().format('YYYY-MM-DD');
      }

      $(this).val(date);
    });
  }

  var isValidDate = function(value, format) {
    format = format || false;
    // lets parse the date to the best of our knowledge
    if (format) {
     value = parseDate(value);
    }

    var timestamp = Date.parse(value);

    return isNaN(timestamp) == false;
  }

  var parseDate = function(value) {
    var m = value.match(/^(\d{1,2})(\/|-)?(\d{1,2})(\/|-)?(\d{4})$/);
    if (m)
     value = m[5] + '-' + ("00" + m[3]).slice(-2) + '-' + ("00" + m[1]).slice(-2);

    return value;
  }

  bindDatePicker();
});

function exportTableToExcel(tableID, filename = ''){
  var downloadLink;
  var dataType = 'application/vnd.ms-excel';
  var tableSelect = document.getElementById(tableID);
  var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');

  // Specify file name
  filename = filename?filename+'.xls':'excel_data.xls';

  // Create download link element
  downloadLink = document.createElement("a");

  document.body.appendChild(downloadLink);

  if(navigator.msSaveOrOpenBlob){
      var blob = new Blob(['\ufeff', tableHTML], {
          type: dataType
      });
      navigator.msSaveOrOpenBlob( blob, filename);
  }else{
      // Create a link to the file
      downloadLink.href = 'data:' + dataType + ', ' + tableHTML;

      // Setting the file name
      downloadLink.download = filename;

      //triggering the function
      downloadLink.click();
  }
}
$(document).ready(function() {
  $('#filterTab').click(function() {
    $('.filter').css({
      "z-index": "10",
      "transition": "all ease-in-out .5s"
    });
    $('.filter .filter-content').css({
      "transform": "translateX(0px)",
      "transition": "all ease-in-out .5s",
      "z-index": "15"
    });
    $('.filter .filter-dismiss').css({
      "opacity": "1",
      "transition": "all ease-in-out .5s"
    });
  });
  $('#closeTab').click(function() {
    $('.filter').css({
      "z-index": "-10",
      "transition": "all ease-in-out .75s"
    });
    $('.filter .filter-content').css({
      "transform": "translateX(400px)",
      "transition": "all ease-in-out .75s",
      "z-index": "15"
    });
    $('.filter .filter-dismiss').css({
      "opacity": "0",
      "transition": "all ease-in-out .75s"
    });
  });
  $('.filter-dismiss').click(function() {
    $('.filter').css({
      "z-index": "10",
      "transition": "all ease-in-out .5s"
    });
    $('.filter .filter-content').css({
      "transform": "translateX(0px)",
      "transition": "all ease-in-out .5s",
      "z-index": "15"
    });
    $('.filter .filter-dismiss').css({
      "opacity": "1",
      "transition": "all ease-in-out .5s"
    });
  });
  $('#minimizeButton').click(function() {
    $('.floating-surveyor').css({
      "transform": "translateX(0px)",
      "transition": "all ease-in-out .5s"
    });
  });
  $('#minimize').click(function() {
    $('.floating-surveyor').css({
      "transform": "translateX(-800px)",
      "transition": "all ease-in-out .5s"
    });
  });
  $(document).on("click", ".edit", function () {
    var myBookId = $(this).data('id');
    $(".modal-body #koordId").val( myBookId );

    var myBookId1 = $(this).data('name');
    $(".modal-body #bookId").val( myBookId1 );

    var myBookId2 = $(this).data('birth');
    $(".modal-body #bookDob").val( myBookId2 );

    var myBookId3 = $(this).data('wilayah');
    $(".modal-body #wilayah").val( myBookId3 );
    var myBookId4 = $(this).data('dapil');
    $(".modal-body #dapil").val( myBookId4 );
    var myBookId5 = $(this).data('kabupaten');
    $(".modal-body #kabupaten").val( myBookId5 );
  });
  $(document).on("click", ".edit", function () {
    var myBookId = $(this).data('id');
    $(".modal-body #surveyorId").val( myBookId );

    var myBookId1 = $(this).data('name');
    $(".modal-body #nameEdit").val( myBookId1 );

    var myBookId2 = $(this).data('birth');
    $(".modal-body #dobEdit").val( myBookId2 );

    var myBookId3 = $(this).data('wilayah');
    $(".modal-body #filterEditByKoordinator").val( myBookId3 );
  });
});
