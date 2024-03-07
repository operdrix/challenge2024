import {Controller} from "@hotwired/stimulus";

export default class extends Controller {
    static targets = ['type', "gradeContainer", "studentContainer"];

    connect() {
        this.handleChangeType()
    }

    handleChangeType() {
        let type = this.typeTarget.value

        if (type === "grade") {
            this.gradeContainerTarget.classList.remove("hidden")
            this.studentContainerTarget.classList.add("hidden")
        } else {
            this.gradeContainerTarget.classList.add("hidden")
            this.studentContainerTarget.classList.remove("hidden")
        }
    }
}