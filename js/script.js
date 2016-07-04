$(".nav button").on("click", function() {
  // Remove CSS of previously pressed button
  $(".nav #selected").removeAttr("id");
  // Change CSS of current button
  $(this).attr("id", "selected");
  // Get tag(class) of current button
  $class = $(this).attr("class");
  // Traverse DOM for current tag(class)
    // Show courses with matching tag(class)
    $(".course").not("." + $class).hide();
    // Hide courses that don't match the tag(class)
    $("." + $class).show();
});