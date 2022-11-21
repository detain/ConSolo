// store filter for each group
var filters = {};
// isotope grid variable
var $grid;

// flatten object by concatting values
function concatValues( obj ) {
    var value = '';
    for ( var prop in obj ) {
        value += obj[ prop ];
    }
    return value;
}

function setupBinds() {
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

    // bind layout button click
    $('#layout-group').on( 'click', 'button', function() {
        var layoutValue = $(this).attr('data-layout');
        $grid.attr('data-layout', layoutValue);
        if (layoutValue == 'table') {
            $('#sources-grid').css('display', 'none');
            $('#sources-table').css('display', 'table');
            $('#sources-table_wrapper').css('display', 'block');
        } else {
            $('#sources-grid').css('display', 'block');
            $('#sources-table').css('display', 'none');
            $('#sources-table_wrapper').css('display', 'none');
            // layout Isotope after all images finish loading
            $grid.imagesLoaded( function() {
                // init Isotope after all images have loaded
                window.setTimeout(function () {
                    // do stuff after animation has finished here
                    $grid.isotope('layout');
                }, 100);
            });
        }
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
}


$(document).ready(function () {
    // init Isotope
    $grid = $('.grid').isotope({
        itemSelector: '.grid-item',
        layoutMode: 'masonry',
        sortBy: 'name',
        sortAscending: true,
        getSortData: {
            name: '[data-name]',
            type: '[data-type]',
            updated: '[data-updated] parseInt'
        }
    });

    // layout Isotope after all images finish loading
    $grid = $('.grid').imagesLoaded( function() {
        // init Isotope after all images have loaded
        $grid.isotope('layout');
        setupBinds();
    });
    $('#sources-table').DataTable({
        paging: false
    });
    if ($('#layout-group .active').attr('data-layout') == 'table') {
        $('#sources-grid').css('display', 'none');
        $('#sources-table').css('display', 'table');
        $('#sources-table_wrapper').css('display', 'block');
    } else {
        $('#sources-grid').css('display', 'block');
        $('#sources-table').css('display', 'none');
        $('#sources-table_wrapper').css('display', 'none');
    }
});
