const $tabs = document.querySelectorAll('.tabs a');
const $panels = document.querySelectorAll('.panel');

if ($tabs.length && $panels.length) {

  $panels[0].classList.add('-visible');
  $tabs[0].classList.add('-active');

  function switchTab(tab) {
    const $target = document.querySelector('#' + tab.dataset.target);
    const $active = document.querySelector('.tab a.-active');
    const $visible = document.querySelector('.panel.-visible');

    $visible.classList.remove('-visible');
    $target.classList.add('-visible');
    $active.classList.remove('-active');
    tab.classList.add('-active');
  }

  $tabs.forEach($tab => {
    $tab.addEventListener('mouseenter', (e) => {
      e.preventDefault();
      if (!$tab.classList.contains('-active')) {
        switchTab($tab);
      }
    });
  });
}