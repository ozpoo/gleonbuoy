(function ($, root, undefined) {

	$(function () {

		'use strict';

		$(window).load(function() {

			$("body").addClass("show");

			$(document).on("click", ".menu-toggle button", function(){
				$(".list").toggleClass("show");
			});

		});

	});

})(jQuery, this);
