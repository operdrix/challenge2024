import {Controller} from '@hotwired/stimulus';

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
        item.classList.add("w-full", "p-6", "bg-white", "border", "border-gray-200", "rounded-lg", "shadow", "dark:bg-gray-800", "dark:border-gray-700")
        item.setAttribute('data-form-collection-target', 'field');
        item.innerHTML = this.prototypeValue.replace(/__name__/g, this.indexValue);
        item.innerHTML += `<button type="button" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900" data-action="click->form-collection#removeItem">
        Retirer
    </button>`;
        this.collectionContainerTarget.appendChild(item);

        let sourcedScript;
        let scripts = Array.from(item.querySelectorAll("script"))
        let newScripts = []
        scripts.forEach(element => {
            let data = (element.text || element.textContent || element.innerHTML || "" ),
                script = document.createElement("script");
            script.type = "text/javascript";
            if (element.hasAttribute('src')) {
                script.setAttribute('src', element.getAttribute('src'));
                sourcedScript = script;
            } else {
                try {
                    script.appendChild(document.createTextNode(data));
                } catch(e) {
                    script.text = data;
                }
                newScripts.push(script);
            }
        })

        if (sourcedScript === undefined) {
            newScripts.forEach(script => {
                item.appendChild(script);
            });
        } else {
            item.appendChild(sourcedScript);
            sourcedScript.addEventListener('load', function() {
                newScripts.forEach(script => {
                    item.appendChild(script);
                });
            });
        }

        this.indexValue++;
    }

    removeItem(event) {
        this.fieldTargets.forEach(element => {
            if (element.contains(event.target)) {
                element.remove()
                this.itemsCountValue--
                event.originalTarget.parentElement.remove()
            }
        })
    }
}
