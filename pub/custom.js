function toggleFolder(el) {
  var content = el.nextElementSibling;
  if (content.style.display === "none") {
    content.style.display = "block";
  } else {
    content.style.display = "none";
  }
}