$(function() {
    $(".toggle").on("click", function() {
        if($(".item").hasClass("active") && $(".item-button").hasClass("active")) {
            $(".item").removeClass("active");
            $(".item-button").removeClass("active");
            $(this).find("a").html("<i class='fas fa-bars'></i>");
        } else {
            $(".item").addClass("active");
            $(".item-button").addClass("active");
            $(this).find("a").html("<i class='fas fa-times'></i>");
        }
    });

    $(".item.out").on("click", function() {
        if($(".item-drop").hasClass("active")) {
            $(".item-drop").removeClass("active");
        } else {
            $(".item-drop").addClass("active");

        }
    });
    
});