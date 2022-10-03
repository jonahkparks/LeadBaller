import 'code-prettify';

window.addEventListener("load", function() {

	PR.prettyPrint();
	
	// store tabs variables
	var tabs = document.querySelectorAll("ul.nav-tabs > li");

	for (var i = 0; i < tabs.length; i++) {
		tabs[i].addEventListener("click", switchTab);
	}

	function switchTab(event) {
		event.preventDefault();

		document.querySelector("ul.nav-tabs li.active").classList.remove("active");
		document.querySelector(".tab-pane.active").classList.remove("active");

		var clickedTab = event.currentTarget;
		var anchor = event.target;
		var activePaneID = anchor.getAttribute("href");

		clickedTab.classList.add("active");
		document.querySelector(activePaneID).classList.add("active");

	}

});

jQuery(document).ready(function ($) {

	$(document).on('click', '.js-image-upload', function (e) {

		e.preventDefault();

		var $button = $(this);

		var file_frame = wp.media.frames.file_frame = wp.media({
			title: 'Select or Upload an Image',
			library: {
				type: 'image'
			},
			button: {
				text: 'Select Image'
			},
			multiple: false
		});

		file_frame.on('select', function() {
			var attachment = file_frame.state().get('selection').first().toJSON();
			$button.siblings('.image-upload').val(attachment.url);
		});

		file_frame.open();
	});
});

// var campaignsTest = 'br4n2s75h'; // Testing App - Campaigns table
// var campaignsProd = 'brx55z77r'; // Production App - Campaigns table

// function authenticateQuickBase(qbTable, prodInstance) {
//     var internalTable = '';

//     if (qbTable = 'campaigns') {
//         internalTable = (prodInstance = "yes" ? campaignsProd : campaignsTest );
//     }
//     var headers = {
//         'QB-Realm-Hostname': 'leadballer.quickbase.com',
//         'Content-Type': 'application/json'
//     };

//     var authToken = '';

//     $.ajax({
//         url: 'https://api.quickbase.com/v1/auth/temporary/' + internalTable,
//            method: 'GET',
//            async: false,
//         headers: headers,
//         xhrFields: { withCredentials: true },
//         success: function(result) {
//             authToken = result.temporaryAuthorization;
//         }
//     })

// }
