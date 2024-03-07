import {Controller} from '@hotwired/stimulus';

export default class extends Controller {
    static targets = [
        "formContainer",
        "defaultContainer",
        "header"
    ]

    connect() {
        let navbarHeight = document.getElementById("main-navbar").scrollHeight
        let headerHeight = this.headerTarget.scrollHeight
        let formHeight = this.formContainerTarget.scrollHeight

        let height = 100 - (((headerHeight + formHeight + navbarHeight) / window.innerHeight) * 100)

        this.defaultContainerTarget.style.height = height + "vh"
        window.addEventListener("DOMContentLoaded", () => {
            this.defaultContainerTarget.scrollTop = this.defaultContainerTarget.scrollHeight

        })
    }
}
