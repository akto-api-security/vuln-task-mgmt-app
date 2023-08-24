<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-8">

<div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-4">To-Do List</h1>

    <ul id="taskList" class="mb-4">
        <!-- Tasks will be populated here via JavaScript -->
    </ul>

    <div class="flex items-center">
        <input type="text" id="newTask" placeholder="New task..." class="flex-grow mr-4 p-2 border rounded-lg">
        <button id="addTaskBtn" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Add</button>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        fetch('/api/REST/tasks')
            .then(response => response.json())
            .then(data => {
                const taskList = document.getElementById('taskList');
                data.forEach(task => {
                    const li = document.createElement('li');
                    li.className = 'flex justify-between items-center mb-2';
                    li.innerHTML = `
                        <input type="checkbox" data-id="${task.id}" class="mr-4" ${task.done ? 'checked' : ''}>
                        <input type="text" value="${task.name}" data-id="${task.id}" class="flex-grow mr-4 p-2 border rounded-lg ${task.done ? 'line-through' : ''}">
                        <button data-id="${task.id}" class="bg-red-500 text-white px-2 py-1 ml-2 rounded-lg">Delete</button>
                    `;
                    taskList.appendChild(li);
                });
            });

        document.getElementById('addTaskBtn').addEventListener('click', function () {
            const newTaskInput = document.getElementById('newTask');
            const newTaskValue = newTaskInput.value.trim();

            if (newTaskValue) {
                fetch('/api/REST/tasks', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        name: newTaskValue
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    const taskList = document.getElementById('taskList');
                    const li = document.createElement('li');
                    li.className = 'flex justify-between items-center mb-2';
                    li.innerHTML = `
                        <input type="checkbox" data-id="${data.id}" class="mr-4">
                        <input type="text" value="${data.name}" data-id="${data.id}" class="flex-grow mr-4 p-2 border rounded-lg">
                        <button data-id="${data.id}" class="bg-red-500 text-white px-2 py-1 ml-2 rounded-lg">Delete</button>
                    `;
                    taskList.appendChild(li);
                    newTaskInput.value = '';
                });
            }
        });

        document.getElementById('taskList').addEventListener('click', function (e) {
            const taskId = e.target.getAttribute('data-id');
            if (e.target.tagName === 'INPUT' && e.target.type === 'checkbox') {
                const isChecked = e.target.checked;
                const input = document.querySelector(`input[type="text"][data-id="${taskId}"]`);
                if (isChecked) {
                    input.classList.add('line-through');
                } else {
                    input.classList.remove('line-through');
                }

                fetch(`/api/REST/tasks/${taskId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        done: isChecked
                    }),
                });
            } else if (e.target.tagName === 'BUTTON' && e.target.textContent === 'Delete') {
                fetch(`/api/REST/tasks/${taskId}`, {
                    method: 'DELETE',
                })
                .then(() => {
                    e.target.parentElement.remove();
                });
            }
        });

        document.getElementById('taskList').addEventListener('blur', function (e) {
            if (e.target.tagName === 'INPUT' && e.target.type === 'text') {
                const taskId = e.target.getAttribute('data-id');
                const newValue = e.target.value.trim();

                fetch(`/api/REST/tasks/${taskId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        name: newValue
                    }),
                });
            }
        }, true);
    });
</script>

</body>
</html>
