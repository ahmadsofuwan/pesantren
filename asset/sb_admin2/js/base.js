function recountNumber(obj) {
    $.each(obj, function (index, elemt) {
        $(elemt).html(index + 1)
    });

}