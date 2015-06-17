/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    var $collectionHolder;
    // setup an "add a spec" link
    var $addSpecLink = $('<a href="#" class="add_spec_link">Add a specification</a>');
    var $newLinkLi = $('<li></li>').append($addSpecLink);


    jQuery(document).ready(function() {
        // Get the ul that holds the collection of specs
        $collectionHolder = $('ul.specifications');
        
        // add a delete link to all of the existing tag form li elements
        $collectionHolder.find('li').each(function() {
        addSpecFormDeleteLink($(this));
        });

        // add the "add a spec" anchor and td to the specs tr
        $collectionHolder.append($newLinkLi);

        // count the current form inputs we have (e.g. 2), use that as the new
        // index when inserting a new item (e.g. 2)
        $collectionHolder.data('index', $collectionHolder.find(':input').length);

        $addSpecLink.on('click', function(e) {
            // prevent the link from creating a "#" on the URL
            e.preventDefault();

            // add a new spec form (see next code block)
            addSpecForm($collectionHolder, $newLinkLi);
        });
    });
    function addSpecForm($collectionHolder, $newLinkLi) {
        // Get the data-prototype explained earlier
        var prototype = $collectionHolder.data('prototype');

        // get the new index
        var index = $collectionHolder.data('index');

        // Replace '__name__' in the prototype's HTML to
        // instead be a number based on how many items we have
        var newForm = prototype.replace(/__name__/g, index);

        // increase the index with one for the next item
        $collectionHolder.data('index', index + 1);

        // Display the form in the page in an li, before the "Add a tag" link li
        var $newFormLi = $('<li></li>').append(newForm);
        $newLinkLi.before($newFormLi);
        // add a delete link to the new form
        addSpecFormDeleteLink($newFormLi);

    }
    
    function addSpecFormDeleteLink($specFormLi) {
        var $removeFormA = $('<a href="#">delete this specification</a>');
        $specFormLi.append($removeFormA);

        $removeFormA.on('click', function(e) {
            // prevent the link from creating a "#" on the URL
            e.preventDefault();

            // remove the li for the tag form
            $specFormLi.remove();
        });
    }

