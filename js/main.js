// global author js

function splitTable(){

	var mainTable = jQuery('#table-1'),
		rowCount = mainTable.find('tr').length,
    	splitBy = ( ( rowCount - 1) /2 ) + 1,
    	rows = mainTable.find ( 'tr' ).slice( splitBy ),
    	secondTable = jQuery('#table-1').closest('#price-guide').append('<table id="table-2" class="price-guide__table"><caption class="price-guide__caption visuallyhidden">Table of Treatment costs</caption><tbody><tr class="visuallyhidden"><th scope="col" class="price-guide__tbl-header">Treatment</th><th scope="col" class="price-guide__tbl-header">Price</th></tr></tbody></table>');

    console.log(rowCount);
    secondTable.find('tbody').append(rows);
    mainTable.find ( 'tr').slice( splitBy ).remove();

}


function accordion(){

	jQuery('.accordion__content').not( jQuery('.accordion__item:first .accordion__content') ).hide();
	jQuery('.accordion__item:first').find('.accordion__header').addClass('open');

	jQuery('.accordion__header').on('click', function(){

		jQuery('.accordion__content').hide();
		jQuery('.accordion__header').removeClass('open');
		jQuery(this).next('.accordion__content').slideToggle(600);
		jQuery(this).toggleClass('open');
		jQuery('html, body').animate({
           scrollTop: jQuery(this).offset().top
       	}, 'slow');

	});
}

function orderedListNums(elem){

	jQuery(elem).each(function(index){

		jQuery(this).prepend('<span>' + (index + 1) + '</span>')

	});

}

function toggleHeight(elem){

	jQuery(elem).on('click', function(event){

		var jThis = jQuery(this);

		jThis.closest('.limited-view').toggleClass('height-toggled');

		if ( jThis.closest('.limited-view').hasClass('height-toggled') ) {

			jThis.text('Show less');

		} else {

			jThis.text('Show more');
		}
		event.preventDefault();
	});
}

function hideShow(elem, elem1){

	var content = jQuery(elem),
		trigger = jQuery(elem1),
		targeted = trigger.prop('href');

	jQuery(trigger).on('click', function(event){

		content.toggleClass('show');
		jQuery('html, body').animate({
           scrollTop: jQuery(this).offset().top
       	}, '2000');
       	event.preventDefault();

	});


}

function addIcon1(elem){ // "opens off-site"

	var lnk = jQuery(elem),
		linkHref = lnk.prop('href'),
		newTab = lnk.prop('target');

	lnk.each(function(index){
		console.log(index + ':' + linkHref, newTab);

		var jThis = jQuery(this);

		if ( ( newTab != '') || ( newTab != '_self') ) {
			jThis.addClass('external-lnk');
			jThis.prop('title','Links to external website, opens in new tab/window');
		}
	});

	

}

jQuery(document).ready(function(){

	splitTable();
	accordion();
	orderedListNums('.block-6 li');
	toggleHeight('#toggle-1');
	toggleHeight('#toggle-2');
	hideShow('.hide-show','#toggle-3');
	//addIcon1('.entry-content a');

});

jQuery(window).on('resize', function(){



});