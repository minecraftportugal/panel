// redirect to self if loaded in frame.
// execute asap, not when dom loaded
if (window.self != window.top) {
  window.top.location.href = window.self.location.href;
}