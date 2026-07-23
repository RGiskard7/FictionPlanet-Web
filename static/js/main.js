$(document).ready(function() {
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    if (csrfToken) {
        $.ajaxSetup({
            headers: { 'X-CSRF-Token': csrfToken }
        });
    }

    $(window).scroll(function() { // Buttom top jquery
        if ($(this).scrollTop() > 100) {
            $('#chatButton').css("bottom", "5em");
            $('#scroll').fadeIn();        
        } else {
            $('#chatButton').css("bottom", "1.25em");
            $('#scroll').fadeOut();
        }
    });
       
    $('#scroll').click(function() { // Buttom top
        $("html, body").animate({scrollTop: 0}, 600);
        return false;
    });

    dinamicMainHeight();
    treeViewToggler();
    saveLastTab();
                  
    var date = new Date();
    var yyyy = date.getFullYear().toString();
    var mm = (date.getMonth() + 1).toString().length === 1 ? "0" + (date.getMonth() + 1).toString() : (date.getMonth() + 1).toString();
    var dd  = (date.getDate()).toString().length === 1 ? "0" + (date.getDate()).toString() : (date.getDate()).toString();
    
    $('#calendarMini').fullCalendar({
        defaultView: 'month',
        themeSystem: 'bootstrap4',
        columnFormat: 'ddd', //Nombre Completo de los Dias.
        firstDay: 1, //Para que comience en Domingo la semana
        buttonIcons: true,
        dayNamesShort: ["D", "L", "M", "X", "J", "V", "S"],
        dayNamesMin: ["D", "L", "M", "X", "J", "V", "S"],
        /*dayNames: ["D", "L", "M", "X", "J", "V", "S"],*/
        header: {
            language: 'es', //Lenguaje en Español
            left: 'prev,next',
            center: 'title',
            right: 'today'
        },
        
        businessHours: {
            dow: [1, 2, 3, 4, 5] // dias de semana, 0 = Domingo
        },
        displayEventTime : false,//NO Mostrar la Hora
        defaultDate: yyyy + "-" + mm + "-" + dd,
        resourceAreaWidth: 230,
        aspectRatio: 1.5,
        scrollTime: '00:00',
        editable: true,
        eventLimit: false, //esta en false para que muestre todos los eventos y no el link mas
        selectable: true,
        selectHelper: true,
                
        events: function(start, end, timezone, callback) {
            jQuery.ajax({
                url: '/app/calendarEventsController.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    action: "view",
                    start: start.format(),
                    end: end.format()
                },                
                success: function(events) {
                    callback(events);
                }
            });
        },
        
        eventClick:  function(event, jsEvent, view) {  // when some one click on any event 
            var starttime = $.fullCalendar.moment(event.start).format('DD-MM-YYYY HH:mm:ss');
            var endtime = $.fullCalendar.moment(event.end).format('DD-MM-YYYY HH:mm:ss');
            var mywhen = starttime + ' --> ' + endtime;

            $('#calendarModal #modalTitle').val(event.title);
            $('#calendarModal #modalTitle').html(event.title);
            $('#calendarModal #start').val(starttime);
            $('#calendarModal #end').val(endtime);
            $('#modalWhen').text(mywhen);
            $('#calendarModal #color').val(event.color);
            $('#calendarModal #eventID').val(event.id);
            $('#calendarModal #eventID2').val(event.id);
            $('#calendarModal').modal();
        },
                 
        select: function(start, end) {
            $('#newEventCalendarModal #newStart').val($.fullCalendar.moment(start).format('DD-MM-YYYY HH:mm:ss'));
            $('#newEventCalendarModal #newEnd').val($.fullCalendar.moment(end).format('DD-MM-YYYY HH:mm:ss'));
            $('#newEventCalendarModal').modal('show');
        }
        
    });
    
    $('#calendarDiary').fullCalendar({
        defaultView: 'listWeek',
        themeSystem: 'bootstrap4',
        resourceAreaWidth: 230,
        aspectRatio: 1.5,
        scrollTime: '00:00',
        columnFormat: 'ddd', //Nombre Completo de los Dias.
        firstDay: 1, //Para que comience en Domingo la semana
        buttonIcons: true,
        header: {
            language: 'es', //Lenguaje en Español
            left: 'prev,next', //Opciones de Menus para avanzar o ir al Dia Actual
            center: 'title',
            right: 'today'
        },

        businessHours: {
            dow: [1, 2, 3, 4, 5] // dias de semana, 0 = Domingo
        },
        displayEventTime : true,
        defaultDate: yyyy + "-" + mm + "-" + dd,
        editable: true,
        eventLimit: false, //esta en false para que muestre todos los eventos y no el link mas
        selectable: true,
        selectHelper: true,
                
        events: function(start, end, timezone, callback) {
            jQuery.ajax({
                url: '/app/calendarEventsController.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    action: "view",
                    start: start.format(),
                    end: end.format()
                },                
                success: function(events) {
                    callback(events);
                }
            });
        },
        
        eventClick:  function(event, jsEvent, view) {  // when some one click on any event        
            var starttime = $.fullCalendar.moment(event.start).format('DD-MM-YYYY HH:mm:ss');
            var endtime = $.fullCalendar.moment(event.end).format('DD-MM-YYYY HH:mm:ss');
            var mywhen = starttime + ' -- ' + endtime;

            $('#calendarModal #modalTitle').val(event.title);
            $('#calendarModal #modalTitle').html(event.title);
            $('#calendarModal #start').val(starttime);
            $('#calendarModal #end').val(endtime);
            $('#modalWhen').text(mywhen);
            $('#calendarModal #color').val(event.color);
            $('#calendarModal #eventID').val(event.id);
            $('#calendarModal').modal();
        },
        
        select: function(start, end) {
            $('#newEventCalendarModal #start').val($.fullCalendar.moment(start).format('DD-MM-YYYY HH:mm:ss'));
            $('#newEventCalendarModal #end').val($.fullCalendar.moment(end).format('DD-MM-YYYY HH:mm:ss'));
            $('#newEventCalendarModalt').modal('show');
        }
    });
    
    $(document).on('hidden.bs.modal', '#newEventCalendarModal', function () { // Reset modal
        $(this).find('form').trigger('reset');
    });
    
    $(document).on('hidden.bs.modal', '#calendarModal', function () { // Reset modal
        $(this).find('form').trigger('reset');
    });
    
    $('a[data-confirm]').click(function () {
        var href = $(this).attr('href');
        $('#dataConfirmModal').find('.modal-body').text($(this).attr('data-confirm'));
        $('#dataConfirmOK').attr('href', href);
        $('#dataConfirmModal').modal({show: true});
        return false;
    });
    
    $('form[data-confirm]').click(function () { // Para eliminar
        var action = $(this).attr('action');
        $('#dataConfirmModal').find('.modal-body').text($(this).attr('data-confirm'));
        $('#dataConfirmOK').attr('href', action);
        $('#dataConfirmModal').modal({show: true});
        return false;
    });
    
    /*$('button[data-confirm]').click(function () {
        var action = $(this).attr('action');
        $('#dataConfirmModal').find('.modal-body').text($(this).attr('data-confirm'));
        $('#dataConfirmOK').attr('href', action);
        $('#dataConfirmModal').modal({show: true});
        return false;
    });*/
    
});

