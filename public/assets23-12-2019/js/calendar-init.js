$(document).ready(function() {
    var e = new Date,
        t = e.getDate(),
        a = e.getMonth(),
        l = e.getFullYear();
    $("#external-events div.external-event").each(function() {
        var e = {
            title: $.trim($(this).text())
        };
        $(this).data("eventObject", e), $(this).draggable({
            zIndex: 999,
            revert: !0,
            revertDuration: 0
        })
    });
    var n = $("#calendar").fullCalendar({
        header: {
            left: "title",
            center: "agendaDay,agendaWeek,month",
            right: "prev,next today"
        },
        editable: !0,
        firstDay: 1,
        selectable: !0,
        defaultView: "month",
        axisFormat: "h:mm",
        columnFormat: {
            month: "ddd",
            week: "ddd d",
            day: "dddd M/d",
            agendaDay: "dddd d"
        },
        titleFormat: {
            month: "MMMM YYYY",
            week: "MMMM YYYY",
            day: "MMMM YYYY"
        },
        allDaySlot: !1,
        selectHelper: !0,
        select: function(e, t, a) {
            var l = prompt("Event Title:");
            l && n.fullCalendar("renderEvent", {
                title: l,
                start: e,
                end: t,
                allDay: a
            }, !0), n.fullCalendar("unselect")
        },
        droppable: !0,
        drop: function(e, t) {
            var a = $(this).data("eventObject"),
                l = $.extend({}, a);
            l.start = e, l.allDay = t, $("#calendar").fullCalendar("renderEvent", l, !0), $("#drop-remove").is(":checked") && $(this).remove()
        },
        events: [{
            title: "All Day Event",
            start: new Date(l, a, 1)
        }, {
            id: 999,
            title: "Repeating Event",
            start: new Date(l, a, t - 5, 18, 0),
            allDay: !1,
            className: "bg-teal"
        }, {
            id: 999,
            title: "Meeting",
            start: new Date(l, a, t - 3, 16, 0),
            allDay: !1,
            className: "bg-purple"
        }, {
            id: 999,
            title: "Meeting",
            start: new Date(l, a, t + 4, 16, 0),
            allDay: !1,
            className: "bg-warning"
        }, {
            title: "Meeting",
            start: new Date(l, a, t, 10, 30),
            allDay: !1,
            className: "bg-danger"
        }, {
            title: "Lunch",
            start: new Date(l, a, t, 12, 0),
            end: new Date(l, a, t, 14, 0),
            allDay: !1,
            className: "bg-success"
        }, {
            title: "Birthday Party",
            start: new Date(l, a, t + 1, 19, 0),
            end: new Date(l, a, t + 1, 22, 30),
            allDay: !1,
            className: "bg-brown"
        }, {
            title: "Click for Google",
            start: new Date(l, a, 28),
            end: new Date(l, a, 29),
            url: "http://google.com/",
            className: "bg-pink"
        }]
    })
});