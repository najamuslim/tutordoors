var currentMousePos = {
    x: -1,
    y: -1
  };
  jQuery(document).on("mousemove", function (event) {
    currentMousePos.x = event.pageX;
    currentMousePos.y = event.pageY;
  });

function give_thousand_separator(div_id, value){
    var number_only = value.replace(new RegExp(',', 'g'), '');
    //set
    $('#'+div_id).val(currency_separator(number_only, ','));
}

function replace_char(string, src, target){
    return string.replace(new RegExp(src, 'g'), target);
}

function currency_separator(nStr, sep) {
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + sep + '$2');
    }
    return x1 + x2;
}

$(document).ready(function(){
  // just prepare for document on ready state

  $("#sel-province").change(function(e){
    $.ajax({
      type : "GET",
      url: base_url+'location/get_cities_by_province/'+$("#sel-province").val(),
      // data: "id="+$("#ship-city").val(),
      dataType: "json",
      success:function(data){
        if(data.status=="200"){
          $("#sel-city").find('option').remove().end();
          for(var i=0; i<data.cities.length;i++)
            $("#sel-city").append($("<option></option>").val(data.cities[i].id).html(data.cities[i].name));
        }            
      }
    });
  });

  $("#sel-program").change(function(e){
    $.ajax({
      type : "GET",
      url: base_url+'course/get_course_by_program/'+$('#sel-program').val(),
      // data: "root="+$("#sel-root").val(),
      dataType: "json",
      success:function(data){
        $("#sel-course").find('option').remove().end();
        $("#sel-course").append($("<option></option>").val('all').html('All Subjects'));
        for(var i=0; i<data.length;i++)
          $("#sel-course").append($("<option></option>").val(data[i].id).html(data[i].course_name));
      }
    });
    
  });

  
});



$('#btn-change-password').on('click', function() {
    $.ajax({
      type : "POST",
      async: false,
      url: base_url+"users/password_change",
      data: $('#form-password').serialize(),
      dataType: "json",
      success:function(data){
        if(data.status=="200")
          $('#message').text('Password berhasil diubah');
        
        else
          $('#message').text(data.message);
        
      }
    });
  })






// $('#datepicker').datepicker({
//   dateFormat: "yy-mm-dd"
// });

// $('#add-open-course').on('click', function() {
//     $.ajax({
//       type : "GET",
//       async: false,
//       url: base_url+"course/add_course",
//       data: 'course='+$('#sel-course').val()+'&tariff='+$('#tariff').val(),
//       dataType: "json",
//       success:function(data){
//         if(data.status=="200")
//           $('#open-course tbody').append('<tr id="course-'+data.id+'"><td>'+data.education_level+'</td><td>'+data.course_category+'</td><td>'+currency_separator(data.tariff, ',')+'</td><td><button class="btn btn-default btn-block btn-flat" onclick="remove_open_course(\''+data.id+'\')"><span class="fa fa-minus-circle" style="color:red"></span> Hapus</button></td></tr>');
//         else if(data.status=="204")
//           alert(data.message);
//         else
//           alert('Undefined error number.');
//       }
//     });
//   })

