/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';
import './styles/style.css';

// start the Stimulus application
import './bootstrap';
import $ from 'jquery';

document.addEventListener("DOMContentLoaded", function (event) {


    const cartButtons = document.querySelectorAll('.cart-button');

    cartButtons.forEach(button => {

        button.addEventListener('click', cartClick);

    });

    function cartClick() {
        let button = this;
        button.classList.add('clicked');
    }


});



document
    .querySelectorAll('.add_item_link')
    .forEach(btn => {
        btn.addEventListener("click", addFormToCollection)
    });

const addTagLink = document.createElement('a')
addTagLink.classList.add('add_item_link')
addTagLink.type = 'button '
addTagLink.innerText = 'Ajout de video'
addTagLink.dataset.collectionHolderClass = 'video'

const newLinkLi = document.createElement('li').append(addTagLink)

const collectionHolder = document.querySelector('ul.video')
collectionHolder.appendChild(addTagLink)

const addFormToCollection = (e) => {
    const collectionHolder = document.querySelector('.' + e.currentTarget.dataset.collectionHolderClass);

    const item = document.createElement('li');

    item.innerHTML = collectionHolder
        .dataset
        .prototype
        .replace(
            /__name__/g,
            collectionHolder.dataset.index
        );

    collectionHolder.appendChild(item);

    collectionHolder.dataset.index++;
}

addTagLink.addEventListener("click", addFormToCollection)

console.log('Veuillez faire attention')

