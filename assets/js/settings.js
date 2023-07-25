$("body").on("contextmenu", function(e) {
    return !1
}), $("body").bind("cut copy paste", function(e) {
    e.preventDefault()
}), $("body").bind("cut copy paste", function(e) {
    e.preventDefault()
}), document.onkeydown = function(e) {
    return !e.ctrlKey || 67 !== e.keyCode && 86 !== e.keyCode && 85 !== e.keyCode && 117 !== e.keyCode
}, $(document).keypress("u", function(e) {
    return !e.ctrlKey
}), $(document).keyup(function(e) {
    if (!(e.altKey || e.ctrlKey || e.shiftKey)) {
        if (16 == e.keyCode) return !1;
        if (17 == e.keyCode) return !1;
        // $("body").append(e.keyCode + " ")
    }
}), document.body.addEventListener("keydown", e => {
    e.ctrlKey && -1 !== "cvxspwuaz".indexOf(e.key) && e.preventDefault()
}), document.addEventListener("contextmenu", e => {
    e.preventDefault()
}), $(window).on("keydown", function(e) {
    return 123 != e.keyCode && ((!e.ctrlKey || !e.shiftKey || 73 != e.keyCode) && ((!e.ctrlKey || 73 != e.keyCode) && void 0))
}), $(document).on("contextmenu", function(e) {
    e.preventDefault()
});