if(url_parts[url_parts.length - 1] == "edit_open_schedule"){
  /* initialize the external events
    -----------------------------------------------------------------*/

    $('#external-events .fc-event').each(function() {
      var nama = $.trim($(this).text());
      var warna = '';
      if(nama=="Open")
        warna = '#32B420';
      else if(nama=="Jam Kursus")
        warna = '#3B5998';
      // store data so the calendar knows to render an event upon drop
      $(this).data('event', {
        title: $.trim($(this).text()), // use the element's text as the event title
        stick: true, // maintain when user navigates (see docs on the renderEvent method)
        color: warna
      });

      // make the event draggable using jQuery UI
      $(this).draggable({
        zIndex: 999,
        revert: true,      // will cause the event to go back to its
        revertDuration: 0  //  original position after the drag
      });

    });

  $('#calendar').fullCalendar({
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'month,agendaWeek,agendaDay'
      },
      defaultView: 'agendaWeek',
      // defaultDate: '2016-01-12',
      editable: true,
      droppable: true,
      eventLimit: true, // allow "more" link when too many events
      events: base_url+'course/my_calendar',
      eventDrop: function(event, delta, revertFunc) {
        if (!confirm("Anda yakin mengubah waktu ini?")) {
            revertFunc();            
        }
        else{
          change_calendar_by_id(event.id, event.start.format("YYYY-MM-DD H:mm:ss"), event.end.format("YYYY-MM-DD H:mm:ss"));
        }
      },
      eventResize: function(event, delta, revertFunc) {
        if (!confirm("Anda yakin mengubah waktu ini?")) {
            revertFunc();            
        }
        else{
          change_calendar_by_id(event.id, event.start.format("YYYY-MM-DD H:mm:ss"), event.end.format("YYYY-MM-DD H:mm:ss"));
        }
      },
      eventReceive: function(event){
        $.ajax({
          type : "GET",
          async: false,
          url: base_url+"course/add_calendar",
          data: 'start='+event.start.format("YYYY-MM-DD H:mm:ss")+'&title='+event.title,
          dataType: "json",
          success:function(data){
            if(data.status=="200")
              event.id = data.id;
            if(data.status=="204")
              alert(data.message);
          }
        });
      },
      eventDragStop: function (event, jsEvent, ui, view) {
          if (isElemOverDiv()) {
            var con = confirm('Anda ingin menghapus data event ini?');
            if(con == true) {
              $.ajax({
                type : "GET",
                async: false,
                url: base_url+"course/delete_calendar/"+event.id,
                dataType: "json",
                success:function(data){
                  if(data.status=="200"){
                    $('#calendar').fullCalendar('removeEvents');
                        getFreshEvents();
                  }
                  else if(data.status=="204")
                    alert(data.message);
                },
                error: function(e){
                  alert('Error processing your request: '+e.responseText);
                }
              });
          }   
        }
      }
    });
  }
  
    
function change_calendar_by_id(id, start, end){
  $.ajax({
      type : "GET",
      async: false,
      url: base_url+"course/change_calendar",
      data: 'id='+id+'&start='+start+'&end='+end,
      dataType: "json",
      success:function(data){
        if(data.status=="204")
          alert(data.message);
      }
    });
}

function isElemOverDiv() {
    var trashEl = jQuery('#trash');

    var ofs = trashEl.offset();

    var x1 = ofs.left;
    var x2 = ofs.left + trashEl.outerWidth(true);
    var y1 = ofs.top;
    var y2 = ofs.top + trashEl.outerHeight(true);

    if (currentMousePos.x >= x1 && currentMousePos.x <= x2 &&
        currentMousePos.y >= y1 && currentMousePos.y <= y2) {
        return true;
    }
    return false;
}

