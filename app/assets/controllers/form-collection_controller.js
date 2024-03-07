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
        item.innerHTML += `<button type="button" class="mt-2 focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900" data-action="click->form-collection#removeItem">
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
        event.originalTarget.parentElement.remove()
    }

    addQuestionsCollectionElement(event) {
        const item = document.createElement('li');
        item.className = "grow basis-80 max-w-sm dark:bg-gray-800"
        item.setAttribute('data-form-collection-target', 'field');
        item.innerHTML = this.prototypeValue.replace(/__name__/g, this.indexValue);
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

    questionRemoveItem(event) {
        event.target.parentElement.parentElement.remove()
    }
}
