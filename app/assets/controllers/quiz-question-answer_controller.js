import { Controller } from '@hotwired/stimulus';

/* stimulusFetch: 'lazy' */
export default class extends Controller {
    static targets = ["type", "answers"]


    connect() {
        this.typeTargets.forEach((element) => {
            if (element.value === "Choix multiple" || element.value === "Choix unique") {
                element.parentElement.parentElement.lastChild.classList.remove("hidden")
            }
        })
    }

    changeType(event) {
        if (event.target.value === "Choix multiple" || event.target.value === "Choix unique") {
            event.target.parentElement.parentElement.lastChild.classList.remove("hidden")
        } else {
            event.target.parentElement.parentElement.lastChild.classList.add("hidden")
        }
    }

}
