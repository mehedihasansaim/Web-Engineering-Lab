const container = document.getElementById('container');


  for (let i = 1; i <= 10; i++) {
    const box = document.createElement('div');
    box.classList.add('box');
    box.textContent = i;


    if (i % 2 === 0) {
      box.style.backgroundColor = 'aqua';
    } else {
      box.style.backgroundColor = 'orange';
    }


    container.appendChild(box);
  }  
