import { Controller } from '@hotwired/stimulus';

/* stimulusFetch: 'lazy' */
export default class extends Controller {
    static targets = ["type", "answers"]


    connect() {
        this.typeTargets.forEach((element) => {
            if (element.value === "Choix multiple" || element.value === "Choix unique") {
                let responseSection = element.parentElement.parentElement.lastElementChild
                responseSection.classList.remove("hidden")
                responseSection.querySelector("div[data-form-collection-prototype-value] > ul").classList.remove("hidden")
            }
        })
    }

    changeType(event) {
        let responseSection = event.target.parentElement.parentElement.lastElementChild
        if (event.target.value === "Choix multiple" || event.target.value === "Choix unique") {
            responseSection.classList.remove("hidden")
            responseSection.querySelector("div[data-form-collection-prototype-value] > ul").classList.remove("hidden")
        } else {
            responseSection.classList.add("hidden")
            responseSection.querySelector("div[data-form-collection-prototype-value] > ul").classList.remove("hidden")
        }

        let nextSibling = event.target.parentElement.nextElementSibling
        console.log(nextSibling)
        // if (event.target.value === "Vrai/Faux") {
        //     nextSibling.classList.remove("hidden")
        // } else {
        //     nextSibling.classList.add("hidden")
        // }
    }
}
