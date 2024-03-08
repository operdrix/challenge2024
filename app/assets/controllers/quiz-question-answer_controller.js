import { Controller } from '@hotwired/stimulus';

/* stimulusFetch: 'lazy' */
export default class extends Controller {
    static targets = ["type", "answers"]


    connect() {
        this.typeTargets.forEach((element) => {
            let responseSection = element.parentElement.parentElement.lastElementChild
            if (element.value === "Choix multiple" || element.value === "Choix unique") {
                responseSection.classList.remove("hidden")
                responseSection.querySelector("div[data-form-collection-prototype-value] > ul").classList.remove("hidden")
            }

            let nextSibling = element.parentElement.nextElementSibling
            if (element.value === "Vrai/Faux" && responseSection.classList.contains("hidden")) {
                nextSibling.classList.remove("hidden")
            } else {
                nextSibling.classList.add("hidden")
            }
        })
    }

    changeType(event) {
        let responseSection = event.target.parentElement.parentElement.lastElementChild
        if (event.target.value === "Choix multiple" || event.target.value === "Choix unique") {
            responseSection.classList.remove("hidden")
        } else {
            responseSection.classList.add("hidden")
        }
        responseSection.querySelector("div[data-form-collection-prototype-value] > ul").classList.remove("hidden")
        let nextSibling = event.target.parentElement.nextElementSibling
        if (event.target.value === "Vrai/Faux" && responseSection.classList.contains("hidden")) {
            nextSibling.classList.remove("hidden")
        } else {
            nextSibling.classList.add("hidden")
        }

    }
}
