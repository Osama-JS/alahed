



$(document).ready(function(){


  // Example starter JavaScript for disabling form submissions if there are invalid fields
  (() => {
    'use strict'

    // handle radio checkx
    document.querySelectorAll('.custom-radio-input').forEach(radio => {
      radio.addEventListener('change', function() {
        document.querySelectorAll('.radio-box').forEach(box => {
          box.classList.remove('checked');
        });

        if (this.checked) {
          this.closest('.radio-box').classList.add('checked');
        }
      });
    });


    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    const forms = document.querySelectorAll('.needs-validation')

    // Loop over them and prevent submission
    Array.from(forms).forEach(form => {
      form.addEventListener('submit', event => {
        if (!form.checkValidity()) {
          event.preventDefault()
          event.stopPropagation()
        }

        form.classList.add('was-validated')
      }, false)
    })
  })()


  $('#datepicker').datepicker({
    format: 'mm/dd/yyyy',
    autoclose: true,
    todayHighlight: true
  });

  $('#expected_arrival_date').datepicker({
    format: 'mm/dd/yyyy',
    autoclose: true,
    todayHighlight: true
  });


  // document.addEventListener('show.bs.modal', function (event) {
  //     var backdrop = document.querySelector('.modal-backdrop');
  //     if (backdrop) {
  //         backdrop.classList.add('custom-backdrop');
  //     }
  // });


});
