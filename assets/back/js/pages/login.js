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
          username: {
            validators: {
              notEmpty: {
                message: 'Harap masukkan username'
              },
              regexp: {
                    regexp: /^(?=[a-zA-Z0-9._]{5,30}$)(?!.*[_.]{2})[^_.].*[^.]$/i,
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
    
  })();
});