function getFreshEvents(){
    $.ajax({
          type : "GET",
          async: false,
          url: base_url+"course/my_calendar",
          dataType: "json",
          success:function(data){
            var events = new Array();

            // $.each(obj,function(index,value) {
            for(var i=0; i<data.length; i++){
                event = new Object();       
                event.id = data[i].id;
                event.title = data[i].title;
                event.start = data[i].start; 
                event.end = data[i].end;
                event.color = data[i].color;

                events.push(event);
            }
            $('#calendar').fullCalendar('addEventSource', events);
          }
        });
    
  }

  if(url_parts[url_parts.length - 3]=="profile" && url_parts[url_parts.length - 2]=="teacher"){
    $('#calendar').fullCalendar({
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'month,agendaWeek,agendaDay'
      },
      defaultView: 'agendaWeek',
      // defaultDate: '2016-01-12',
      editable: true,
      droppable: true,
      eventLimit: true, // allow "more" link when too many events
      events: base_url+"course/view_teacher_calendar/"+teacher_id,
      eventDrop: function(event, delta, revertFunc) {
        if (!confirm("Anda yakin mengubah waktu ini?")) {
            revertFunc();            
        }
        else{
          change_calendar_by_id(event.id, event.start.format("YYYY-MM-DD H:mm:ss"), event.end.format("YYYY-MM-DD H:mm:ss"));
        }
      },
      eventResize: function(event, delta, revertFunc) {
        if (!confirm("Anda yakin mengubah waktu ini?")) {
            revertFunc();            
        }
        else{
          change_calendar_by_id(event.id, event.start.format("YYYY-MM-DD H:mm:ss"), event.end.format("YYYY-MM-DD H:mm:ss"));
        }
      },
      eventReceive: function(event){
        $.ajax({
          type : "GET",
          async: false,
          url: base_url+"course/add_calendar",
          data: 'start='+event.start.format("YYYY-MM-DD H:mm:ss")+'&title='+event.title,
          dataType: "json",
          success:function(data){
            if(data.status=="200")
              event.id = data.id;
            if(data.status=="204")
              alert(data.message);
          }
        });
      },
      eventDragStop: function (event, jsEvent, ui, view) {
          if (isElemOverDiv()) {
            var con = confirm('Anda ingin menghapus data event ini?');
            if(con == true) {
              $.ajax({
                type : "GET",
                async: false,
                url: base_url+"course/delete_calendar/"+event.id,
                dataType: "json",
                success:function(data){
                  if(data.status=="200"){
                    $('#calendar').fullCalendar('removeEvents');
                        getFreshEvents();
                  }
                  else if(data.status=="204")
                    alert(data.message);
                },
                error: function(e){
                  alert('Error processing your request: '+e.responseText);
                }
              });
          }   
        }
      }
    });
  }

  $('input[type="checkbox"][name="schedule[]"]').change(function() {
    var total_hours = 0;
    $('#loading-hour').toggle();
    var checkbox_input = $('input[type="checkbox"][name="schedule[]"]:checked').each(function() {
      var value = $(this).val();
      // console.log(value);
      //get the hours from DB
      $.ajax({
        type : "GET",
        async: false,
        url: base_url+'course/get_hour_from_event/'+value,
        dataType: "json",
        success:function(data){
          total_hours += parseInt(data.hours);
        },
        error: function(e){
          alert('Error processing your request: '+e.responseText);
        }
      });
    });
    $('#loading-hour').toggle();
    $('.replace-total-hour').text(total_hours);

    // get the total price
    $.ajax({
      type : "GET",
      async: false,
      url: base_url+'course/get_price/'+cid,
      dataType: "json",
      success:function(data){
        $('.replace-total-price').text(currency_separator(total_hours * parseInt(data.price), ','));
      },
      error: function(e){
        alert('Error processing your request: '+e.responseText);
      }
    });
  });

if(logged_in=="in"){
  (function refresh_notification() {
    $.ajax({
      type : "GET",
      url: base_url+'cms/count_notification', 
      async: false,
      dataType: "json",
      success: function(data) {
        $('.replace-count-message').text('('+data.notif_unread+')');
        $('.replace-count-message-sidebar').text('('+data.notif_unread+')');
      },
      complete: function() {
      // Schedule the next request when the current one's complete,, in miliseconds
        setTimeout(refresh_notification, 60000);
      }
     });
  })
  ();
}



function goBack(){
  window.history.back();
}



$(function () {
  $('#default-datepicker').datetimepicker({
    format: 'YYYY-MM-DD'
  });
});

$(function () {
  $("#default-table").dataTable({
    "bSort": false,
    "iDisplayLength": 25,
    "bLengthChange": true
  });
  $("#table-10rows").dataTable({
    "bSort": false,
    "iDisplayLength": 10,
    "bLengthChange": true
  });
});