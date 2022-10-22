$(document).ready(function () {
    // init Isotope
    var $grid = $('.grid').isotope({
        itemSelector: '.grid-item',
        layoutMode: 'masonry',
        //masonry: {
            //columnWidth: '.grid-sizer'
        //},
        sortBy: 'name',
        sortAscending: true,
        getSortData: {
            name: '[data-name]',
            type: '[data-type]',
            updated: '[data-updated] parseInt'
        }
    });

    // store filter for each group
    var filters = {};

    // bind filter button click
    $('.filters').on( 'click', '.btn', function( event ) {
        var $button = $( event.currentTarget );
        // get group key
        var $buttonGroup = $button.parents('.btn-group');
        var filterGroup = $buttonGroup.attr('data-filter-group');
        // set filter for group
        filters[ filterGroup ] = $button.attr('data-filter');
        // combine filters
        var filterValue = concatValues( filters );
        // set filter for Isotope
        $grid.isotope({ filter: filterValue });
    });

    // bind sort button click
    $('#sort-group').on( 'click', 'button', function() {
        var sortByValue = $(this).attr('data-sort-by');
        $grid.isotope({ sortBy: sortByValue });
    });

    // bind sort direction button click
    $('#sort-dir-group').on( 'click', 'button', function() {
        var sortDirValue = true;
        if ($(this).attr('data-sort-dir') == 'desc') {
            sortDirValue = false;
        }
        $grid.isotope({ sortAscending: sortDirValue });
    });

    // change is-checked class on buttons
    $('.btn-group').each( function( i, buttonGroup ) {
        var $buttonGroup = $( buttonGroup );
        $buttonGroup.on( 'click', 'button', function() {
            $buttonGroup.find('.active').removeClass('active');
            $( this ).addClass('active');
        });
    });

    // flatten object by concatting values
    function concatValues( obj ) {
        var value = '';
        for ( var prop in obj ) {
            value += obj[ prop ];
        }
        return value;
    }
});
