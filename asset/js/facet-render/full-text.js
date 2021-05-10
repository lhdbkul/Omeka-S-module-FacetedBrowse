FacetedBrowse.registerFacetApplyStateHandler('full_text', function(facet, facetState) {
    const thisFacet = $(facet);
    thisFacet.find(`input.full-text`).val(facetState);
});

$(document).ready(function() {

const container = $('#container');
let timerId;

container.on('keyup', '.full-text', function(e) {
    const thisFullText = $(this);
    const facet = thisFullText.closest('.facet');
    clearTimeout(timerId);
    timerId = setTimeout(function() {
        FacetedBrowse.setFacetState(facet.data('facetId'), thisFullText.val(), `fulltext_search=${encodeURIComponent(thisFullText.val())}`);
        FacetedBrowse.triggerFacetStateChange();
    }, 350);
});

});
