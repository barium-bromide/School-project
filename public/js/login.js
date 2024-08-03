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

// function getData() {
//   $.ajax({
//     url: 'getDataClass.php',
//     type: 'POST',
//     success: function (data) {
//       if (data != 'false') {
//         var obj = JSON.parse(data);
//         var name = obj.name;
//         var classs = obj.class;
//         var nameList = "";
//         var classList = "";
//         for (var i = 0; i < name.length; i++) {
//           nameList += "<li>" + name[i] + "</li>";
//         }
//         for (var i = 0; i < classs.length; i++) {
//           classList += "<li>" + classs[i] + "</li>";
//         }
//         document.getElementById("student-form").innerHTML = "<h2>Name</h2><div class='dropdown'><div class='select'><span class='selected' id='name'>" + name[0] + "</span><div class='caret'></div></div><ul class='menu'>" + nameList + "</ul></div><h2>Class</h2><div class='dropdown'><div class='select'><span class='selected' name='class' id='class'>" + classs[0] + "</span><div class='caret'></div></div><ul class='menu'>" + classList + "</ul></div>";
//       } else {
//         document.getElementById("class-dropdown").innerHTML = `<div class='select'>
//                   <span class='selected' name='class' id='class'>none</span>
//                   <div class="caret"></div>
//               </div>
//               <ul class="menu"><li class="active">none</li></ul>`
//       }
//     }
//   });
// }

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
  $.post("login_validator.php",
    {
      student_id: ID_MURID.value,
      student_class: KELAS.innerText,
      role: JAWATAN.innerText == "Murid" ? "Student" : "Teacher",
      teacher_id: USERNAME.value,
      password: PASSWORD.value
    },
    function (data, status) {
      if (status === "success") {
        if (data.success) {
          alert("Berjaya masuk");
          window.location.href = "pickbox.php";
        } else {
          alert(data.message);
        }
      } else {
        alert("Request failed with status: " + status);
        window.location.href = "login.php";
      }
    },
    "json"
  );
}
