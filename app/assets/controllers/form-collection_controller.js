import { Controller } from '@hotwired/stimulus';

/* stimulusFetch: 'lazy' */
export default class extends Controller {
    static targets = ["collectionContainer", "field"]

    static values = {
        index: Number,
        prototype: String,
        itemsCount: Number,
    }

    connect() {
        this.index = this.indexValue = this.fieldTargets.length;
    }

    addCollectionElement(event) {
        const item = document.createElement('li');
        item.setAttribute('data-form-collection-target', 'field');
        item.innerHTML = this.prototypeValue.replace(/__name__/g, this.indexValue);
        item.innerHTML += `<button type="button" class="btn btn-danger btn-sm remove-item" data-action="click->form-collection#removeItem">
        retirer
    </button>`;
        this.collectionContainerTarget.appendChild(item);
        this.indexValue++;
    }

    removeItem(event) {
        this.fieldTargets.forEach(element => {
            if (element.contains(event.target)) {
                element.remove()
                this.itemsCountValue--
            }
        })
    }
}
