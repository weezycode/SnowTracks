// add video url
document.querySelectorAll('.add_item_link')
    .forEach(btn => {
        btn.addEventListener("click", addFormToCollection)
    });

const addTagLink = document.createElement('a')
addTagLink.classList.add('add_item_link')
addTagLink.type = 'button '
addTagLink.innerText = 'Cliquez ici pour ajouter des videos'
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