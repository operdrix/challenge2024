import { Controller } from "@hotwired/stimulus";

// FullCalendarJS
import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import listPlugin from '@fullcalendar/list';

/* stimulusFetch: 'lazy' */
export default class extends Controller {
    static targets = ['calendar'];

    static values = {
        url: String,
    }

    connect() {
        this.initCalendar();
    }

    initCalendar() {
        let calendar = new Calendar(this.calendarTarget, {
            plugins: [dayGridPlugin, timeGridPlugin, listPlugin],
            initialView: 'timeGridWeek',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,listWeek'
            },
            locale: 'fr',
            hiddenDays: [7],
            allDaySlot: false,
            events: {
                url: this.urlValue,
                method: 'POST'
            }
        });

        calendar.render();
    }
}