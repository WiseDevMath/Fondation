import { Controller } from '@hotwired/stimulus';



export default class extends Controller {

    static values = {
        addLabel: String,
        deleteLabel: String
    }
    
    connect() {
        console.log(this.element)
        this.index = this.element.childElementCount
        console.log(this.element.childNodes.length)
        const btn= document.createElement('button')
        btn.setAttribute('class','btn btn-secondary btn-form-collection')
        btn.innerText = this.addLabelValue || 'Ajouter un élément'
        btn.setAttribute('type','button')
        btn.addEventListener('click',this.addElement)
        for (var i = 0; i < this.element.childNodes.length; i++) {
            var child = this.element.childNodes[i];
            if (child.innerHTML)
            this.addDeleteButton(child);
        }
        this.element.append(btn)

    }

    addElement = (e) => {
        e.preventDefault()
        
        const element = document.createRange().createContextualFragment(
            this.element.dataset['prototype'].replaceAll('__name__',this.index)
        ).firstElementChild

        element.setAttribute('style','margin-block:15px;')
        for (var i = 0; i < element.childNodes.length; i++) {
            var child = element.childNodes[i];
            if (child.innerHTML)
             child.setAttribute('style','float:left;')
        }

        this.addDeleteButton(element)
        this.index++
        e.currentTarget.insertAdjacentElement('beforebegin',element)
    }

    addDeleteButton = (item) => {

        const btn= document.createElement('div')
        btn.setAttribute('class','btn btn-danger btn-sm btn-action')
        btn.setAttribute('style','margin-left:10px;')
        btn.innerHTML = '<i class="bi bi-trash" style="font-size:22px;"></i>';
        item.append(btn)
        btn.addEventListener('click', e =>  {
            e.preventDefault()
            item.remove()
        })

    }

}

