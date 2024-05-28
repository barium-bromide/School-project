const dropdowns = document.querySelectorAll(".dropdown");
const NAMA = document.getElementById("name");
const KELAS = document.getElementById("class");
const JAWATAN = document.getElementById("role");
const USERNAME = document.getElementById("username");
const PASSWORD = document.getElementById("password");
const loginForm = document.getElementById("login-form");
const loginButton = document.getElementById("loginbtn");
const teacherForm = document.getElementById("teacher-form");
const studentForm = document.getElementById("student-form");
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
      if (option.innerText == "Student") {
        studentForm.classList.remove("hide")
        teacherForm.classList.add("hide")
      } else if (option.innerText == "Teacher") {
        studentForm.classList.add("hide")
        teacherForm.classList.remove("hide")
      }
    };
  });
});
loginButton.onclick = () => {
  $.post("login_validator.php",
    {
      student_name: NAMA.innerText,
      student_class: KELAS.innerText,
      role: JAWATAN.innerText,
      username: USERNAME.value,
      password: PASSWORD.value
    },
    function (data, status) {
      if (role.innerText == "Teacher") {
        if (USERNAME.value == "" || PASSWORD.value == "") {
          alert("Please fill in all the fields");
          return;
        }
      } else if (role.innerText == "Student") {
        if (NAMA.innerText == "" || KELAS.innerText == "") {
          alert("Please fill in all the fields");
          return;
        }
      } else {
        alert("Please fill in all the fields");
        return;
      }
      window.location.href = "login_validator.php";
    }
  );
}

