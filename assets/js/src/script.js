(function ($, root, undefined) {

	$(function () {

		'use strict';

		$(window).load(function() {

			$("body").addClass("show");

			$(document).on("click", ".menu-toggle button", function(){
				$(".list").toggleClass("show");
			});

			setTimeout(function(){
				$(".title").addClass("show").delay(220);
				$(".menu-toggle").addClass("show").delay(220);
				$(".next").addClass("show").delay(220);
				$(".previous").addClass("show").delay(220);
			}, 440);

		});

	});

})(jQuery, this);
