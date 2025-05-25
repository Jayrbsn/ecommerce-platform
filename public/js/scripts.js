window.addEventListener('DOMContentLoaded', function () {
  const urlParams = new URLSearchParams(window.location.search);
  if (urlParams.get('added') === '1') {
    const msg = document.createElement('div');
    msg.textContent = "Item added to cart!";
    msg.className = "alert alert-success";
    msg.style.position = "fixed";
    msg.style.top = "20px";
    msg.style.right = "20px";
    msg.style.zIndex = "1000";
    msg.style.padding = "10px 20px";
    msg.style.borderRadius = "5px";
    msg.style.boxShadow = "0 2px 8px rgba(0,0,0,0.2)";
    document.body.appendChild(msg);

    setTimeout(() => {
      msg.remove();
      urlParams.delete('added');
      history.replaceState(null, "", window.location.pathname);
    }, 3000);
  }
});
