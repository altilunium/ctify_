function toggleFolder(el) {
  var content = el.nextElementSibling;
  if (content.style.display === "none") {
    content.style.display = "block";
  } else {
    content.style.display = "none";
  }
}

function sanitize(html) {
  const temp = document.createElement("div");
  temp.innerHTML = html;

  temp.querySelectorAll("*").forEach(el => {
    if (!["A","B","I","EM","STRONG","BR"].includes(el.tagName)) {
      el.replaceWith(...el.childNodes);
    }
    if (el.tagName === "A") {
      el.setAttribute("target", "_blank");
      el.setAttribute("rel", "nofollow noopener");
    }
  });

  return temp.innerHTML;
}

document.addEventListener("DOMContentLoaded", function() {
  let tooltip = null;
  let pinned = false;
  let activeRef = null;

  function createTooltip(ref) {
    removeTooltip();

    tooltip = document.createElement("div");
    tooltip.className = "pm-ref-tooltip";
    tooltip.innerHTML = sanitize(ref.getAttribute("data-ref"));

    document.body.appendChild(tooltip);

    const rect = ref.getBoundingClientRect();
    tooltip.style.left = rect.left + rect.width / 2 + "px";
    tooltip.style.top = rect.top - 8 + "px";
    tooltip.style.transform = "translate(-50%, -100%)";
  }

  function removeTooltip() {
    if (tooltip) {
      tooltip.remove();
      tooltip = null;
    }
    pinned = false;
    activeRef = null;
  }

  document.querySelectorAll(".pm-ref").forEach(ref => {
    ref.addEventListener("mouseenter", function() {
      if (!pinned) {
        createTooltip(ref);
      }
    });

    ref.addEventListener("mouseleave", function() {
      if (!pinned) {
        removeTooltip();
      }
    });

    ref.addEventListener("click", function(e) {
      e.stopPropagation();

      if (pinned && activeRef === ref) {
        // clicking the same ref closes it
        removeTooltip();
      } else {
        createTooltip(ref);
        pinned = true;
        activeRef = ref;
      }
    });
  });

  // click anywhere else → close
  document.addEventListener("click", function() {
    if (pinned) {
      removeTooltip();
    }
  });
});
