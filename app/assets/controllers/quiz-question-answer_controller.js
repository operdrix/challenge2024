import { Controller } from '@hotwired/stimulus';

/* stimulusFetch: 'lazy' */
export default class extends Controller {
    static targets = ["type", "answers"]


    connect() {
        if (this.typeTarget.value === "Choix multiple" || this.typeTarget.value === "Choix unique") {
            this.answersTarget.classList.remove("hidden")
        }
    }

    changeType(event) {
        if (event.target.value === "Choix multiple" || event.target.value === "Choix unique") {
            this.answersTarget.classList.remove("hidden")
        } else {
            this.answersTarget.classList.add("hidden")
        }
    }

}
