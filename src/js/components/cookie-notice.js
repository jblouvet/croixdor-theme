import { slideUp } from '../helpers/slideToggle.js';

const setCookie = function (name, days) {
  var d = new Date();
  d.setTime(d.getTime() + 1000 * 60 * 60 * 24 * days);
  document.cookie = name + "=true;secure;path=/;samesite=lax;expires=" + d.toGMTString() + ';';
};

const checkForCookie = function (name) {
  if (document.cookie.indexOf(name) === -1) {
    return false;
  } else {
    return true;
  }
};

const handleCookieNotificationClick = (event) => {

  setCookie('hideCookieNotification', 365);

  slideUp(document.querySelector('.module-notification.-cookie'));
}

if (!checkForCookie('hideCookieNotification')) {

  document.querySelector('.module-notification.-cookie').style.display = 'block';
}

document.addEventListener('click', handleCookieNotificationClick, false);

document.addEventListener('touchstart', handleCookieNotificationClick, false);