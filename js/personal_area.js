(() => {
  let inputImgAvatar = document.querySelector("#account_input-img");
  let dropboxGender = document.querySelector(".account_input-gender-wrapper");

  if (inputImgAvatar) {
    //смена аватарки в профиле
    inputImgAvatar.addEventListener("change", function () {
      if (inputImgAvatar.files[0]) {
        let fr = new FileReader();

        fr.addEventListener(
          "load",
          function () {
            document.querySelector(".account_image-wrap img").src = fr.result;
          },
          false
        );

        fr.readAsDataURL(inputImgAvatar.files[0]);
      }
    });
    //выбор пола
    dropboxGender.addEventListener("click", function () {
      let inputGender = document.querySelector(".account_input-gender");
      let listGender = document.querySelectorAll(".account_gender-list span");

      document
        .querySelector(".account_gender-select svg")
        .classList.toggle("dropdown");
      if (
        document
          .querySelector(".account_gender-select svg")
          .classList.contains("dropdown")
      ) {
        document.querySelector(".account_gender-list").style.display = "flex";
      } else {
        document.querySelector(".account_gender-list").style.display = "none";
      }

      listGender.forEach((item) => {
        item.addEventListener("click", function () {
          inputGender.value = item.innerText;
          document
            .querySelector(".account_gender-select svg")
            .classList.remove("dropdown");
          document.querySelector(".account_gender-list").style.display = "none";
        });
      });
    });
    //ввод номера телефона
    let inputPhone = document.querySelector("#account_personal-tel");
    let keyCode;
    function Mask(event) {
      event.keyCode && (keyCode = event.keyCode);
      let pos = this.selectionStart;
      if (pos < 3) event.preventDefault();
      let matrix = "+7 (___) ___-__-__",
        i = 0,
        def = matrix.replace(/\D/g, ""),
        val = this.value.replace(/\D/g, ""),
        newValue = matrix.replace(/[_\d]/g, function (a) {
          return i < val.length ? val.charAt(i++) || def.charAt(i) : a;
        });
      i = newValue.indexOf("_");
      if (i != -1) {
        i < 5 && (i = 3);
        newValue = newValue.slice(0, i);
      }
      let reg = matrix
        .substr(0, this.value.length)
        .replace(/_+/g, function (a) {
          return "\\d{1," + a.length + "}";
        })
        .replace(/[+()]/g, "\\$&");
      reg = new RegExp("^" + reg + "$");
      if (
        !reg.test(this.value) ||
        this.value.length < 5 ||
        (keyCode > 47 && keyCode < 58)
      )
        this.value = newValue;
      if (event.type == "blur" && this.value.length < 5) this.value = "";
    }

    inputPhone.addEventListener("input", Mask, false);
    inputPhone.addEventListener("focus", Mask, false);
    inputPhone.addEventListener("blur", Mask, false);
    inputPhone.addEventListener("keydown", Mask, false);

    //клик по кнопке сохранить
    let btnSave = document.querySelector(".account_btn-save");

    btnSave.addEventListener("click", function (e) {
      e.preventDefault();

      // let name = document.querySelector("#account_personal-name").value;
      // let lastName = document.querySelector("#account_personal-lastName").value;
      // if (name.length > 0 || lastName.length > 0) {
      //   function ucFirst(str) {
      //     if (!str) return str;

      //     return str[0].toUpperCase() + str.slice(1);
      //   }
      //   document.querySelector(".account_personal-name").innerText = `${ucFirst(
      //     name
      //   )} ${ucFirst(lastName)}`;
      //   document.querySelector(".account_fullname").innerText = `${ucFirst(
      //     name
      //   )} ${ucFirst(lastName)}`;
      // }

      let avatar = $('input[name="account_input-img"]').val();
      let gender = $('input[name="account_input-gender"]').val();
      let age = $('input[name="account_input-age"]').val();
      let first_name = $('input[name="account_input-firstName"]').val();
      let last_name = $('input[name="account_input-lastName"]').val();
      let email = $('input[name="account_input-email"]').val();
      let tel = $('input[name="account_input-tel"]').val();


      let formData = new FormData();
      formData.append("avatar", avatar);
      formData.append("gender", gender);
      formData.append("age", age);
      formData.append("first_name", first_name);
      formData.append("last_name", last_name);
      formData.append("tel", tel);
      formData.append("email", email);

      //обьект ajax со св-ми ,как было у формы.
      $.ajax({
        url: "account_check",
        type: "POST",
        dataType: "json",
        processData: false,
        contentType: false,
        cache: false,
        data: formData,
        success: function (data) {
          if (data.status) {
            // window.location.href = 'account';
            console.log(data)
          } else {

          }
        },
        error: function (jqxhr, status, errorMsg) {
          console.log(status, errorMsg);
        },
      });
    });
  }
})();
