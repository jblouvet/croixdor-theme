const $scrolltolink = document.querySelectorAll('.js-scrollto');

if ($scrolltolink.length && $scrolltolink !== null) {
  $scrolltolink.forEach(($link) => {
    $link.addEventListener('click', (e) => {
      let target = $link.getAttribute('href');
      let $target = document.getElementById(target.substring(1));
      if ($target) {
        $target.scrollIntoView({
          behavior: 'smooth',
          block: 'start'
        });
      };
      e.preventDefault();
    });
  });
}