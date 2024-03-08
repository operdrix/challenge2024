import { Controller } from "@hotwired/stimulus";

// FullCalendarJS
import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import listPlugin from '@fullcalendar/list';

// Modal
import { Modal } from 'flowbite'
import { EventImpl } from "@fullcalendar/core/internal";
let modal;

/* stimulusFetch: 'lazy' */
export default class extends Controller {
    static targets = [
        'calendar',
        'modal',
        'modalTitle',
        'modalGrade',
        'modalStudents',
        'modalDate',
        'modalOnline',
        'modalSessionLink',
        'modalPlace'
    ];

    static values = {
        url: String,
    }


    connect() {
        this.initModal();
        this.initCalendar();
    }

    initModal() {
        const options = {
            placement: 'center',
            backdrop: 'dynamic',
            closable: true
        };

        const instanceOption = {
            id: 'calendarModal',
            override: true
        };

        modal = new Modal(this.modalTarget, options, instanceOption);
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
            hiddenDays: [0],
            allDaySlot: false,
            slotMinTime: '8:00',
            slotMaxTime: '22:00',
            height: 'auto',
            events: {
                url: this.urlValue,
                method: 'POST'
            },
            eventClick: function (info) {
                console.log(info.event);
                // this.modalTitleTarget.innerText = info.event.extendedProps.trainingTitle;
                // this.modalDateTarget.innerText = info.event.startStr;

                // // Cours pour une classe ou des étudiants individuels
                // if (info.event.extendedProps.gradeLabel) {
                //     this.modalGradeTarget.innerText = info.event.extendedProps.gradeLabel;
                //     this.modalGradeTarget.classList.remove('hidden');

                //     this.modalStudents.classList.add('hidden');
                // } else {
                //     this.modalGradeTarget.classList.add('hidden');
                //     this.modalStudents.classList.remove('hidden');
                // }

                // // Session distancielle ou présentielle
                // if (info.event.extendedProps.isOnline) {
                //     this.modalOnlineTarget.innerText = "Distanciel";
                //     this.modalSessionLinkTarget.classList.remove('hidden');
                //     this.modalSessionLinkTarget.innerText = info.event.extendedProps.sessionLink;
                //     this.modalPlaceTarget.classList.add('hidden');
                //     this.modalPlaceTarget.innerText = '';
                // } else {
                //     this.modalOnlineTarget.innerText = "Présentiel";
                //     this.modalSessionLinkTarget.classList.add('hidden');
                //     this.modalSessionLinkTarget.innerText = '';
                //     this.modalPlaceTarget.innerText = info.event.extendedProps.place;
                //     this.modalPlaceTarget.classList.remove('hidden');
                // }
            }
        });

        calendar.render();
    }

    closeModal() {
        modal.hide();
    }
}