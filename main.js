$(document).ready(function () {
  // loader
  // $(".loader-wrapper").fadeOut("slow");

  $(".menu__icon").click(() => {
  $(".body_taskbar").toggleClass('transidebar')
  $(".main__content").toggleClass("tran__main-content")
  });
  $('.list__type-account').click(() =>{
  $(".dropdown-menu").toggleClass("change__display")
  })
  
  $('#exampleModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var recipient = button.data('whatever') // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this)
    modal.find('.modal-title').text('New message to ' + recipient)
    modal.find('.modal-body input').val(recipient)
  });
});


