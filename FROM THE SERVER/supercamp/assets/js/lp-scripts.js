(function ($) {
    'use strict';

    $(function() {

        $("#why-parents a").click(function(){

            console.log('Click');
            $(".sc-modal-state").prop("checked", true);
            $("body").addClass("sc-modal-open");

        });

        $("#supercamp-modal").on("change", function() {
            if ($(this).is(":checked")) {
                $("body").addClass("sc-modal-open");
            } else {
                $("body").removeClass("sc-modal-open");
            }
        });

        $(".sc-modal-fade-screen, .sc-modal-close").on("click", function() {
            // stop video player on modal close
            $(".sc-video-wrapper iframe").attr("src", $(".sc-video-wrapper iframe").attr("src"));
            $(".sc-modal-state:checked").prop("checked", false).change();
        });

        $(".sc-modal-inner").on("click", function(e) {
            e.stopPropagation();
        });

    });


    $(function() {

        $("#why-campers a").click(function(){

            console.log('Click');
            $(".sc-modal-state").prop("checked", true);
            $("body").addClass("sc-modal-open");

        });

        $("#supercamp-modal-campers").on("change", function() {
            if ($(this).is(":checked")) {
                $("body").addClass("sc-modal-open");
            } else {
                $("body").removeClass("sc-modal-open");
            }
        });

        $(".sc-modal-fade-screen, .sc-modal-close").on("click", function() {
            // stop video player on modal close
            $(".sc-video-wrapper iframe").attr("src", $(".sc-video-wrapper iframe").attr("src"));
            $(".sc-modal-state:checked").prop("checked", false).change();
        });

        $(".sc-modal-inner").on("click", function(e) {
            e.stopPropagation();
        });

    });

})(jQuery);