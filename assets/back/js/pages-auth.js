/**
 *  Pages Authentication
 */

// 'use strict';
const formAuthentication = document.querySelector('#formAuthentication');
const submitButton = formAuthentication.querySelector('[type="submit"]');

window.Helpers.initPasswordToggle();

document.addEventListener('DOMContentLoaded', function (e) {
  (function () {
    // Form validation for Add new record
    if (formAuthentication) {
      var fv = FormValidation.formValidation(formAuthentication, {
        fields: {
          fullname: {
            validators: {
              notEmpty: {
                message: 'Harap masukkan nama lengkap anda'
              }
            }
          },
          contact_person: {
            validators: {
              notEmpty: {
                message: 'Harap masukkan nomor telepon anda'
              },
              regexp: {
                  regexp: /^(?!\+62|62|0)/i,
                  message: 'Tidak perlu diawali 0/62/+62'
              }
            }
          },
          origin: {
            validators: {
              notEmpty: {
                message: 'Harap masukkan asal IBM anda'
              }
            }
          },
          address: {
            validators: {
              notEmpty: {
                message: 'Harap masukkan alamat anda'
              }
            }
          },
          province: {
            validators: {
              notEmpty: {
                message: 'Harap masukkan provinsi tempat anda tinggal'
              }
            }
          },
          city: {
            validators: {
              notEmpty: {
                message: 'Harap masukkan kota tempat anda tinggal'
              }
            }
          },
          district: {
            validators: {
              notEmpty: {
                message: 'Harap masukkan kecamatan tempat anda tinggal'
              }
            }
          },
          village: {
            validators: {
              notEmpty: {
                message: 'Harap masukkan desa tempat anda tinggal'
              }
            }
          },
          profession: {
            validators: {
              notEmpty: {
                message: 'Harap masukkan pekerjaan anda'
              }
            }
          },
          username: {
            validators: {
              notEmpty: {
                message: 'Harap masukkan username'
              },
              regexp: {
                    regexp: /^(?=[a-zA-Z0-9._]{5,30}$)(?!.*[_.]{2})[^_.].*[^.]$/i,
                    // https://stackoverflow.com/questions/12018245/regular-expression-to-validate-username
                    message: 'username hanya menerima alfa numerik, titik(.), tanda hubung (-) dan garis bawah (_) dengan minimal 5 karakter',
                },
            }
          },
          email: {
            validators: {
              notEmpty: {
                message: 'Harap masukkan email anda'
              },
              emailAddress: {
                message: 'Masukkan alamat email yang valid'
              }
            }
          },
          'email-username': {
            validators: {
              notEmpty: {
                message: 'Harap masukkan email/username'
              }
            }
          },
          password: {
            validators: {
              notEmpty: {
                message: 'Harap masukkan email/username'
              },
              stringLength: {
                min: 3,
                message: 'Password minimal 5 karakter'
              }
            }
          },
          'new-password': {
            validators: {
              notEmpty: {
                message: 'Harap masukkan password anda'
              },
              stringLength: {
                min: 5,
                message: 'Password minimal 5 karakter'
              },
            //   regexp: {
            //     regexp: /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[^A-Za-z0-9\s]).{8,}$/g,
            //     message: "Password harus mengandung setidaknya 1 huruf kecil, 1 huruf besar, 1 angka dan 1 simbol dengan minimal 8 karakter",
            //   }
            }
          },
          'confirm-password': {
            validators: {
              notEmpty: {
                message: 'Harap masukkan konfirmasi password anda'
              },
              identical: {
                compare: function () {
                  return formAuthentication.querySelector('[name="new-password"]').value;
                },
                message: 'Konfirmasi password tidak sama dengan password'
              }
            }
          },
          terms: {
            validators: {
              notEmpty: {
                message: 'Harap setujui syarat dan ketentuan yang berlaku'
              }
            }
          }
        },
        plugins: {
          trigger: new FormValidation.plugins.Trigger(),
          bootstrap5: new FormValidation.plugins.Bootstrap5({
            eleValidClass: '',
            rowSelector: '.mb-3'
          }),
          submitButton: new FormValidation.plugins.SubmitButton(),

        //   defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
          autoFocus: new FormValidation.plugins.AutoFocus(),
            fieldStatus: new FormValidation.plugins.FieldStatus({
                onStatusChanged: function(areFieldsValid) {
                    areFieldsValid
                        // Enable the submit button
                        // so user has a chance to submit the form again
                        ? submitButton.removeAttribute('disabled')
                        // Disable the submit button
                        : submitButton.setAttribute('disabled', 'disabled');
                }
            }),
        },
        init: instance => {
          instance.on('plugins.message.placed', function (e) {
            if (e.element.parentElement.classList.contains('input-group')) {
              e.element.parentElement.insertAdjacentElement('afterend', e.messageElement);
            }
          });
        }
      }).on('core.form.valid', function(e) {
          submitForm();
            // formAuthentication.querySelector('button').removeAttribute("disabled");
        });
    }
    
    $('#province').on('change', function () {
        fv.revalidateField('province');
    });
    $('#city').on('change', function () {
        fv.revalidateField('city');
    });
    $('#district').on('change', function () {
        fv.revalidateField('district');
    });
    $('#village').on('change', function () {
        fv.revalidateField('village');
    });
    
    //  Two Steps Verification
    // const numeralMask = document.querySelectorAll('.numeral-mask');

    // // Verification masking
    // if (numeralMask.length) {
    //   numeralMask.forEach(e => {
    //     new Cleave(e, {
    //       numeral: true
    //     });
    //   });
    // }
  })();
});
