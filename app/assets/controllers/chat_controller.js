import {Controller} from '@hotwired/stimulus';

export default class extends Controller {
    static targets = [
        "formContainer",
        "defaultContainer",
    ]

    connect() {
        this.positionForm()
    }

    positionForm() {
        let headerChatHeight = document.getElementById("header-chat").scrollHeight
        let messageForm = document.getElementById("message_form").scrollHeight
        let navbarHeight = document.getElementById("main-navbar").scrollHeight
        let formHeight = this.formContainerTarget.scrollHeight

        let height = 100 - (((formHeight + navbarHeight + headerChatHeight - (messageForm / 1.75)) / window.innerHeight) * 100)

        this.defaultContainerTarget.style.height = height + "vh"
        this.defaultContainerTarget.scrollTop = this.defaultContainerTarget.scrollHeight

    }
}
