document.addEventListener('DOMContentLoaded', function() {
  const taskForm = document.getElementById('task-form');
  taskForm.addEventListener('submit', addTask);

  function addTask(event) {
    event.preventDefault();

    const taskInput = document.getElementById('task-input');
    const taskText = taskInput.value.trim();
    if (taskText === '') {
      alert('Please enter a task');
      return;
    }

    const timeInput = document.getElementById('time-input');
    const timeValue = timeInput.value ? timeInput.value : '';

    const listItem = document.createElement('li');
    listItem.textContent = taskText;

    const taskList = document.getElementById('task-list');
    taskList.appendChild(listItem);

    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'save_task.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    xhr.onreadystatechange = function() {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          console.log(xhr.responseText); // Optional: Log the response from the PHP script
        } else {
          console.log('Error:', xhr.status);
        }
      }
    };

    const params = 'task=' + encodeURIComponent(taskText) + '&time_planned=' + encodeURIComponent(timeValue);
    xhr.send(params);

    taskInput.value = '';
    timeInput.value = '';
  }

  // Play beep sound when mouse is moved over the task
  const taskList = document.getElementById('task-list');
  taskList.addEventListener('mouseover', function(event) {
    const listItem = event.target;
    if (listItem.nodeName === 'LI') {
      playBeep();
    }
  });
});

function playBeep() {
  const beep = new Audio('beep.mp3');
  beep.play();
}
