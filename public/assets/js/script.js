document.addEventListener("DOMContentLoaded", function () {
  const timerElement = document.getElementById("timer")
  const timeToggleBtn = document.getElementById("time-toggle-btn")
  const timeToggleIcon = document.getElementById("time-toggle-icon")
  const timeLogTableBody = document.getElementById("time-log")
  const taskTypeSelect = document.getElementById("task-type")
  const taskInput = document.getElementById("task")
  const projectNameSelect = document.getElementById("project-name")
  const statusSelect = document.getElementById("status")
  const productSelect = document.getElementById("product")
  const modal = new bootstrap.Modal(document.getElementById("taskModal"))

  let startTime
  let timerInterval = null

  function updateTimer() {
    const now = new Date()
    const elapsed = new Date(now - startTime)
    const hours = String(elapsed.getUTCHours()).padStart(2, "0")
    const minutes = String(elapsed.getUTCMinutes()).padStart(2, "0")
    const seconds = String(elapsed.getUTCSeconds()).padStart(2, "0")
    timerElement.textContent = `${hours}:${minutes}:${seconds}`
  }

  function startTimer() {
    startTime = new Date()
    timerElement.textContent = "00:00:00"
    timerInterval = setInterval(updateTimer, 1000)

    timeToggleBtn.classList.remove("btn-primary")
    timeToggleBtn.classList.add("btn-danger")
    timeToggleIcon.classList.remove("fa-play")
    timeToggleIcon.classList.add("fa-stop")
    timeToggleBtn.textContent = " Stop"
  }

  function stopTimer() {
    clearInterval(timerInterval)
    timerInterval = null
    const endTime = new Date()
    const duration = ((endTime - startTime) / 1000 / 60).toFixed(2)
    const taskType = taskTypeSelect.value
    const task = taskInput.value
    const projectName = projectNameSelect.value
    const status = statusSelect.value
    const product = productSelect.value

    const csrfMetaTag = document.querySelector('meta[name="csrf-token"]')
    const csrfToken = csrfMetaTag ? csrfMetaTag.getAttribute("content") : ""

    $.ajax({
      url: "time-tracking/end", // Endpoint to save time log
      type: "POST",
      data: {
        start_time: startTime.toISOString(),
        end_time: endTime.toISOString(),
        duration: duration,
        task_type: taskType,
        task: task,
        project_name: projectName,
        status: status,
        product: product,
        csrf_token: csrfToken,
      },
      success: function (response) {
        console.log(response)
        if (response.status === "success") {
          const row = document.createElement("tr")
          row.innerHTML = `
              <td>${startTime.toLocaleDateString()}</td>
              <td>${startTime.toLocaleTimeString()}</td>
              <td>${endTime.toLocaleTimeString()}</td>
              <td>${duration} minutes</td>
              <td>${taskType}</td>
              <td>
                              <i class="fas fa-edit actions" data-id="${
                                response.log_id
                              }"></i>
                              <div class="dropdown-menu" id="dropdown-${
                                response.log_id
                              }">
                                  <a class="dropdown-item edit-time-log" href="#" data-id="${
                                    response.log_id
                                  }">Edit</a>
                                  <a class="dropdown-item delete-time-log" href="#" data-id="${
                                    response.log_id
                                  }">Delete</a>
                              </div>
                          </td>
            `
          timeLogTableBody.appendChild(row)
          $("#time-log-table").bootstrapTable("append", [
            {
              start_time: startTime.toLocaleDateString(),
              end_time: endTime.toLocaleTimeString(),
              duration: duration,
              task_type: taskType,
            },
          ])
        } else {
          alert("Error saving time log")
        }
      },
      error: function (xhr, status, error) {
        console.error("Error:", status, error)
        alert("Error saving time log")
      },
    })

    timeToggleBtn.classList.remove("btn-danger")
    timeToggleBtn.classList.add("btn-primary")
    timeToggleIcon.classList.remove("fa-stop")
    timeToggleIcon.classList.add("fa-play")
    timeToggleBtn.textContent = " Start"
  }

  timeToggleBtn.addEventListener("click", function () {
    if (timerInterval === null) {
      modal.show()
    } else {
      stopTimer()
    }
  })

  document
    .getElementById("continue-btn")
    .addEventListener("click", function () {
      modal.hide()
      startTimer()
    })

  const el = document.getElementById("wrapper")
  const toggleButton = document.getElementById("menu-toggle")

  if (toggleButton) {
    toggleButton.onclick = function () {
      el.classList.toggle("toggled")
    }
  }

  $("#time-log-table").bootstrapTable()

  // Edit and Delete functionality
  // $(document).on("click", ".edit-time-log", function (e) {
  //   e.preventDefault()
  //   const logId = $(this).data("id")
  //   // Fetch data for the selected log and populate the modal
  //   $.ajax({
  //     url: `time-tracking/get/${logId}`,
  //     type: "GET",
  //     success: function (response) {
  //       $("#edit-log-id").val(response.id)
  //       $("#edit-start-time").val(
  //         new Date(response.start_time).toISOString().slice(0, 16)
  //       )
  //       $("#edit-end-time").val(
  //         new Date(response.end_time).toISOString().slice(0, 16)
  //       )
  //       $("#edit-task-type").val(response.task_type)
  //       $("#editModal").modal("show")
  //     },
  //     error: function (xhr, status, error) {
  //       console.error("Error fetching time log:", status, error)
  //       alert("Error fetching time log")
  //     },
  //   })
  // })

  // $("#saveEditBtn").on("click", function () {
  //   const logId = $("#edit-log-id").val()
  //   const startTime = $("#edit-start-time").val()
  //   const endTime = $("#edit-end-time").val()
  //   const taskType = $("#edit-task-type").val()

  //   $.ajax({
  //     url: `time-tracking/update/${logId}`,
  //     type: "POST",
  //     data: {
  //       start_time: startTime,
  //       end_time: endTime,
  //       task_type: taskType,
  //       csrf_token: $('meta[name="csrf-token"]').attr("content"),
  //     },
  //     success: function (response) {
  //       if (response.status === "success") {
  //         $("#editModal").modal("hide")
  //         location.reload()
  //       } else {
  //         alert("Error updating time log")
  //       }
  //     },
  //     error: function (xhr, status, error) {
  //       console.error("Error updating time log:", status, error)
  //       alert("Error updating time log")
  //     },
  //   })
  // })

  $(document).on("click", ".delete-time-log", function (e) {
    e.preventDefault()
    if (!confirm("Are you sure you want to delete this time log?")) return

    const logId = $(this).data("id")

    $.ajax({
      url: `http://localhost:8080/time-tracking/delete/${logId}`,
      type: "POST",
      data: {
        csrf_token: $('meta[name="csrf-token"]').attr("content"),
      },
      success: function (response) {
        // Handle success response
      },
      error: function (xhr, status, error) {
        console.error("Error deleting time log:", status, error)
        alert("Error deleting time log")
      },
    })
  })

  $(document).ready(function () {
    $("#applyColumnsBtn").click(function () {
      // Iterate through each checkbox in the modal
      $('#columnSettingsForm input[type="checkbox"]').each(function () {
        var columnClass =
          ".col-" + $(this).attr("id").replace("checkbox", "").toLowerCase()

        if ($(this).is(":checked")) {
          $(columnClass).show()
        } else {
          $(columnClass).hide()
        }
      })

      // Close the modal
      $("#columnSettingsModal").modal("hide")
    })
  })
})