/*function mouseClickLinkFunction(e) {
    e.preventDefault();
}*/

function dinamicMainHeight() {
    /*Height top: 81px y height footer: 378px*/
    heightHead = document.getElementById("topNavbar").offsetHeight;
    heightFooter = document.getElementById("footerContainer").offsetHeight;
    
    document.getElementById("main").style.minHeight = "calc(95.70vh - " + heightHead + "px - " + heightFooter + "px)"; /*95.68vh*/
}

var open1 = true;
function optionSidebarToggler() {
    var mediaQuery = window.matchMedia('(max-width: 768px)');
    if (open1) {
        if (mediaQuery.matches) {
            document.getElementById("optionSidebar").style.width = "100%";
        } else {
            document.getElementById("optionSidebar").style.width = "280px";
        }
        document.getElementById("iconToggleSidebar").classList.remove('fa', 'fa-angle-double-right');
        document.getElementById("iconToggleSidebar").classList.add('fa', 'fa-angle-double-left');
        this.open1 = false;
    } else {
        document.getElementById("optionSidebar").style.width = "0px"; // 85px
        document.getElementById("iconToggleSidebar").classList.remove('fa', 'fa-angle-double-left');
        document.getElementById("iconToggleSidebar").classList.add('fa', 'fa-angle-double-right');
        this.open1 = true;
    }
}

function treeViewToggler() {
    var toggler = document.getElementsByClassName("caret");
    var i;

    for (i = 0; i < toggler.length; i++) {
      toggler[i].addEventListener("click", function() {
        this.parentElement.querySelector(".nested").classList.toggle("active");
        this.classList.toggle("caret-down");
      });
    }
}

function saveLastTab() {
    /*Mantener las pestañas abiertas al recargar la pagina*/
    /*$('a[data-toggle="tab"]').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    });*/
    
    $('a[data-toggle="tab"]').on("shown.bs.tab", function (e) {
        var id = $(e.target).attr("href");
        localStorage.setItem('selectedTab', id)
    });

    var selectedTab = localStorage.getItem('selectedTab');
    if (selectedTab != null) {
        $('a[data-toggle="tab"][href="' + selectedTab + '"]').tab('show');
    }
    
    if (window.location.pathname.indexOf('profile') == -1) {
        localStorage.removeItem('selectedTab');
    }
}
