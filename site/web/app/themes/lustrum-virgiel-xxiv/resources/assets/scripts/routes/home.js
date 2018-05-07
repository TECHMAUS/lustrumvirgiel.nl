export default {
    init() {
        // JavaScript to be fired on the home page
    },
    finalize() {
        $(".background-image").css("backgroundImage", function(i, v){
            return v.replace("none", "url("+ $(this).data("bg") +")" );
        });
    },
};