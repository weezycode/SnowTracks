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



let $addVideoLink = $('<a href="#" class="add_item_link btn btn-primary">Add a url</a>');
let $newLinkLi = $('<li></li>').append($addVideoLink);

$(document).ready(function () {
    //Video add
    // Get the ul that holds the collection of Videos
    let $collectionHolder = $('ul.video');

    // add the "add a video" anchor and li to the videos ul
    $collectionHolder.append($newLinkLi);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $collectionHolder.data('index', $collectionHolder.find(':input').length);

    $addVideoLink.on('click', function (e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // add a new Video form (see code block below)
        addVideoForm($collectionHolder, $newLinkLi);
    });

    function addVideoForm($collectionHolder, $newLinkLi) {
        // Get the data-prototype explained earlier
        let prototype = $collectionHolder.data('prototype');

        // get the new index
        let index = $collectionHolder.data('index');

        // Replace '$$name$$' in the prototype's HTML to
        // instead be a number based on how many items we have
        let newForm = prototype.replace(/__name__/g, index);

        // increase the index with one for the next item
        $collectionHolder.data('index', index + 1);

        // Display the form in the page in an li, before the "Add a Video" link li
        let $newFormLi = $('<li></li>').append(newForm);

        // also add a remove button, just for this example
        $newFormLi.append('<a href="#" class="remove-video btn btn-danger">Delete URL</a>');

        $newLinkLi.before($newFormLi);

        // handle the removal, just for this example
        $('.remove-video').click(function (e) {
            e.preventDefault();

            $(this).parent().remove();

            return false;
        });
    }

    /* ****** LoadMore Tricks buttons ***** */
    let tricksPerPage = 10;
    let tricks = $(".trick");

    if (tricksPerPage < 10) {
        $(".scroll").hide();
    }

    if (tricks.length <= tricksPerPage) {
        $("#loadMoreTricksBtn").hide();
    }

    for (let i = tricksPerPage; i <= tricks.length - 1; i++) {
        tricks[i].remove();
    }

    $("#loadMoreTricksBtn").on("click", function (e) {
        e.preventDefault();
        tricksPerPage += 5;
        for (var i = 0; i <= tricksPerPage - 1; i++) {
            $("#tricksList").append(tricks[i]);
        }
        if (tricks.length <= tricksPerPage) {
            $("#loadMoreTricksBtn").hide();
        }
        if (tricksPerPage >= 15) {
            $(".scroll").show();
        }
    });

    //Get the button down 
    let mybutton = document.getElementById("btn-back-to-top");
    let mybuttonDown = document.getElementById("btn-go-to-down");

    // When the user scrolls down 20px from the top of the document, show the button
    window.onscroll = function () {
        scrollFunction();
    };

    function scrollFunction() {
        if (
            document.body.scrollTop > 1200 ||
            document.documentElement.scrollTop > 1200
        ) {
            mybutton.style.display = "block";
            mybuttonDown.style.display = "none";
        } else {
            mybutton.style.display = "none";
            mybuttonDown.style.display = "block";
        }
    }
    // When the user clicks on the button, scroll to the top of the document
    mybutton.addEventListener("click", backToTop);
    //mybutton.addEventListener("click", backToDown);

    function backToTop() {
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
    }

    document.addEventListener("DOMContentLoaded", function (_event) {


        const cartButtons = document.querySelectorAll('.cart-button');

        cartButtons.forEach(button => {

            button.addEventListener('click', cartClick);

        });

        function cartClick() {
            let button = this;
            button.classList.add('clicked');
        }


    });


});




//Btn Form
$("body").on("submit", "form", function () {
    $(this).submit(function () {
        return false;
    });
    return true;
});




console.log('Veuillez faire attention');


