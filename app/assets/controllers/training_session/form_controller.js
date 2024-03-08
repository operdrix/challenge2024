import { Controller } from '@hotwired/stimulus';

/* stimulusFetch: 'lazy' */
export default class extends Controller {
    static targets = [
        "isOnline",
        "sessionLinkContainer"
    ]

    connect() {
        this.handleIsOnline()
    }

    handleIsOnline() {
        if (this.isOnlineTarget.checked) {
            this.sessionLinkContainerTarget.classList.remove("hidden")
        } else {
            this.sessionLinkContainerTarget.classList.add("hidden")
        }
    }
}
