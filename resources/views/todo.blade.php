<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>AJAX To-Do List</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <!-- <h2>To-Do List</h2>
    <input type="text" id="taskInput" placeholder="Enter task...">
    <button onclick="addTask()">Add Task</button>
    <button onclick="fetchTasks()">Show All Tasks</button> -->


    <section class="vh-100">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col">
        <div class="card" id="list1" style="border-radius: .75rem; background-color: #eff1f2;">
          <div class="card-body py-4 px-4 px-md-5">

            <p class="h1 text-center mt-3 mb-4 pb-3 text-primary">
              <i class="fas fa-check-square me-1"></i>
              <u>My Todo-App</u>
            </p>

            <div class="pb-2">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex flex-row align-items-center">
                    <input type="text" id="taskInput" class="form-control form-control-lg" 
                      placeholder="Add new...">
                    <a href="#!" data-mdb-tooltip-init title="Set due date"><i
                        class="fas fa-calendar-alt fa-lg me-3"></i></a>
                    <div style="display:flex;align-items:center;justify-content:center;">
                      <button  onclick="addTask()" class="btn btn-primary" style="margin-right:2rem;">Add Task</button>
                 
                      <button  onclick="fetchTasks()" class="btn btn-warning">Show Task</button>
                    </div>
                  </div>
                </div>
                <ul id="taskList"></ul>
              </div>
             
            </div>

         
           
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
    <script>
        function fetchTasks() {
            $.get("/tasks", function(tasks) {
                $("#taskList").empty();
                tasks.forEach(task => {
                    let checked = task.completed ? "checked" : "";
                    let taskItem = `


            <ul class="list-group list-group-horizontal rounded-0">
              <li
                class="list-group-item d-flex align-items-center ps-0 pe-3 py-1 rounded-0 border-0 bg-transparent">
                <div class="form-check">
                  <input class="form-check-input me-0" type="checkbox" ${checked} onclick="toggleTask(${task.id})
                    aria-label="..." />
                </div>
              </li>
              <li
                class="list-group-item px-3 py-1 d-flex align-items-center flex-grow-1 border-0 bg-transparent">
                <p class="lead fw-normal mb-0">${task.name}</p>
              </li>
               <li
                class="list-group-item px-3 py-1 d-flex align-items-center border-0 bg-transparent">
                <button class="btn btn-danger" onclick="deleteTask(${task.id})">Delete</button>
              </li>
                            
             
                    `;
                    $("#taskList").append(taskItem);
                });
            });
        }

        function addTask() {
            let taskName = $("#taskInput").val();
            if (!taskName) {
                alert("Task cannot be empty!");
                return;
            }
            
            $.post("/tasks", {name: taskName, _token: "{{ csrf_token() }}"})
                .done(function(task) {
                    $("#taskInput").val("");
                    fetchTasks();
                })
                .fail(function(response) {
                    alert(response.responseJSON.message);
                });
        }

        function toggleTask(id) {
            $.ajax({
                url: `/tasks/${id}`,
                type: 'PUT',
                data: {_token: "{{ csrf_token() }}"},
                success: function() {
                    fetchTasks();
                }
            });
        }

        function deleteTask(id) {
            if (!confirm("Are you sure to delete this task?")) return;

            $.ajax({
                url: `/tasks/${id}`,
                type: 'DELETE',
                data: {_token: "{{ csrf_token() }}"},
                success: function() {
                    fetchTasks();
                }
            });
        }

        $(document).ready(function() {
            fetchTasks();
        });
    </script>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
