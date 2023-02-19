'use strict';

{
  const message = document.querySelector(".message");
  if (message.innerHTML === "ログインに成功しました") {
    window.location.href = '../../admin/index.php';
    console.log('login succeeded');
    message.style.display = "none";
  } else {
    console.log('login failed');
    message.classList.toggle('login_failed');
  }
}