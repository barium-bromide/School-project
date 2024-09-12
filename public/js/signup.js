const dropdowns = document.querySelectorAll(".dropdown");
const ID_MURID = document.getElementById("name");
const KELAS = document.getElementById("class");
const JAWATAN = document.getElementById("role");
const USERNAME = document.getElementById("username");
const PASSWORD = document.getElementById("password");
const loginForm = document.getElementById("login-form");
const loginButton = document.getElementById("loginbtn");
const teacherForm = document.getElementById("teacher-form");
const studentForm = document.getElementById("student-form");
const KP_murid = document.getElementById("KP_murid");
const KP_guru = document.getElementById("KP_guru");

dropdowns.forEach((dropdown) => {
    const select = dropdown.querySelector(".select");
    const caret = dropdown.querySelector(".caret");
    const menu = dropdown.querySelector(".menu");
    const options = dropdown.querySelectorAll(".menu li");
    const selected = dropdown.querySelector(".selected");
    select.onclick = () => {
        select.classList.toggle("select-clicked");
        caret.classList.toggle("caret-rotate");
        menu.classList.toggle("menu-open");
    };

    options.forEach((option) => {
        option.onclick = () => {
            selected.innerText = option.innerText;
            select.classList.remove("select-clicked");
            caret.classList.remove("caret-rotate");
            menu.classList.remove("menu-open");
            options.forEach((option) => {
                option.classList.remove("active");
            });
            option.classList.add("active");
            if (option.innerText == "Murid") {
                studentForm.classList.remove("hide")
                teacherForm.classList.add("hide")
            } else if (option.innerText == "Guru") {
                studentForm.classList.add("hide")
                teacherForm.classList.remove("hide")
            }
        };
    });
});
loginButton.onclick = () => {
    $.post("signup_validator.php",
        {
            KP: JAWATAN.innerText == "Murid" ? KP_murid.value : KP_guru.value,
            student_name: ID_MURID.value,
            student_class: KELAS.innerText,
            role: JAWATAN.innerText == "Murid" ? "Student" : "Teacher",
            teacher_name: USERNAME.value,
            password: PASSWORD.value
        },
        function (data, status) {
            if (status === "success") {
                if (data.success) {
                    window.location.href = "pickbox.php";
                } else {
                    // maybe can use html to display
                    alert(data.message);
                }
            } else {
                alert("Request failed with status: " + status);
                window.location.href = "signup.php";
            }
        },
        "json"
    );
}