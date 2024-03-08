import { Controller } from "@hotwired/stimulus";

// FullCalendarJS
import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import listPlugin from '@fullcalendar/list';

// Modal
import { Modal } from 'flowbite'
import { EventImpl } from "@fullcalendar/core/internal";

/* stimulusFetch: 'lazy' */
export default class extends Controller {

    modal;

    static targets = [
        'calendar',
        'modal',
        'modalTitle',
        'modalGrade',
        'modalTeacher',
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

        this.modal = new Modal(this.modalTarget, options, instanceOption);
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
            eventClick: (info) => {
                const { extentedProps } = info.event.extendedProps;
                console.log(extentedProps);
                console.log(this.modalTitleTarget.innerText);
                this.modalTitleTarget.innerText = extentedProps.trainingTitle + ' - ' + extentedProps.trainingDifficulty;
                this.modalDateTarget.innerText = extentedProps.sessionDate;
                this.modalTeacherTarget.innerText = extentedProps.teacherName;

                // Cours pour une classe ou des étudiants individuels
                if (extentedProps.gradeLabel) {
                    this.modalGradeTarget.innerText = extentedProps.gradeLabel;
                    this.modalGradeTarget.parentElement.classList.remove('hidden');

                    this.modalStudentsTarget.parentElement.classList.add('hidden');
                } else {
                    this.modalGradeTarget.parentElement.classList.add('hidden');
                    this.modalStudentsTarget.parentElement.classList.remove('hidden');
                }

                console.log(extentedProps.gradeLabel);
                // Session distancielle ou présentielle
                if (extentedProps.isOnline) {
                    this.modalOnlineTarget.innerText = "Distanciel";
                    this.modalSessionLinkTarget.parentElement.classList.remove('hidden');
                    this.modalSessionLinkTarget.innerText = extentedProps.sessionLink;
                    this.modalPlaceTarget.parentElement.classList.add('hidden');
                    this.modalPlaceTarget.innerText = '';
                } else {
                    this.modalOnlineTarget.innerText = "Présentiel";
                    this.modalSessionLinkTarget.parentElement.classList.add('hidden');
                    this.modalSessionLinkTarget.innerText = '';
                    this.modalPlaceTarget.innerText = extentedProps.place;
                    this.modalPlaceTarget.parentElement.classList.remove('hidden');
                }

                this.modal.show();
            }
        });

        calendar.render();
    }

    closeModal() {
        this.modal.hide();
    }
}