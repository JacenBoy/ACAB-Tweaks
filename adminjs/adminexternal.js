const url = new RegExp("^(?:https?:\/\/)?(?:www\.)?" + location.hostname.replace(/[-\/\\^$*+?.()|[\]{}]/g, "\\$&"), "i");
Array.from(document.getElementsByTagName("a")).forEach(a => {
  if (a.href.search(url) == -1) {
    a.setAttribute("target", "_blank");
  }
});