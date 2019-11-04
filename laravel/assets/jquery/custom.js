/**
 * Created by khushp on 9/20/2018.
 */
var setDefaultActive = function() {
    var path = window.location;

    var element = $("a[href='" + path + "']");

    element.parent().addClass("active");
    element.parent().parent().css('display','block').addClass("active");
    element.parent().parent().parent().css('display','block').addClass("active");
    element.parent().parent().parent().parent().parent().css('display','block').addClass("active");
    //element.parent(2).css('display','block');
}
setDefaultActive();