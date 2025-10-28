// === MAIN JAVASCRIPT FILE ===
// AcadTrack Admin – Handles dynamic features

document.addEventListener("DOMContentLoaded", () => {
    // Auto-load student list if page contains #studentData
    const studentTable = document.getElementById("studentData");
    if (studentTable) loadStudents();

    // Optional greeting
    const header = document.querySelector("header h1");
    if (header) {
        console.log(`Page loaded: ${header.textContent}`);
    }
});

// Load students dynamically from PHP (admin/students.php)
function loadStudents() {
    fetch("students.php")
        .then(response => response.text())
        .then(data => {
            document.getElementById("studentData").innerHTML = data;
        })
        .catch(error => {
            console.error("Error loading student data:", error);
            document.getElementById("studentData").innerHTML =
                "<tr><td colspan='6'>Failed to load data.</td></tr>";
        });
}

// Edit student record (future feature)
function editStudent(id) {
    alert(`Edit function triggered for Student ID: ${id}`);
    // Here you can add code to open a modal or redirect to edit form
}

// Delete student record (confirmation + backend request)
function deleteStudent(id) {
    if (confirm("Are you sure you want to delete this student?")) {
        fetch(`../backend/functions.php?action=deleteStudent&id=${id}`)
            .then(response => response.text())
            .then(result => {
                alert(result);
                loadStudents(); // refresh table
            })
            .catch(error => {
                console.error("Error deleting student:", error);
            });
    }
}

// ===== REPORTS SECTION =====
const reportForm = document.querySelector("form[action='reports.php']");
if (reportForm) {
    reportForm.addEventListener("submit", function (event) {
        event.preventDefault();

        const reportType = document.getElementById("reportType").value;
        fetch(`reports.php?type=${reportType}`)
            .then(response => response.text())
            .then(data => {
                document.getElementById("reportResult").innerHTML = data;
            })
            .catch(error => {
                console.error("Error loading report:", error);
                document.getElementById("reportResult").innerHTML =
                    "<p>Failed to load report data.</p>";
            });
    });
}

// ===== CALENDAR PREVIEW =====
const calendarDiv = document.getElementById("calendar");
if (calendarDiv) {
    renderCalendar();
}

function renderCalendar() {
    const today = new Date();
    calendarDiv.innerHTML = `
        <h3>${today.toLocaleString("default", { month: "long" })} ${today.getFullYear()}</h3>
        <p>📅 Events will appear here soon!</p>
    `;
}
