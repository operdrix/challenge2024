import { Controller } from '@hotwired/stimulus';

/* stimulusFetch: 'lazy' */
export default class extends Controller {
    static targets = ["type", "answers"]


    connect() {
        this.typeTargets.forEach((element) => {
            if (element.value === "Choix multiple" || element.value === "Choix unique" || element.value === "Vrai/Faux") {
                let lastChild = element.parentElement.parentElement.lastChild
                lastChild.classList.remove("hidden")
                lastChild.querySelector("div[data-form-collection-prototype-value] > ul").classList.remove("hidden")
            }
        })
    }

    changeType(event) {
        let lastChild = event.target.parentElement.parentElement.lastChild
        if (event.target.value === "Choix multiple" || event.target.value === "Choix unique") {
            lastChild.classList.remove("hidden")
            lastChild.querySelector("div[data-form-collection-prototype-value] > ul").classList.remove("hidden")
        } else {
            lastChild.classList.add("hidden")
            lastChild.querySelector("div[data-form-collection-prototype-value] > ul").classList.remove("hidden")
        }

        let nextSibling = event.target.parentElement.nextElementSibling
        if (event.target.value === "Vrai/Faux") {
            nextSibling.classList.remove("hidden")
        } else {
            nextSibling.classList.add("hidden")
        }
    }

}
