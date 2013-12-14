// redirect to home if not loaded in frame.
// execute asap, not when dom loaded
if (window.self != window.top) {
  window.top.location.href = "/";
}