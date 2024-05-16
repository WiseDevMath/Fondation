import { Controller } from '@hotwired/stimulus';



export default class extends Controller {

    static values = {
        addLabel: String,
        deleteLabel: String
    }
    
    connect() {
        this.index = this.element.childElementCount
        const btn= document.createElement('button')
        btn.setAttribute('class','btn btn-secondary btn-form-collection')
        btn.innerText = this.addLabelValue || 'Ajouter un élément'
        btn.setAttribute('type','button')
        btn.addEventListener('click',this.addElement)
        this.element.childNodes.forEach(this.addDeleteButton)
        this.element.append(btn)

    }

    addElement = (e) => {
        e.preventDefault()
        const element = document.createRange().createContextualFragment(
            this.element.dataset['prototype'].replaceAll('__name__',this.index)
        ).firstElementChild
        this.addDeleteButton(element)
        this.index++
        e.currentTarget.insertAdjacentElement('beforebegin',element)
    }

    addDeleteButton = (item) => {

        const btn= document.createElement('div')
        btn.setAttribute('class','btn btn-danger btn-sm btn-action')
        btn.innerHTML = '<i class="bi bi-trash" style="font-size:22px;"></i>';
        item.append(btn)
        btn.addEventListener('click', e =>  {
            e.preventDefault()
            item.remove()
        })

    }

}

