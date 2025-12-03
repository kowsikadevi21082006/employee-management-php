window.app = (function(){
  function toggleMenu(){
    var el = document.getElementById('navLinks');
    if(!el) return;
    el.style.display = (el.style.display === 'flex') ? 'none' : 'flex';
  }

  function confirmDelete(selector){
    document.addEventListener('click', function(e){
      var t = e.target.closest(selector);
      if(!t) return;
      e.preventDefault();
      var href = t.getAttribute('href');
      if(confirm('Are you sure you want to delete this item?')){
        window.location = href;
      }
    });
  }

  // optional fade-in on scroll (basic)
  function fadeInOnScroll(){
    var items = document.querySelectorAll('.fade-in');
    if('IntersectionObserver' in window){
      var io = new IntersectionObserver(function(entries){
        entries.forEach(function(ent){
          if(ent.isIntersecting) ent.target.classList.add('visible');
        });
      },{threshold:0.15});
      items.forEach(function(it){ io.observe(it); });
    } else {
      items.forEach(function(it){ it.classList.add('visible'); });
    }
  }

  // Init
  document.addEventListener('DOMContentLoaded', function(){
    fadeInOnScroll();
    confirmDelete('.btn-danger');
  });

  return { toggleMenu: toggleMenu, confirmDelete: confirmDelete };
})();
